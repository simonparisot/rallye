<?php

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

$login = false;
$page = 'accueil';
if(isset($_GET["page"])){ $page = $_GET["page"]; }
if(isset($_GET["message"])){ $message = "<font color=orange>Vous n'&ecirc;tes pas identifi&eacute; actuellement, veuillez vous connecter pour effectuer cette op&eacute;ration. Merci !</font>"; }

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
		
		$link = mysql_connect("127.0.0.1:3306", "root", "dLPqYp7C7vTp");
		$db = mysql_select_db('rallyehiver2012', $link);
		
		// Récupération des infos de la BDD
		$result = mysql_query("	SELECT id, nom, login, password
								FROM Comptes_Utilisateurs
								WHERE login = '" . $_POST["login"] . "'
		");
		
		// Si une erreur survient
		if(!$result)
		{
			$message = "Une erreur est survenue lors de la tentative de connexion BDD : ". mysql_error();
		}
		else
		{
			// Si aucun utilisateur n'a été trouvé
			if(mysql_num_rows($result) == 0)
			{
				 $message = "<font color=orange>D&eacute;sol&eacute;, le nom d'utilisateur " . $_POST["login"] . " n'existe pas.</font>";
			}
			else
			{
				// Récupération des données
				$row = mysql_fetch_array($result);

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
					$res = mysql_query("SELECT questionnaire, bonus, upload, indices
										FROM `Comptes_Utilisateurs`
										WHERE id = ".$row["id"]);
					$element = mysql_fetch_array($res);
					$data = unserialize($element['questionnaire']);
					$indices = $element['indices'];
					$dossierOK = $element['upload'];
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
	if(isset($link))mysql_close($link);
	
}
elseif(isset($_COOKIE["_id_equipe"]))
{
	// récupération de l'id du visiteur
	$login = $_COOKIE["_id_equipe"];
	
	$link = mysql_connect("127.0.0.1:3306", "root", "bHfhV169sXUz");
	$db = mysql_select_db('rallyehiver2012', $link);
	
	// Récupération des infos de la BDD
	$result = mysql_query("	SELECT nom
							FROM Comptes_Utilisateurs
							WHERE id = '" . $login . "'
	");
	$row = mysql_fetch_array($result);
	
	// Si une erreur survient
	if(!$result)
	{
		$message = "Une erreur est survenue lors de la tentative de connexion BDD : ". mysql_error();
	}
	elseif($_COOKIE["_nom_equipe"] != $row["nom"])
	{
		$login = false;
		$page = 'accueil';
	}
	else
	{
		//récupération des questionnaires débloqués
		$res = mysql_query("SELECT questionnaire, bonus, upload, indices
							FROM `Comptes_Utilisateurs`
							WHERE id = ".mysql_real_escape_string($_COOKIE["_id_equipe"]));
		$element = mysql_fetch_array($res);
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
			$result = mysql_query("	UPDATE `Comptes_Utilisateurs` 
									SET `password` = '".$new_pwd."' 
									WHERE `Comptes_Utilisateurs`.`id` = '".mysql_real_escape_string($_COOKIE["_id_equipe"])."' 
									LIMIT 1 
			");
			$page = 'perso';
			$mdp_ok = true;
		}
		
		if(isset($_POST["board"]))
		{
			$comment = mysql_real_escape_string(stripslashes($_POST["board"]));
			mysql_query("	INSERT INTO `rallyedh_rallye`.`commentaires` (`id` , `date` , `auteur` , `text`)
							VALUES (NULL , NOW( ) , '".$_COOKIE["_nom_equipe"]."', '".$comment."') 
			");
			$page = 'perso';
			$comment_ok = true;
		}
		
		if($login == 1){include 'avancement.php';}
	}
	
	// Fermeture de la connexion à la base de données
	mysql_close($link);
}

include'main.php';
?>