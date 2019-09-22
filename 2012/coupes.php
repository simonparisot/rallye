<?php

// necessite un variable GET pour fonctionner, histoire que tout le monde ne vienne pas mettre son nez dedans !!
if(isset($_GET['nimda'])){

	// mode verbose possible, pour voir un peu ce qu'il se passe si necessaire
	if(isset($_GET['verbose'])){$v = true;}else{$v = false;}
	
	//connection à la BDD
	$link = mysql_connect("localhost", "rallyedh_simon", "6778");
	$db = mysql_select_db('rallyedh_rallye', $link);
	

	// Récupération du nombre d'énigme débloquées pour chaque équipe
	// ------------------------------------------------------------
	$res = mysql_query("SELECT nom, questionnaire 
						FROM `Comptes_Utilisateurs` 
						WHERE id != 1 AND id != 2 AND id != 8 AND id != 33 AND id != 47 AND id != 23 AND id != 30 AND id != 14 AND id != 51 AND id != 43  AND id != 49 AND id != 22  AND id != 28  AND id != 10 AND id != 54 AND id != 7
	");
	$nb_equipe = mysql_num_rows($res);
	
	for ($i = 0; $i < $nb_equipe; $i++){

		$element = mysql_fetch_array($res);
		$questio = unserialize($element['questionnaire']);
		
		$compteur = 0;
		
		for ($y = 0; $y < 21; $y++){
			if($questio[$y])$compteur++;
		}
		
		if($compteur<10)$compteur = '0'.$compteur;
		$enigme[$i] = $compteur.'~'.$element['nom'];
	}
	

	// Récupération du nombre de logs par équipe, sans compter les doublons (même mot de passe, même numéro d'énigme).
	// On stocke également les dates de premier log et de dernier log,
	// ce qui nous donne une estimation du temps où l'équipe a été active.
	// ----------------------------------------------------------------------------------------------------------------
	
	//on note la date actuelle
	$currentTime = time();
	
	//on selectionne dans la BDD tous les logs (groupé par équipe, mot de passe et numéro d'énigme)
	$res = mysql_query("SELECT * 
						FROM `log` 
						WHERE `enigme` != 22 AND `equipe` != 'Simon' AND `equipe` != 'Cha' AND `equipe` != 'Les Roches' AND `equipe` != 'H&eacute;miole' AND `equipe` != 'Les Villepreusiens' AND `equipe` != 'La Petite Fugue' AND `equipe` != 'Geni&egrave;vre' AND `equipe` != 'Les Hibernants' AND `equipe` != 'Les Othellistes' AND `equipe` != 'Dumas' AND `equipe` != 'Les Trilles' AND `equipe` != 'Toto' AND `equipe` != 'Debars' AND `equipe` != 'Michounet' AND `equipe` != 'Breizh Storming'
						GROUP BY `mdp`, `equipe`, `enigme` 
						ORDER BY `log`.`id` ASC");
	$nb_log = mysql_num_rows($res);
	
	for($i = 0; $i < $nb_log; $i++){
	
		$element = mysql_fetch_array($res);
		$equipe = stripslashes($element['equipe']);
		
		// si on est déjà tombé sur des logs de cette équipes (elle est déjà enregistré dans les tableaux)
		if(isset($log[$equipe])){
			
			// on incrémente le nombre de log pour cette équipe
			$log[$equipe]++;
			
			//on formate puis on écrase la date du dernier log de l'équipe par la date du nouveau log (en nombre de jour depuis la date actuelle) dans $lastdate
			$log_i = explode("-", $element['date']);
			$log_j = explode(" ", $log_i[2]);
			$log_k = explode(":", $log_j[1]);
			$lastdate[$equipe] = mktime($log_k[0], $log_k[1], $log_k[2], $log_i[1], $log_j[0], $log_i[0]);
			$lastdate[$equipe] = floor($currentTime/(3600*24)) - floor($lastdate[$equipe]/(3600*24));
			
		// si c'est la première fois qu'on rencontre un log d'une équipe
		}else{
			
			// on initialise à 1 l'entré du tableau correspondant à cette équipe
			$log[$equipe] = 1;
			
			//on formate puis on stocke la date du premier log (en nombre de jour depuis la date actuelle) dans $date et dans $lastdate
			$log_i = explode("-", $element['date']);
			$log_j = explode(" ", $log_i[2]);
			$log_k = explode(":", $log_j[1]);
			$date[$equipe] = mktime($log_k[0], $log_k[1], $log_k[2], $log_i[1], $log_j[0], $log_i[0]);
			$date[$equipe] = floor($currentTime/(3600*24)) - floor($date[$equipe]/(3600*24));
			$lastdate[$equipe] = $date[$equipe];
		} 
	}

	// Récupération du nombre d'énimge débloquées enregistrées dans les logs.
	// C'est inférieur pour certains cas au nombre total d'énigme débloquées
	// ----------------------------------------------------------------------
	$res = mysql_query("SELECT `equipe`, COUNT(DISTINCT mdp) AS 'nb' 
						FROM `log` 
						WHERE `ok` = 1 AND `equipe` != 'Simon' AND `equipe` != 'Cha' AND `equipe` != 'Les Roches' AND `equipe` != 'H&eacute;miole' AND `equipe` != 'Les Villepreusiens' AND `equipe` != 'La Petite Fugue' AND `equipe` != 'Geni&egrave;vre' AND `equipe` != 'Les Hibernants' AND `equipe` != 'Les Othellistes' AND `equipe` != 'Dumas' AND `equipe` != 'Les Trilles' AND `equipe` != 'Toto' AND `equipe` != 'Debars' AND `equipe` != 'Michounet' AND `equipe` != 'Breizh Storming'
						GROUP BY `equipe`");
	$nb_log = mysql_num_rows($res);
	for($i = 0; $i < $nb_log; $i++){
		$element = mysql_fetch_array($res);
		$equipe = stripslashes($element['equipe']);
		$logEnigme[$equipe] = $element['nb'];
	}
	
	$i = 0;
	foreach ($log as $team => $nb){
		if($nb<10){$log[$team] = '000'.$log[$team];}else
		if($nb<100){$log[$team] = '00'.$log[$team];}else
		if($nb<1000){$log[$team] = '0'.$log[$team];}
		$log2[$i] = $log[$team].'~'.$team;
		$i++;
	}

	rsort($log2);
	
	if($v){
	
		echo '-- Nombre de log par equipe (Alea) --<br/><br/>';
		foreach ($log2 as $value){
			$value2 = explode('~', $value);
			if($value2[0][0] == '0')$value2[0]=substr($value2[0], 1);
			if($value2[0][0] == '0')$value2[0]=substr($value2[0], 1);
			if($value2[0][0] == '0')$value2[0]=substr($value2[0], 1);
			echo $value2[0] . ' - ' . $value2[1] . '<br/>';
		}
		
	}else{

		$t = explode('~', $log2[0]);
		if($t[0][0] == '0')$t[0]=substr($t[0], 1);
		echo $t[1].'/'.$t[0].'<br>';					// resultat pour "Alea"
		
	}

	$i = 0;
	$j = 0;
	foreach ($enigme as $team){
		$t = explode('~', $team);
		$nbReelEnigme = $t[0];
		$equipe = $t[1];
		
		if(isset($log[$equipe]) && $log[$equipe] > 0 && $nbReelEnigme > 10){
			$nbReelLog = $log[$equipe] - $logEnigme[$equipe] + $nbReelEnigme;
			$value = round( $nbReelEnigme * 1000 / $nbReelLog )/1000;
			$log3[$i] = str_pad($value, 5 , "0") . '~' . $equipe . '~' . $nbReelEnigme . '~' . $nbReelLog;
			$i++;
		}
		$tempsActivite = $date[$equipe] - $lastdate[$equipe];
		if(isset($date[$equipe]) && $date[$equipe] > 0 && $t[0] > 5){
			$value = ''.($nbReelEnigme/(3*$tempsActivite));
			$date2[$j] = str_pad($value, 5 , "0") . '~' . $equipe . '~' . $nbReelEnigme . '~' . ( $date[$equipe] - $lastdate[$equipe] );
			$j++;
		}
	}							

	rsort($log3);
	rsort($date2);
	
	if($v){
	
		echo '<br/>-- Rapport enigmes resolues/nombre de log (one touch)--<br/><br/>';
		foreach ($log3 as $value){
			$value2 = explode('~', $value);
			echo $value2[0] . ' - ' . $value2[1] . ' (' . $value2[2] . ' resolues pour ' . $value2[3] . ' testes)<br/>';
		}
		echo '<br/>-- Rapport enigmes resolues/temps passe (lievre & tortue) --<br/><br/>';
		foreach ($date2 as $value){
			$value2 = explode('~', $value);
			$value2[0] = round($value2[0]*1000)/1000;
			echo $value2[0] . ' - ' . $value2[1] . ' (' . $value2[2] . ' resolues en ' . $value2[3] . ' jours)<br/>';
		}
		echo '<br/><br/>-- Coupe assiste --<br/><br/>';
		
	}else{

		$t = explode('~', $log3[0]);
		if($t[2][0] == '0')$t[2]=substr($t[2], 1);
		if($t[2][0] == '0')$t[2]=substr($t[2], 1);
		if($t[3][0] == '0')$t[3]=substr($t[3], 1);
		echo $t[1].'/'.$t[2].'/'.$t[3].'<br>';					// resultat pour "One Touch"
		$t = explode('~', $date2[0]);
		if($t[2][0] == '0')$t[2]=substr($t[2], 1);
		if($t[3][0] == '0')$t[3]=substr($t[3], 1);
		echo $t[1].'/'.$t[2].'/'.$t[3].'<br>';					// resultat pour "Lievre & Tortue"
	
	}
	
	$res = mysql_query("SELECT `nom`, `indices` FROM `Comptes_Utilisateurs` WHERE `indices`=(SELECT MAX(`indices`) FROM `Comptes_Utilisateurs`)");
	if(!$res) echo mysql_error();
	$nb = mysql_num_rows($res);
	for($i = 0; $i < $nb; $i++){
		$select = mysql_fetch_array($res);
		if($i == 0) echo 	$select['nom'];
		else echo ' ex aequo avec ' . $select['nom'];
	}
	echo '/' . $select['indices'];							// resultat pour "assiste"

}
?>