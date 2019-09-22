<?php

if(isset($_COOKIE["_id_equipe"])){

	// vérification d'un mot de passe/numéro d'énigme
	if(isset($_GET['t'])){
			
		// connexion à MySQL
		$link = mysql_connect("localhost", "rallyedh_simon", "6778");
		$db = mysql_select_db('rallyedh_rallye', $link);

		include 'pancakes.php';
		
		$ok = "false~Désolé, ce n'est pas le bon mot de passe ou le numéro d'énigme ne correspond pas.<br><br>";
		$okSimple = false;
		$wrong = true;
		
		//comparaison avec les vrais mots de passe
		foreach ($mdp as $cle => $valeur){
			if($valeur == $_GET['t'] && $cle+1 == $_GET['y']){
				$okSimple = true;
				$ok = 'true~';
				$ok .= $quest[$cle].'~';
				$ok .= $lieu[$cle].'~';
				$ok .= $lieu2[$cle].'~';
				$ok .= $youpi[$cle];
				$wrong = false;
				break;
			}
		}
		
		// cas particulier pour les énigmes diner
		if($_GET['y'] == 22 && ($_GET['t'] == 'lacremaillere1900' || $_GET['t'] == 'cremaillere1900')){
			$okSimple = true;
			$ok = 'true~';
			$ok .= 'http://www.cremaillere1900.com~';
			$ok .= 'La Crémaillère 1900~';
			$ok .= '15 Place du Tertre, Paris 18ème~';
			$wrong = false;
		}
		
		//on stocke le mot de passe dans la BDD pour vérifier le temps entre chaque essai
		$res = mysql_query("SELECT guess
							FROM `Comptes_Utilisateurs`
							WHERE id = ".mysql_real_escape_string($_COOKIE['_id_equipe']));

		$element = mysql_fetch_array($res);
		$data = unserialize($element['guess']);
		array_push($data, $_GET["new"]."~".time());
			
		mysql_query("	UPDATE `Comptes_Utilisateurs` 
						SET `guess` = '".serialize($data)."' 
						WHERE `Comptes_Utilisateurs`.`id` =".mysql_real_escape_string($_COOKIE['_id_equipe'])." 
						LIMIT 1" );

							
		//si le mot de passe n'est pas valide
		if($wrong){
			$okSimple = false;
			$ok = 'false~';
			
			// on cherche un easter egg dans la base de donnée
			$req = mysql_query("	SELECT reponse
									FROM `easter_eggs` 
									WHERE `easter_eggs`.`mdp` ='".mysql_real_escape_string($_GET['t'])."' 
									LIMIT 1" );
			$easter = mysql_fetch_array($req);
			if($easter != ''){
				$ok .= $easter['reponse'];
			}elseif($_COOKIE['_id_equipe'] == 36 && $_GET['y'] == 15){
				$res = mysql_query("SELECT COUNT(*) AS nb FROM `log` WHERE (`equipe` = '".$_COOKIE['_nom_equipe']."' AND `enigme` = 15)");
				$element = mysql_fetch_array($res);
				$nb = $element['nb'];
				if($nb > 248){
					$ok .= "Désolé, ce n'est pas le bon mot de passe ou le numéro d'énigme ne correspond pas.<br/><br/>";
					$ok .= "Chère équipe Verseau : Vous avez déjà tenté ".($nb+1)." mots de passes erronés pour cet opus 'Cycles' ! ";
					$ok .= "Nous vous assurons pourtant que la solution de cette énigme n'est pas trouvable \"au hasard\". ";
					$ok .= "N'hésitez pas à nous demander un indice si vous bloquez sur cette énigme qui, il est vrai, est une des plus difficile de ce rallye ;)<br/><br/>";
					$ok .= "<font color=\"#333\">Simon, équipe Terpsichore</font>";
				}else{
					$ok .= "Désolé, ce n'est pas le bon mot de passe ou le numéro d'énigme ne correspond pas.";				
				}
			}else{
				$ok .= "Désolé, ce n'est pas le bon mot de passe ou le numéro d'énigme ne correspond pas.";
			}
		}elseif($_GET['y'] == 22 && !$wrong){
		
			// On incrémente de 5 le numéro de l'énigme bonus stocké en BDD pour signifier que l'énigme est résolue mais tout de même garder l'info sur quelle énigme a été choisie
			mysql_query("	UPDATE `Comptes_Utilisateurs` 
							SET `bonus` = `bonus`+5
							WHERE `Comptes_Utilisateurs`.`id` =".mysql_real_escape_string($_COOKIE['_id_equipe'])." 
							LIMIT 1" );
		}
		
		// on écrit le mot de passe testé dans le log (si non admin)
		if($_COOKIE["_id_equipe"] != 1){
			mysql_query("	INSERT INTO `rallyedh_rallye`.`log` (`id`, `date`, `equipe`, `mdp`, `enigme`, `ok`) 
							VALUES (	NULL, 
										NOW(), 
										'".mysql_real_escape_string($_COOKIE["_nom_equipe"])."', 
										'".mysql_real_escape_string($_GET['t'])."', 
										'".mysql_real_escape_string($_GET['y'])."', 
										'".$okSimple."'
									);
			");
		}
		
		echo $ok;
	}



	// stockage d'un nouveau questionnaire débloqué
	if(isset($_GET["store"])){

		$link = mysql_connect("localhost", "rallyedh_simon", "6778");
		$db = mysql_select_db('rallyedh_rallye', $link);
		
		$res = mysql_query("SELECT questionnaire
							FROM `Comptes_Utilisateurs`
							WHERE id = ".mysql_real_escape_string($_COOKIE['_id_equipe']));

		$element = mysql_fetch_array($res);
		$data = unserialize($element['questionnaire']);
		
		$data[$_GET["y"]-1]=$_GET["store"].'~'.$_GET["lieu"];
		
		$res2 = mysql_query("UPDATE `Comptes_Utilisateurs` SET `questionnaire` = '".serialize($data)."' WHERE `Comptes_Utilisateurs`.`id` =".mysql_real_escape_string($_COOKIE['_id_equipe'])." LIMIT 1" );
	}


	// vérification du timing pour le mot de passe
	if(isset($_GET["mdp"])){

		$link = mysql_connect("localhost", "rallyedh_simon", "6778");
		$db = mysql_select_db('rallyedh_rallye', $link);
		
		$res = mysql_query("SELECT guess
							FROM `Comptes_Utilisateurs`
							WHERE id = ".mysql_real_escape_string($_COOKIE['_id_equipe']));

		$element = mysql_fetch_array($res);
		$data = unserialize($element['guess']);
		$ok = true;
		
		foreach ($data as $cle => $valeur){
			$v = explode("~", $valeur);
			if($v[0] == $_GET['mdp']){													//si le mot de passe a déjà été testé avant
				if((time() - (int)$v[1]) < (60*60*4) && (time() - (int)$v[1]) > 1){			//on renvoie false si le temps est inférieur à 4h
					$ok = false;
				}else{																		//on renvoie false si le temps est supérieur à 4h
					unset($data[$cle]);
					$ok = true;
				}
			}else{																	// si un mot de passe enregistré n'est pas celui testé, on le supprime si il est trop vieux.
				if((time() - (int)$v[1]) > (60*60*4)){
					unset($data[$cle]);
				}
			}
		}
		mysql_query("	UPDATE `Comptes_Utilisateurs` 
						SET `guess` = '".serialize($data)."' 
						WHERE `Comptes_Utilisateurs`.`id` =".mysql_real_escape_string($_COOKIE['_id_equipe'])." 
						LIMIT 1" );
						
		// si on tente de faire une RAZ, on RAZ ...
		if($_GET['mdp'] == "sudo raz"){
			$log = fopen('log.txt', 'r+');
			ftruncate($log,0);
			fputs($log,"---- Log des tests de mot de passe eronnes dans l'onglet questionnaire ----\n\n");
			fclose($log);
		}
		
		if($_COOKIE["_id_equipe"] == 1){$ok = true;}
		echo $ok;

	}

}else{
	
	//si l'utilisateur n'est pas connecté, on n'analyse rien, on renvoie un code qui entrainera une redirection directe vers la page de connexion
	echo 'loginfail';
	
}

?>
