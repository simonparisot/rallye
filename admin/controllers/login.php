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

	global $bdd;
	$sth = $bdd->prepare('SELECT * FROM rallye_people WHERE login = :login LIMIT 1');
	if ($sth->execute(array(':login' => $user['login']))) {
		$editionData = $sth->fetchAll();
		
		if( count($editionData) == 0 ){
			// if user does not exist for this edition, we create it (that is only for migration to unified login)
			$sth = $bdd->prepare("INSERT INTO rallye_people (nom, login, pwd, unlocked, token) VALUES (:nom, :login, '', :unlocked, '')");
			$unlocked = '{"E01sNRdEvwG":false,"E02LzsJLTKf":false,"E03cZKvpne4":false,"E04re7Hgq9d":false,"E05q4BSryWM":false,"E06nGzJzuHZ":false,"E07FfqM7BBd":false,"E08wwTmEyCw":false,"E09jt79wRSM":false,"E10KYLyUhGY":false,"P00wiG7d67n":false,"PBONUSBONUS":false,"P01SBCdwwqc":false,"P02PdMmYs2z":false,"P03m8YQAq6p":false,"P04LzuBEawE":false,"P05EubtHzh4":false,"P06T2VxsxKk":false,"P07Q6AfQt7A":false,"E21fh74gZx9":false,"P08NFeWKhZb":false,"E11YcdRWwzc":false,"E12mSedBRcj":false,"E13D8jf7Uts":false,"E14FqqZ8N6F":false,"E15fcGWBAwF":false,"E16Jcz74Jqh":false,"E17ucgHNV8F":false,"E18NNjPUs3K":false,"P09RKJPrLcH":false,"E19EKsmu647":false,"E20RZcq4LqZ":false,"P10xtdwXzHF":false,"P11s2wzbJRN":false}';
			$sth->execute(array(':nom' => $user['nom'], ':login' => $user['login'], ':unlocked' => $unlocked));
			$editionData[0]['unlocked'] = $unlocked;
		}

		$_SESSION['login'] = $user['login'];
		$_SESSION['nom'] = $user['nom'];
		$_SESSION['admin'] = ($user['login'] == 'orga');
		$_SESSION['unlocked'] = json_decode($editionData[0]['unlocked'], true);
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