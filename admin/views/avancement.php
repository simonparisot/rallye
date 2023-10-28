<h1>Avancement des équipes</h1>

<?

require_once '../controllers/initialize.php';

// --------------------------------------
// on récupère l'activité des équipes
// en regardant leurs derniers logs
// et on change l'opacité d'affichage en fonction

$search1 = $bdd->prepare('SELECT t.equipe, t.date FROM rallye_log t INNER JOIN (SELECT equipe, max(date) AS MaxDate FROM rallye_log GROUP BY equipe) tm ON t.equipe = tm.equipe AND t.date = tm.MaxDate ORDER BY t.date DESC');

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

//$search2 = $bdd->prepare('SELECT * FROM rallye_people WHERE login != "orga" AND login != "simon" AND login != "meltingpotes" ORDER BY id');
$search2 = $bdd->prepare('SELECT * FROM rallye_users WHERE type !="admin" ORDER BY name');
$teamRank = array();
$total_e_unlocked = 0;
$total_p_unlocked = 0;
$total_e_solved = 0;
$total_p_solved = 0;

if ($search2->execute()) {
	while ($team = $search2->fetch()) {

		$temp['e_unlocked'] = 0;
		$temp['p_unlocked'] = 0;
		$temp['e_solved'] = 0;
		$temp['p_solved'] = 0;
		$temp['enigme'] = "";
		$temp['quest'] = "";
		$temp['name'] = $team['name'];

		$unlocked = json_decode($team['unlocked'], true);

		foreach ($rallyeContent as $code => $value) {

			// affichage des enigmes
			if ( $code[0]=="E" ) {
				
				if ( isset($unlocked[$code]) ) {
					if ($unlocked[$code]) {
						$temp['enigme'] .= '<div class="solved tooltip"><span><img class="callout" src="ressources/img/callout.gif">'.$value[0].'</span></div>';
						$temp['e_solved']++;
					}else{
						$temp['enigme'] .= '<div class="unlocked tooltip"><span><img class="callout" src="ressources/img/callout.gif">'.$value[0].'</span></div>';
						$temp['e_unlocked']++;
					}
				}else{ 
						$temp['enigme'] .= '<div class="locked tooltip"><span><img class="callout" src="ressources/img/callout.gif">'.$value[0].'</span></div>';
				}

			// affichage des parcours
			}else if ( $code[0]=="P" ) {
				
				if ( isset($unlocked[$code]) ) {
					if ($unlocked[$code]) {
						$temp['quest'] .= '<div class="solved tooltip"><span><img class="callout" src="ressources/img/callout.gif">'.$value[0].'</span></div>';
						$temp['p_solved']++;
					}else{
						$temp['quest'] .= '<div class="unlocked tooltip"><span><img class="callout" src="ressources/img/callout.gif">'.$value[0].'</span></div>';
						$temp['p_unlocked']++;
					}
				}else{ 
						$temp['quest'] .= '<div class="locked tooltip"><span><img class="callout" src="ressources/img/callout.gif">'.$value[0].'</span></div>';
				}


			}
		}

		// on calcule un ranking des équipes pour les trier lors de l'affichage
		// 100pts par énigmes, 200pts par parcours et 5pts par contenu débloqué mais non résolu
		$temp['rank'] = 100*$temp['e_solved'] + 200*$temp['p_solved'] + 5*$temp['e_unlocked'] + 5*$temp['p_unlocked'];
		// on concatène avec le nom de l'équipe pour classer par ordre alphabétique si égalité
		$temp['rank'] .= '##'.$temp['name'];

		// on incrémente les compteurs globaux
		$total_e_unlocked += $temp['e_unlocked'];
		$total_p_unlocked += $temp['p_unlocked'];
		$total_e_solved   += $temp['e_solved'];
		$total_p_solved   += $temp['p_solved'];

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
		$teamLineHTML .= '<td class="rank">'.$i.'. </td>';					// ranking
		$teamLineHTML .= '<td class="name">'.$inf['name'].'</td>';			// nom de l'équipe
		$teamLineHTML .= '<td class="eni">'.$inf['enigme'].'</td>';			// liste des énigmes résolues
		$teamLineHTML .= '<td class="eni_c">'.$inf['e_solved'].'</td>';		// nombre d'énigmes résolues
		$teamLineHTML .= '<td class="par">'.$inf['quest'].'</td>';			// liste des parcours débloqués
		$teamLineHTML .= '<td class="par_c">'.$inf['p_solved'].'</td>';		// nombre de parcours débloqués
		$teamLineHTML .= '</tr>';											// fin de ligne

		echo $teamLineHTML;
		$i++;	

	}
	echo '</table><br><h2>Au total</h2>';
	echo $total_e_solved. ' énigmes résolues<br>';
	echo $total_p_solved. ' parcours résolus<br>';
}

?>