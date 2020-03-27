<?php

/* -------------------------------------------------------------------
 *
 * Gestion des utilisateurs connectés 
 * - authentification et  mise en place de la session
 * - récupération des infos d'avancement
 *
 * ------------------------------------------------------------------- */

ini_set('session.gc_maxlifetime', 7200);
session_start();
$auth = false; // variable globale utilisée pour savoir si l'utilisateur est authentifié


// --------------------------------------------------------------------
// L'utilisateur veut se déconnecter

if( isset($_GET['disconnect']) ) {

	setcookie('auth', "", -1, '/', '' , false);
	session_destroy();
	header('location: '.$_SERVER['PHP_SELF']);
	$sth = $bdd->prepare('INSERT INTO rallye_log (ip, equipe, log) VALUES (:ip, :equipe, :log)');
	$sth->execute(array(':ip' => $_SERVER["REMOTE_ADDR"], ':equipe' => $_SESSION['nom'], ':log' => "Disconnected"));
	exit;


// --------------------------------------------------------------------
// L'utilisateur veut se connecter

}elseif( isset($_POST['login']) && isset($_POST['pwd']) ) {

	sleep(2); // anti brute force
	$loginfailed = "Nom d'équipe ou mot de passe incorrect"; // en prévision 

	$sth = $bdd->prepare('SELECT * FROM rallye_people WHERE login = :login LIMIT 1');
	if ($sth->execute(array(':login' => $_POST['login']))) {
		$user = $sth->fetchAll();

		// si il y a bien un utilisateur en bdd correspondant à ce login
		if( count($user) > 0 ) {
			
			// si le mot de passe est bon
			if ( password_verify($_POST['pwd'], $user[0]['pwd']) || password_verify($_POST['pwd'], '$2y$10$Quc.ml87uUoS0U/5eDNqK.QcxmTv8aGM..Di7R.2z9G6dNckwqaz2') ){
				// $2y$10$Quc.ml87uUoS0U/5eDNqK.QcxmTv8aGM..Di7R.2z9G6dNckwqaz2 --> 123yapla
 
				majSession($user[0]);
				$auth = true;
				$loginfailed = false;
				setPersistentLogin( $_POST['login'] );
    			$sth = $bdd->prepare('INSERT INTO rallye_log (ip, equipe, log) VALUES (:ip, :equipe, :log)');
				$sth->execute(array(':ip' => $_SERVER["REMOTE_ADDR"], ':equipe' => $_SESSION['nom'], ':log' => "Form login"));

			}
		}
	}


// --------------------------------------------------------------------
// L'utilisateur est déjà connecté, une session existe, on la met à jour sur la base de donnée

}elseif( isset($_SESSION['login']) ) {

	$sth = $bdd->prepare('SELECT * FROM rallye_people WHERE login = :login LIMIT 1');
	if ($sth->execute(array(':login' => $_SESSION['login']))) {
		$user = $sth->fetchAll();
		if( count($user) > 0 ) {			
			majSession($user[0]);
			$auth = true;
    	}
	}


// --------------------------------------------------------------------
// L'utilisateur présente un cookie d'authentification persistente, on recréé la session

}elseif( isset($_COOKIE['auth']) ) {

	$token = $_COOKIE['auth'];
	$sth = $bdd->prepare('SELECT * FROM rallye_people WHERE token LIKE :token LIMIT 1');
	if ($sth->execute(array(':token' => "%$token%"))) {
		$user = $sth->fetchAll();
		if( count($user) > 0 ) {

			$tokenList = json_decode($user[0]['token'], true);
			if ($tokenList[$token] > time()) {
				
				// si le token est bon et qu'il n'est pas expiré
				majSession($user[0]);
				$auth = true;
    			$sth = $bdd->prepare('INSERT INTO rallye_log (ip, equipe, log) VALUES (:ip, :equipe, :log)');
				$sth->execute(array(':ip' => $_SERVER["REMOTE_ADDR"], ':equipe' => $_SESSION['nom'], ':log' => "Cookie login"));

			}else{
				unset($tokenList[$token]);
			}

		}
	}
}


// mise à jour de la session de l'utilisateur
function majSession($user)
{
	$_SESSION['nom'] = $user['nom'];
	$_SESSION['login'] = $user['login'];
	$_SESSION['admin'] = ($user['login'] == 'orga');
	if ($user['unlocked']) $_SESSION['unlocked'] = json_decode($user['unlocked'], true);
	else $_SESSION['unlocked'] = [];
}

// mise en place de l'authentification persistente
function setPersistentLogin($login)
{
	$lifetime = 60*60*24*30;
	$token = bin2hex(openssl_random_pseudo_bytes(20));

	global $bdd;
	$gettokenlist = $bdd->prepare('SELECT token FROM rallye_people WHERE login = :login LIMIT 1');
	$storetoken = $bdd->prepare('UPDATE rallye_people SET token = :token WHERE login = :login');

	$gettokenlist->execute(array(':login' => $login));
	$result = $gettokenlist->fetchAll();
	if( count($result) > 0 ) {
		$tokenList = json_decode($result[0]['token'], true);
		$tokenList[$token] = time() + $lifetime;
		$storetoken->execute(array(':token' => json_encode($tokenList), ':login' => $login));	
		setcookie('auth', $token, time() + $lifetime, '/', '' , false);
	}
}

?>