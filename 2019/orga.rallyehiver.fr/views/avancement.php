<h1>Avancement des équipes</h1>

<?

require '../controllers/db.php';
require '../ressources/info.php';

// --------------------------------------
// on récupère l'activité des équipes
// en regardant leurs derniers logs
// et on change l'opacité d'affichage en fonction

$search1 = $bdd->prepare('SELECT t.equipe, t.date FROM rallye_log t INNER JOIN (SELECT equipe, max(date) AS MaxDate FROM rallye_log GROUP BY equipe) tm ON t.equipe = tm.equipe AND t.date = tm.MaxDate WHERE t.equipe != "orga" AND t.equipe != "theb2" AND t.equipe != "sacregrallye" ORDER BY t.date DESC');

if ($search1->execute()) {
	while ($team = $search1->fetch()) {
		$old = time() - strtotime($team['date']);
		if ($old <= 3600*72) { $opa[$team['equipe']] = 1; }
		elseif ($old > 3600*72 && $old <= 3600*24*7) { $opa[$team['equipe']] = 0.7; }
		elseif ($old > 3600*24*7) { $opa[$team['equipe']] = 0.4; }
	}
}

// --------------------------------------
// on récupère l'avancement des équipes
// qui est affiché sous forme de cases
// et on trie les équipes

//$search2 = $bdd->prepare('SELECT * FROM rallye_people WHERE login != "orga" AND login != "theb2" ORDER BY id');
$search2 = $bdd->prepare('SELECT * FROM rallye_people WHERE login != "orga" AND login != "theb2" AND login != "sacregrallye" ORDER BY id');
$teamRank = array();
$nbEnigmesResolues = 0;

if ($search2->execute()) {
	while ($team = $search2->fetch()) {

		$enigmes = json_decode($team['enigmes'], true);
		$quest = json_decode($team['quest'], true);

		$temp['enigme'] = "";
		$temp['quest'] = "";
		$temp['name'] = $team['nom'];

		// affichage des cases énigmes
		for ($i=1; $i <= 21; $i++) { 
			if(isset($enigmes[$i])) { 
				$temp['enigme'] .= '<div class="ok tooltip"><span><img class="callout" src="ressources/img/callout.gif">'.$enigmeList[$i-1][0].'</span></div>';
				$nbEnigmesResolues++;
			}else{ 
				$temp['enigme'] .= '<div class="ko"></div>';
			}
		}
		$temp['eCount'] = count($enigmes) ? count($enigmes) : '';

		// affichage des cases parcours
		foreach ($questList as $token => $name) {
			if (in_array($token, $quest)) {
				$temp['quest'] .= '<div class="ok tooltip"><span><img class="callout" src="ressources/img/callout.gif">'.$name.'</span></div>';
			}else{
				$temp['quest'] .= '<div class="ko"></div>';
			}
		}
		$temp['qCount'] = count($quest) ? count($quest) : '';

		// on calcule un ranking des équipes pour les trier lors de l'affichage
		// on met 100 pts par énigmes, 1 pts par questionnaire (pour juste départager les égalités d'énigmes) et 
		// le facteur correcteur "indices" qui prend en compte les indices donnés et les pts gagnés sur les énigmes de rapidité
		//$temp['rank'] = 100*count($enigmes) + 1*count($quest) - 25*$team['indices'];
		$temp['rank'] = count($enigmes);
		//$temp['iCount'] = $temp['rank'].'pts';
		//$temp['iCount'] = 1*$team['indices'] ? ' avec correction de '.(-25)*$team['indices'].'pts' : '';
		// à la fin, on concatène avec le nom de l'équipe pour classer par ordre alphabétique si égalité
		$temp['rank'] .= '##'.$temp['name'];

		// on met le lien vers le dossier réponse s'il a été reçu
		//$temp['dr'] = file_exists("../dossiers/".$team['login'].".pdf") ? '<a href="../dossiers/'.$team['login'].'.pdf"><i class="far fa-file-image"></i></a>' : '' ;
		//$temp['dr'] = !empty(glob("../../dossiers/".$team['login']."*.*")) ? '<a href="../../dossiers/'.$team['login'].'.pdf"><img src="../../ressources/img/dr.png" /></a>' : '' ;

		$teamRank[$temp['rank']] = $temp;
		unset($temp);

	}

	// on classe les équipes !
	krsort($teamRank, SORT_NATURAL | SORT_FLAG_CASE);

	// on affiche tout ce qui a été calculé précédemment
	$i = 1;
	echo '<table>';
	foreach ($teamRank as $t => $inf) {

		// si l'équipe ne s'est jamais connectée, on met l'opacité à 0.4
		if (!isset($opa[$inf['name']])) $opa[$inf['name']] = 0.4;

		$teamLineHTML = '<tr style="opacity:'.$opa[$inf['name']].';">'; 	// une ligne du tableau par équipe, avec l'opacité dépendant de l'activité récente
		$teamLineHTML .= '<td class="rank">'.$i.'. </td>';								// ranking
		$teamLineHTML .= '<td class="name">'.$inf['name'].'</td>';			// nom de l'équipe
		if (isset($inf['dr'])) $teamLineHTML .= '<td class="dr">'.$inf['dr'].'</td>';	// dossier réponse (si présent)
		$teamLineHTML .= '<td class="eni">'.$inf['enigme'].'</td>';		// liste des énigmes résolues
		$teamLineHTML .= '<td class="eni_c">'.$inf['eCount'].'</td>';						// nombre d'énigmes résolues
		$teamLineHTML .= '<td class="par">'.$inf['quest'].'</td>';		// liste des parcours débloqués
		$teamLineHTML .= '<td class="par_c">'.$inf['qCount'].'</td>';						// nombre de parcours débloqués
		//$teamLineHTML .= '<td><span style="color: #aaa; font-size: 11px;">'.$inf['iCount'].'</span></td>';		// nombre de point
		$teamLineHTML .= '</tr>';											// fin de ligne

		echo $teamLineHTML;
		$i++;	

	}
	echo '</table><br>';
	echo $nbEnigmesResolues. ' énigmes résolues au total';
}

?>