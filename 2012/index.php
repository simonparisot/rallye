﻿<?php

// reprise du site, j'ignore les warning et deprecated... c'est un vieux site !
// error_reporting(E_ERROR | E_PARSE);

// -----------------------------------------------------------------------------------------
//
//	Site du Rallye d'Hiver 2012
//	Intégration et graphisme : Simon Parisot (parisot.simon at gmail.com)
//
// -----------------------------------------------------------------------------------------

// Définition du temps d'expiration des cookies
$expiration = time() + (3*30*24*60*60);
$page = 'accueil';
if(isset($_GET["page"])){ $page = $_GET["page"]; }

/*----- Supression de l'authentification utilisateur en mars 2020 / remplacé par une authentification automatique ----- */
require_once 'db.php';
setcookie("_nom_equipe", 'Simon', $expiration);
setcookie("_id_equipe", 2, $expiration);
$login = 2;
// récupération des questionnaires débloqués
$res = mysqli_query($link, "SELECT questionnaire, bonus, upload, indices FROM `comptes_utilisateurs` WHERE id = 2");
$element = mysqli_fetch_array($res);
$data = unserialize($element['questionnaire']);

$indices = $element['indices'];
$dossierOK = $element['upload'];
$bonus = $element['bonus'];
if($bonus%5 == 0)$bonusLoc = 'opus_diner_1_46ef5.pdf';
if($bonus%5 == 1)$bonusLoc = 'opus_diner_2_ek53r.pdf';
if($bonus%5 == 2)$bonusLoc = 'opus_diner_3_g75h6.pdf';
if($bonus%5 == 3)$bonusLoc = 'opus_diner_4_cr6i5.pdf';
if($bonus%5 == 4)$bonusLoc = 'opus_diner_5_k8fh7.pdf';

mysqli_close($link);

/*----- Supression de l'authentification utilisateur en mars 2020 / remplacé par une authentification automatique -----

if(isset($_GET["message"])){ $message = "<font color=orange>Vous n'&ecirc;tes pas identifi&eacute; actuellement, veuillez vous connecter pour effectuer cette op&eacute;ration. Merci !</font>"; }

$login = false;

if(isset($_GET["deco"]))
{
	// Suppression des cookies
	unset($_COOKIE["_id_equipe"]);
	unset($_COOKIE["_nom_equipe"]);
	setcookie("_id_equipe", "", time() - 3600);
	setcookie("_nom_equipe", "", time() - 3600);
	$page = 'connexion';
	
	
}
elseif(isset($_POST["login"]))
{
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
		
		// Récupération des infos de la BDD
		$result = mysqli_query($link, "	SELECT id, nom, login, password
								FROM comptes_utilisateurs
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
				if(crypt($_POST["pwd"], "bob") == $row["password"] || crypt($_POST["pwd"], "bob") == "boFz6uG3z7ajc")
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
	
}
elseif(isset($_COOKIE["_id_equipe"]))
{
	// récupération de l'id du visiteur
	$login = $_COOKIE["_id_equipe"];
	
	$db = mysqli_select_db('rallyehiver2012', $link);
	
	// Récupération des infos de la BDD
	$result = mysqli_query($link, "	SELECT nom
							FROM comptes_utilisateurs
							WHERE id = '" . $login . "'
	");
	$row = mysqli_fetch_array($result);
	
	// Si une erreur survient
	if(!$result)
	{
		$message = "Une erreur est survenue lors de la tentative de connexion BDD : ". mysqli_error($link);
	}
	elseif($_COOKIE["_nom_equipe"] != $row["nom"])
	{
		$login = false;
		$page = 'accueil';
	}
	else
	{
		//récupération des questionnaires débloqués
		$res = mysqli_query($link, "SELECT questionnaire, bonus, upload, indices
							FROM `comptes_utilisateurs`
							WHERE id = ".mysqli_real_escape_string($link, $_COOKIE["_id_equipe"]));
		$element = mysqli_fetch_array($res);
		$data = unserialize($element['questionnaire']);
		$indices = $element['indices'];
		$dossierOK = $element['upload'];
		$bonus = $element['bonus'];
		if($bonus%5 == 0)$bonusLoc = 'opus_diner_1_46ef5.pdf';
		if($bonus%5 == 1)$bonusLoc = 'opus_diner_2_ek53r.pdf';
		if($bonus%5 == 2)$bonusLoc = 'opus_diner_3_g75h6.pdf';
		if($bonus%5 == 3)$bonusLoc = 'opus_diner_4_cr6i5.pdf';
		if($bonus%5 == 4)$bonusLoc = 'opus_diner_5_k8fh7.pdf';
		
		if(isset($_POST["change_pwd1"]) && $_POST["change_pwd1"]==$_POST["change_pwd2"])
		{
			$new_pwd = crypt($_POST["change_pwd1"], "bob");
			$result = mysqli_query($link, "	UPDATE `comptes_utilisateurs` 
									SET `password` = '".$new_pwd."' 
									WHERE `comptes_utilisateurs`.`id` = '".mysqli_real_escape_string($link, $_COOKIE["_id_equipe"])."' 
									LIMIT 1 
			");
			$page = 'perso';
			$mdp_ok = true;
		}
		
		if(isset($_POST["board"]))
		{
			$comment = mysqli_real_escape_string($link, stripslashes($_POST["board"]));
			mysqli_query($link, "	INSERT INTO `rallyedh_rallye`.`commentaires` (`id` , `date` , `auteur` , `text`)
							VALUES (NULL , NOW( ) , '".$_COOKIE["_nom_equipe"]."', '".$comment."') 
			");
			$page = 'perso';
			$comment_ok = true;
		}
		
		if($login == 1){include 'avancement.php';}
	}
	
	// Fermeture de la connexion à la base de données
	mysqli_close($link);
}

----- Supression de l'authentification utilisateur en mars 2020 ----- */

include'main-end.php';
?>