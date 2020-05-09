<?php

/* ------------------------------------------------------------------------
 * User authentication
 * Edition specific features should be kept in the majSession() function
 * ------------------------------------------------------------------------ */

ini_set('session.gc_maxlifetime', 7200);
session_start();
$auth = false;



// user wants to disconnect
if( isset($_GET['disconnect']) ) {

	setcookie('auth', "", -1, '/', '.rallyehiver.fr', 1);
	session_destroy();
	header('location: '.$_SERVER['PHP_SELF']);
	$sth = $bdd->prepare('INSERT INTO rallye_log (ip, equipe, log) VALUES (:ip, :equipe, :log)');
	$sth->execute(array(':ip' => $_SERVER["REMOTE_ADDR"], ':equipe' => $_SESSION['nom'], ':log' => "Disconnected"));
	exit;


// user wants to login 
}elseif( isset($_POST['login']) && isset($_POST['pwd']) ) {

	$loginfailed = "Nom d'équipe ou mot de passe incorrect";
	$sth = $bdd->prepare('SELECT * FROM rallyecommon.users WHERE login = :login LIMIT 1');
	if ($sth->execute(array(':login' => $_POST['login']))) {
		$user = $sth->fetchAll();
		if( count($user) > 0 ) {
			$user = $user[0];

			// login exists, we verify the password
			if ( password_verify($_POST['pwd'], $user['password']) ) { 
				
				// password is verified, user is logged in
				majSession($user);
				setPersistentLogin($user['login']);
				$auth = true;
				$loginfailed = false;

				// log bdd
				$sth = $bdd->prepare('INSERT INTO rallye_log (ip, equipe, log) VALUES (:ip, :equipe, :log)');
				$sth->execute(array(':ip' => $_SERVER["REMOTE_ADDR"], ':equipe' => $_SESSION['nom'], ':log' => 'Form login'));
			}
		}
	}


// user already has an active session
}elseif( isset($_SESSION['login']) ) {

	majSession($_SESSION);
	$auth = true;


// user provide a long lasting SSO token
}elseif( isset($_COOKIE['auth']) ) {

	$token = explode("__", $_COOKIE['auth']);
	$login = $token[0];
	$token = $token[1];

	$sth = $bdd->prepare('SELECT * FROM rallyecommon.users WHERE login = :login LIMIT 1');
	if ($sth->execute(array(':login' => $login))) {
		$user = $sth->fetchAll();
		if( count($user) > 0 ) {
			$user = $user[0];

			// login exists, we verify the token
			$tokenList = json_decode($user['token'], true);
			if ($tokenList[$token] > time()) {

				// token is ok, user is logged in
				majSession($user);
				setPersistentLogin($user['login']);
				$auth = true;

				// log bdd
				$sth = $bdd->prepare('INSERT INTO rallye_log (ip, equipe, log) VALUES (:ip, :equipe, :log)');
				$sth->execute(array(':ip' => $_SERVER["REMOTE_ADDR"], ':equipe' => $_SESSION['nom'], ':log' => 'Token login'));
			}			
		}
	}
}

// function that updates the session with common infos (name, login, ...) and edition specific features (unlocked content, ...)
function majSession($user) {

	// user is logged in, we want to refresh data in session
	global $bdd;
	$sth = $bdd->prepare('SELECT * FROM rallye_people WHERE login = :login LIMIT 1');
	if ($sth->execute(array(':login' => $user['login']))) {
		$editionData = $sth->fetchAll();
		
		if( count($editionData) == 0 ){
			// if user does not exist for this edition, we create it (that's for migration to unified login)
			$sth = $bdd->prepare("INSERT INTO rallye_people (nom, login, pwd, enigmes, quest, token, contact, indices) VALUES (:nom, :login, '', '', :quest, '', '', 0)");
			$quest = '["q6ktqn8n64","9nejv8ffgv","rakl26jbu9","7xp2fvpux7","c12m85wqay","62ygx5pcx3","gkehb0p5iv","q0gwu3mnhp","kq4set7edj"]';
			$sth->execute(array(':nom' => $user['nom'], ':login' => $user['login'], ':quest' => $quest));
			$editionData[0]['quest'] = $quest;
			$editionData[0]['jetlag'] = '';
		}

		$_SESSION['login'] = $user['login'];
		$_SESSION['nom'] = $user['nom'];
		$_SESSION['admin'] = ($user['login'] == 'terpsichore');
		$_SESSION['someQuest'] = count(json_decode($editionData[0]['quest'], true)) != 0;
		$_SESSION['jetlag'] = $editionData[0]['jetlag'];
	}
}

// set a long lasting SSO token
function setPersistentLogin($login) {

	$lifetime = 60*60*24*30;
	$token = bin2hex(openssl_random_pseudo_bytes(20));

	global $bdd;
	$gettokenlist = $bdd->prepare('SELECT token FROM rallyecommon.users WHERE login = :login LIMIT 1');
	$storetoken = $bdd->prepare('UPDATE rallyecommon.users SET token = :token WHERE login = :login');

	$gettokenlist->execute(array(':login' => $login));
	$result = $gettokenlist->fetchAll();
	$tokenList = json_decode($result[0]['token'], true);
	$tokenList[$token] = time() + $lifetime;
	$storetoken->execute(array(':token' => json_encode($tokenList), ':login' => $login));

	setcookie('auth', $login.'__'.$token, time() + $lifetime, '/', '.rallyehiver.fr', 1);
}

?>