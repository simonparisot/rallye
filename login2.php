<?php

/* ---------------------------------------------------------------------------------------------------
 * User authentication
 * Year specific features should be kept in the majSession() function stored in initialize.php
 * --------------------------------------------------------------------------------------------------- */

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
}elseif( isset($_POST['code']) && $_POST['code']!='' ) {

	$loginfailed = "Code de connexion incorrect";

	$sth = $bdd->prepare('SELECT * FROM rallyecommon.users2 WHERE code = :pwd LIMIT 1');
	if ($sth->execute(array(':pwd' => $_POST['code']))) {
		$user = $sth->fetchAll();
		
		// if code exist in user DB
		if( count($user) > 0 ) { 
			$user = $user[0];

			// juste pour bloquer la connexion jusqu'au lancement ! lancement : 1671659280 // real
			// juste pour bloquer la connexion jusqu'au lancement ! lancement : 1671656313 // now
			// juste pour bloquer la connexion jusqu'au lancement ! lancement : 1671656160 // test
			if( $user['email']=="rallyehiver2023@gmail.com" || $user['email']=="parisot.simon@gmail.com" || time()>1671659280 ){
			
				// anti-bruteforce
				sleep(2); 

				// retrieving the informations about the team for this specific edition of the rallye
				majSession($user['email']);

				// storing a long lasting cookie to keep the user connected on this device
				$lifetime = 60*60*24*30;
				setcookie('auth', $user['code'], time() + $lifetime, '/', '.rallyehiver.fr', 1);
				
				$auth = true;
				$loginfailed = false;

				// log bdd
				$sth = $bdd->prepare('INSERT INTO rallye_log (ip, equipe, log) VALUES (:ip, :equipe, :log)');
				$sth->execute(array(':ip' => $_SERVER["REMOTE_ADDR"], ':equipe' => $_SESSION['nom'], ':log' => 'Form login'));

			}else{
				$loginfailed = "Halte-là ! Il n'est pas un peu tôt pour se connecter ?<br>Revenez au solstice, à 22h48 ;)";
			}
		}
	}



// user already has an active session
}elseif( isset($_SESSION['email']) ) {

	majSession($_SESSION['email']);
	$auth = true;


// user provide a long lasting cookie
}elseif( isset($_COOKIE['auth']) ) {

	$sth = $bdd->prepare('SELECT * FROM rallyecommon.users2 WHERE code = :code LIMIT 1');
	if ($sth->execute(array(':code' => $_COOKIE['auth']))) {
		$user = $sth->fetchAll();

		// if code exist in user DB
		if( count($user) > 0 ) {
			$user = $user[0];

			// anti-bruteforce
			sleep(2);

			// retrieving the informations about the team for this specific edition of the rallye
			majSession($user['email']);
			
			$auth = true;

			// log bdd
			$sth = $bdd->prepare('INSERT INTO rallye_log (ip, equipe, log) VALUES (:ip, :equipe, :log)');
			$sth->execute(array(':ip' => $_SERVER["REMOTE_ADDR"], ':equipe' => $_SESSION['nom'], ':log' => 'Cookie login'));	
		}
	}
}

?>
