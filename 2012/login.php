<?php

/* -------------------------------------------------------------------
 *
 * Gestion des utilisateurs connectés 
 * - authentification et mise en place de la session
 * - récupération des infos d'avancement
 *
 * ------------------------------------------------------------------- */

// Définition du temps d'expiration des cookies
$expiration = time() + (3*30*24*60*60);
$login = false; // variable globale utilisée pour savoir si l'utilisateur est authentifié
ini_set('session.gc_maxlifetime', 7200);
session_start();


// --------------------------------------------------------------------
// L'utilisateur veut se déconnecter

if( isset($_GET['disconnect']) ) {

	setcookie('auth', "", -1, '/', '.rallyehiver.fr', 1);
	setcookie('_id_equipe', "", -1);
	setcookie('_nom_equipe', "", -1);
	session_destroy();
	$page = 'connexion';


// --------------------------------------------------------------------
// L'utilisateur veut se connecter

}elseif( isset($_POST['login']) && isset($_POST['pwd']) ) {
	
	// par défault, redirection vers la page de connexion (si le login fail)
	$page = 'connexion';
					
	// Vérification de la validité des champs
	if(!preg_match("@^[A-Za-z0-9_]{2,1000}$@", $_POST["login"]))
	{
	   $message = "<font color=orange>Votre nom d'utilisateur doit comporter entre 2 et 30 caract&egrave;res<br />\n";
	   $message .= "Il vous a &eacute;t&eacute; donn&eacute; par l'&eacute;quipe organisatrice.</font>";
	}
	else
	{
		
		require_once 'db.php';
		
		// Récupération des infos de la BDD
		$result = mysqli_query($link, "	SELECT *
								FROM rallyecommon.users
								WHERE login = '" . $_POST["login"] . "'
		");
		
		// Si une erreur survient
		if(!$result)
		{
			$message = "Une erreur est survenue lors de la tentative de connexion BDD : ". mysqli_error($link);
		}
		else
		{
			// Si aucun utilisateur n'a été trouvé
			if(mysqli_num_rows($result) == 0)
			{
				 $message = "<font color=orange>D&eacute;sol&eacute;, le nom d'utilisateur " . $_POST["login"] . " n'existe pas.</font>";
			}
			else
			{
				// Récupération des données
				$row = mysqli_fetch_array($result);

				// Vérification du mot de passe
				if ( password_verify($_POST['pwd'], $row["password"]) ) { 
				{
					// Création des cookies
					setcookie("_nom_equipe", $row["nom"], $expiration);
					setcookie("_id_equipe", $row["id"], $expiration);

					// récupération de l'id du visiteur qui se connecte
					$login = $row["id"];
					
					// redirection vers la page par défaut
					if($login==1){	$page = 'perso';	}else{	$page = 'accueil';	}
					
					// récupération des questionnaires débloqués
					$res = mysqli_query($link, "SELECT questionnaire, bonus, upload, indices
										FROM `comptes_utilisateurs`
										WHERE id = ".$row["id"]);
					$element = mysqli_fetch_array($res);
					$data = unserialize($element['questionnaire']);
					$indices = $element['indices'];
					$dossierOK = $element['upload'];
					echo $dossierOK;
					$bonus = $element['bonus'];
					if($bonus%5 == 0)$bonusLoc = 'opus_diner_1_46ef5.pdf';
					if($bonus%5 == 1)$bonusLoc = 'opus_diner_2_ek53r.pdf';
					if($bonus%5 == 2)$bonusLoc = 'opus_diner_3_g75h6.pdf';
					if($bonus%5 == 3)$bonusLoc = 'opus_diner_4_cr6i5.pdf';
					if($bonus%5 == 4)$bonusLoc = 'opus_diner_5_k8fh7.pdf';
					
					if($login == 1){include 'avancement.php';}
				}
				else
				{
					$message = "<font color=orange>Votre mot de passe est incorrect.</font>";
				}
			}
		} 
	}

	// Fermeture de la connexion à la base de données
	if(isset($link))mysqli_close($link);


// -------------------------------------------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------------------------------------------

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


// --------------------------------------------------------------------
// L'utilisateur est déjà connecté, une session existe, on la met à jour sur la base de donnée

}elseif( isset($_SESSION['login']) ) {

	majSession($_SESSION);
	$auth = true;


// --------------------------------------------------------------------
// L'utilisateur présente un cookie d'authentification persistente, on recrée la session

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

function majSession($user) {

	// user is logged in, we want to refresh data in session
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