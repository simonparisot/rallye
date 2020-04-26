<?php

// routine d'authentification à chaque appel de page
// -----------------

ini_set('session.gc_maxlifetime', 7200);
session_start();
$auth = false; // variable globale utilisée pour savoir si l'utilisateur est authentifié


// l'utilisateur a-t-il demandé une déconnexion ?
if( isset($_GET['disconnect']) ) {

	setcookie('auth', "", -1, '/', '.rallyehiver.fr', 1);	
	session_destroy();
	header('location: '.$_SERVER['PHP_SELF']);
	exit;


// si non, y a-t-il une session en cours pour un utilisateur loggé ?
}elseif( isset($_SESSION['nom']) ) {

	$auth = true;


// si non, l'utilisateur a-t-il soumis le formulaire de connexion ?
}elseif( isset($_POST['login']) && isset($_POST['pwd']) ) {

	$loginfailed = "Nom d'équipe ou mot de passe incorrect";
	$sth = $bdd->prepare('SELECT * FROM rallyecommon.users WHERE login = :login LIMIT 1');
	if ($sth->execute(array(':login' => $_POST['login']))) {
		$loginInfo = $sth->fetchAll();
		if( count($loginInfo) > 0 ) {

			// login exists, we verify the password
			if ( password_verify($_POST['pwd'], $loginInfo[0]['password']) ) { 
				
				// password is verified, we retrieve all the user's data
				$sth = $bdd->prepare('SELECT * FROM rallye_people WHERE login = :login LIMIT 1');
				if ($sth->execute(array(':login' => $loginInfo[0]['login']))) {
					
					$user = $sth->fetchAll();
					if( count($user) == 0 ){

						// if user does not exist for this edition, we create it (that's for migration to unified login)
						$sth = $bdd->prepare("INSERT INTO rallye_people (nom, login, pwd, enigmes, quest, token, contact, indices) VALUES (:nom, :login, '', '', :quest, '', '', 0)");
						$quest = ["q6ktqn8n64","9nejv8ffgv","rakl26jbu9","7xp2fvpux7","c12m85wqay","62ygx5pcx3","gkehb0p5iv","q0gwu3mnhp","kq4set7edj"];
						$sth->execute(array(':nom' => $loginInfo[0]['nom'], ':login' => $loginInfo[0]['login'], ':quest' => json_encode($quest)));

					}

					$_SESSION['login'] = $loginInfo[0]['login'];
					$_SESSION['nom'] = $loginInfo[0]['nom'];
					$_SESSION['admin'] = ($loginInfo[0]['login'] == 'terpsichore');

					$_SESSION['jetlag'] = $user[0]['jetlag'];
					$_SESSION['someQuest'] = count(json_decode($user[0]['quest'], true)) != 0;
					$auth = true;
					$loginfailed = false;
					setPersistentLogin($loginInfo[0]['login']);

	    			// log bdd
	    			$sth = $bdd->prepare('INSERT INTO rallye_log (ip, equipe, log) VALUES (:ip, :equipe, :log)');
					$sth->execute(array(':ip' => $_SERVER["REMOTE_ADDR"], ':equipe' => $_SESSION['nom'], ':log' => 'Form login'));
				}
			}
		}
	}


// si non, y a-t-il un cookie d'authentification persistente ?
}elseif( isset($_COOKIE['auth']) ) {

	$token = explode("__", $_COOKIE['auth']);
	$login = $token[0];
	$token = $token[1];

	$sth = $bdd->prepare('SELECT * FROM rallyecommon.users WHERE login = :login LIMIT 1');
	if ($sth->execute(array(':login' => $login))) {
		$loginInfo = $sth->fetchAll();
		if( count($loginInfo) > 0 ) {

			// login exists, we verify the token
			$tokenList = json_decode($loginInfo[0]['token'], true);
			if ($tokenList[$token] > time()) {

				$sth = $bdd->prepare('SELECT * FROM rallye_people WHERE login = :login LIMIT 1');
				if ($sth->execute(array(':login' => $loginInfo[0]['login']))) {
					
					$user = $sth->fetchAll();
					if( count($user) == 0 ){

						// if user does not exist for this edition, we create it (that's for migration to unified login)
						$sth = $bdd->prepare("INSERT INTO rallye_people (nom, login, pwd, enigmes, quest, token, contact, indices) VALUES (:nom, :login, '', '', :quest, '', '', 0)");
						$quest = ["q6ktqn8n64","9nejv8ffgv","rakl26jbu9","7xp2fvpux7","c12m85wqay","62ygx5pcx3","gkehb0p5iv","q0gwu3mnhp","kq4set7edj"];
						$sth->execute(array(':nom' => $loginInfo[0]['nom'], ':login' => $loginInfo[0]['login'], ':quest' => json_encode($quest)));

					}

					$_SESSION['login'] = $loginInfo[0]['login'];
					$_SESSION['nom'] = $loginInfo[0]['nom'];
					$_SESSION['admin'] = ($loginInfo[0]['login'] == 'terpsichore');

					$_SESSION['jetlag'] = $user[0]['jetlag'];
					$_SESSION['someQuest'] = count(json_decode($user[0]['quest'], true)) != 0;
					$auth = true;
					$loginfailed = false;
					setPersistentLogin($loginInfo[0]['login']);

	    			// log bdd
	    			$sth = $bdd->prepare('INSERT INTO rallye_log (ip, equipe, log) VALUES (:ip, :equipe, :log)');
					$sth->execute(array(':ip' => $_SERVER["REMOTE_ADDR"], ':equipe' => $_SESSION['nom'], ':log' => 'Form login'));
				}

			}			
		}
	}
}

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

	//setcookie('auth', $login.'__'.$token, time() + $lifetime, '/', '' , false);
	setcookie('auth', $login.'__'.$token, time() + $lifetime, '/', '.rallyehiver.fr', 1);
}

?>