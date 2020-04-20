<?php

$enigmes = array(	"La Visite amusee",			"Les Bottes de chef-lieu",			"Strasbourg 1792",
					"Melodie internationale",	"Les Arts Florissants",				"La Legende de Joseph",
					"Les Enfants de Michael",	"Broken Tape",						"Dans un tridacne",
					"BOF!",						"Tout ce dont tu as besoin (...)",	"Mode",
					"Facile a jouez",			"La Saga des 9",					"Cycles",
					"La Cigale et la Fourmi",	"Orchestre",						"Ca gaze pour le grand capitaine",
					"Armide",					"La tournee du patron",				"Mystere (TR)");

$avancement = array();
$stat = array(0, 0, 0);
/*$res = mysqli_query($link, "SELECT nom, login, questionnaire, bonus, indices, upload 
					FROM `Comptes_Utilisateurs` 
					WHERE id != 1 AND id != 2 AND id != 8 AND id != 33 AND id != 47 AND id != 23 AND id != 30 AND id != 14 AND id != 51 AND id != 43  AND id != 49 AND id != 22  AND id != 28  AND id != 10 AND id != 54 AND id != 7
");*/
$res = mysqli_query($link, "SELECT nom, login, questionnaire, bonus, indices, upload 
					FROM `Comptes_Utilisateurs` 
					WHERE id = 3 OR id = 4
");
/*$res = mysqli_query($link, "SELECT nom, login, questionnaire, bonus, indices, upload 
					FROM `Comptes_Utilisateurs` 
					WHERE id != 1 AND id != 2 AND id != 8 AND id != 33 AND id != 47
");*/
$nb = mysqli_num_rows($res);

for ($i = 0; $i < $nb; $i++){

	$element = mysqli_fetch_array($res);
	$questio = unserialize($element['questionnaire']);
	
	$serial = "";
	$compteur = 0;
	$points = 0;
	
	for ($y = 0; $y < 21; $y++){
		if($questio[$y]){
			$serial .= '~true';
			$compteur++;
			$points += 100;
		}else{
			$serial .= '~false';
		}
	}
	
	if($element['bonus'] > 4){
		$compteur++;
		switch($element['bonus']%5){ 
			case 0: $points += 20; break;
			case 1: $points += 30; break; 
			case 2: $points += 40; break;
			case 3: $points += 60; break;
			case 4: $points += 90; break;
		}
	}
	
	$points -= $element['indices']*25;
	
	$serial .= '~'.$element['bonus'].'~'.$element['indices'];
	
	if($compteur>0){
		$stat[0]+=$compteur;
		$stat[2]++;}
	if($compteur<10)$compteur = '0'.$compteur;
	if($points<10)$points = '000'.$points;
	if($points<100)$points = '00'.$points;
	if($points<1000)$points = '0'.$points;
	
	// nombre de jours depuis le dernier log
	/*if($element['nom'] == "D'hiver'di") $nom = "hiver";
	else if($element['nom'] == "Notes'in Gammes") $nom = "Gammes";
	else $nom = $element['nom'];
	$query = mysqli_query($link, "	SELECT UNIX_TIMESTAMP(`date`) AS nb 
							FROM `log` 
							WHERE `equipe` LIKE '%".$nom."%'
							ORDER BY `date` DESC 
							LIMIT 1;
	");
	if(!$query) echo $element['nom'].'<br/>';
	if(!$query) echo mysqli_error($link).'<br/>';
	$lastlog = mysqli_fetch_array($query);
	$lastlog = round((time() - $lastlog['nb'])/(24*3600));
	if($lastlog > 30)$lastlog = 30;
	$lastlog = 0.02333*(30-$lastlog)+0.3;
	$lastlog = round(10*$lastlog)/10;*/
	$lastlog = 1;
	
	//fichier uploadé ?
	$up = $element['upload'];
	if($up < 100) $dossier = 0;
	else $dossier = 1;
	if($up > 0 && $up%100 != 0) $video = 1;
	else $video = 0;
	
	$avancement[$i] = $points.'~'.$compteur.'~'.$element['nom'].$serial.'~'.$lastlog.'~'.$dossier.'~'.$video;
}

rsort($avancement);

$res = mysqli_query($link, "SELECT * FROM `commentaires` ORDER BY  `commentaires`.`date` ASC");
$nb = mysqli_num_rows($res);
for($i = 0; $i < $nb; $i++){
	$element = mysqli_fetch_array($res);
	$com_auteur[$i] = $element['auteur'];
	$com_date[$i] = $element['date'];
	$com_text[$i] = $element['text'];
}

$res = mysqli_query($link, "SELECT * FROM `log` ORDER BY `log`.`id` DESC LIMIT 0,40");
$nb = mysqli_num_rows($res);
for($i = 0; $i < $nb; $i++){
	$element = mysqli_fetch_array($res);
	$log_e = stripslashes($element['mdp']);
	$log_f = stripslashes($element['equipe']);
	if(strlen($log_e) > 17){
		$log_e = substr($log_e, 0, 17);
		$log_e .= '...';
	}
	if(strlen($log_f) > 17){
		$log_f = substr($log_f, 0, 17);
		$log_f .= '...';
	}
	$log_i = explode("-", $element['date']);
	$log_j = explode(" ", $log_i[2]);
	$log_k = explode(":", $log_j[1]);
	if($log_k[0] == '00' && $log_k[1] == '00' && $log_k[2] == '00'){
		$log_date[$i] = $log_j[0].'-'.$log_i[1];
	}else{
		$log_date[$i] = $log_j[0].'-'.$log_i[1].' &agrave; '.$log_k[0].':'.$log_k[1];
	}
	$log_equipe[$i] = $log_f;
	$log_mdp[$i] = $log_e;
	if($element['enigme'] == 22){$NBenigme = 'diner';}else{$NBenigme = $element['enigme'];}
	$log_enigme[$i] = $NBenigme;
	$log_ok[$i] = $element['ok'];
}

// Calcul des stats
	//équipes actives
/*	$res = mysqli_query($link, "SELECT COUNT(DISTINCT `guess`) AS nb 
						FROM `Comptes_Utilisateurs` 
						WHERE (`guess` != 'a:0:{}' AND id != 1 AND id != 2 AND id != 8 AND id != 33 AND id != 47 AND id != 23 AND id != 30 AND id != 14 AND id != 51 AND id != 43  AND id != 49 AND id != 22  AND id != 28  AND id != 10 AND id != 54 AND id != 7)");
*/
	$res = mysqli_query($link, "SELECT COUNT(DISTINCT `guess`) AS nb 
						FROM `Comptes_Utilisateurs` 
						WHERE (`guess` != 'a:0:{}' AND id != 1 AND id != 2 AND id != 8 AND id != 33 AND id != 47)");
	$element = mysqli_fetch_array($res);
	$stat[1] = $element['nb'];
	$stat[0] = round($stat[0]/($stat[1]*0.2));
	
// récupération des fichiers uploadés
$upload = array();
$MyDirectory = opendir('upload') or die('Erreur lors de l\'ouverture de la directory');
while($Entry = @readdir($MyDirectory)) {
	if($Entry != '.' && $Entry != '..' && $Entry != 'index.html'){
		if(filesize('upload/'.$Entry) < 1000000) $Fsize = round(filesize('upload/'.$Entry)/1000).' Ko';
		elseif(filesize('upload/'.$Entry) < 1000000000) $Fsize = round(filesize('upload/'.$Entry)/1000000).' Mo';
		else $Fsize = (round(filesize('upload/'.$Entry)/10000000)/100).' Go';
		array_push($upload, $Entry.'~'.$Fsize);
	}
}
closedir($MyDirectory);
rsort($upload);
	
?>