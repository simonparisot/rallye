<h1>Avancement et classement des équipes</h1>

<?

require '../../controllers/db.php';
require '../../ressources/info.php';

// on récupère l'activité des équipes
$search1 = $bdd->prepare('SELECT t.equipe, t.date FROM rallye_log t INNER JOIN (SELECT equipe, max(date) AS MaxDate FROM rallye_log GROUP BY equipe) tm ON t.equipe = tm.equipe AND t.date = tm.MaxDate WHERE t.equipe != "terpsichore" AND t.equipe != "euterpe" ORDER BY t.date DESC');

if ($search1->execute()) {
	while ($team = $search1->fetch()) {
		$old = time() - strtotime($team['date']);
		if ($old <= 3600*72) { $opa[$team['equipe']] = 1; }
		elseif ($old > 3600*72 && $old <= 3600*24*7) { $opa[$team['equipe']] = 0.7; }
		elseif ($old > 3600*24*7) { $opa[$team['equipe']] = 0.4; }
	}
}


// on récupère l'avancement des équipes
$search2 = $bdd->prepare('SELECT * FROM rallye_people WHERE login != "terpsichore" AND login !="euterpe" ORDER BY id');
$teamRank = array();
$nbEnigmesResolues = 0;

if ($search2->execute()) {
	while ($team = $search2->fetch()) {

		$enigmes = json_decode($team['enigmes'], true);
		$quest = json_decode($team['quest'], true);

		$temp['name'] = $team['nom'];
		for ($i=1; $i <= 21; $i++) { 
			if(isset($enigmes[$i])) { 
				$temp['enigme'] .= '<div class="ok tooltip"><span><img class="callout" src="ressources/img/callout.gif">'.$enigmeList[$i-1][0].'</span></div>';
				$nbEnigmesResolues++;
			}else{ 
				$temp['enigme'] .= '<div class="ko"></div>';
			}
		}
		$temp['eCount'] = count($enigmes) ? count($enigmes) : '';
		foreach ($questList as $token => $name) {
			if (in_array($token, $quest)) {
				$temp['quest'] .= '<div class="ok tooltip"><span><img class="callout" src="ressources/img/callout.gif">'.$name.'</span></div>';
			}else{
				$temp['quest'] .= '<div class="ko"></div>';
			}
		}
		$temp['qCount'] = count($quest) ? count($quest) : '';

		// Pour le classement (temporaire), on met 100 pts par énigmes, 1 pts par questionnaire (pour juste départager les égalités d'énigmes) et 
		// le facteur correcteur "indices" qui prend en compte les indices donnés et les pts gagnés sur les énigmes de rapidité
		$temp['rank'] = 100*count($enigmes) + 1*count($quest) - 25*$team['indices'];
		//$temp['iCount'] = $temp['rank'].'pts';
		$temp['iCount'] = 1*$team['indices'] ? ' avec correction de '.(-25)*$team['indices'].'pts' : '';
		// à la fin, on concatène avec le nom de l'équipe pour classer par ordre alphabétique si égalité
		$temp['rank'] .= '##'.$temp['name'];

		$temp['dr'] = file_exists("../../dr/".$team['login'].".pdf") ? '<a href="../../dr/'.$team['login'].'.pdf"><img src="../../ressources/img/dr.png" /></a>' : '' ;
		#$temp['dr'] = !empty(glob("../../dr/".$team['login']."*.*")) ? '<a href="../../dr/'.$team['login'].'.pdf"><img src="../../ressources/img/dr.png" /></a>' : '' ;

		$teamRank[$temp['rank']] = $temp;
		unset($temp);

	}

	krsort($teamRank, SORT_NATURAL | SORT_FLAG_CASE);


	$i = 1;
	echo '<table>';
	foreach ($teamRank as $t => $inf) {
		echo '<tr style="opacity:'.$opa[$inf['name']].';"><td>'.$i.'. </td><td class="name">'.$inf['name'].'</td><td>'.$inf['dr'].'</td><td>'.$inf['enigme'].$inf['eCount'].'</td><td>'.$inf['quest'].$inf['qCount'].'</td><td><span style="color: #aaa; font-size: 11px;">'.$inf['iCount'].'</span></td></tr>';
		$i++;	
	}
	echo '</table><br>';
	echo $nbEnigmesResolues. ' énigmes résolues au total';
}

?>