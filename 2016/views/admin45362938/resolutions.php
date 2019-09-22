<h1>Enigmes résolues ces dernières 24h</h1>

<?

require '../../controllers/db.php';
require '../../ressources/info.php';

$search = $bdd->prepare('SELECT nom, enigmes FROM rallye_people WHERE login != "terpsichore" AND login !="euterpe" ORDER BY id');
$solved = array();

if ($search->execute()) {
	while ($team = $search->fetch()) {

		$enigmes = json_decode($team['enigmes'], true);

		foreach ($enigmes as $num => $date) {
			$howold = time() - $date;
			if ( $howold < 3600*24 ) {
				$solved[$howold.'##'.$team['name']]['name'] = $team['nom'];
				$solved[$howold.'##'.$team['name']]['enigme'] = $enigmeList[$num-1][0];
				$solved[$howold.'##'.$team['name']]['date'] = floor($howold/3600)+1;
			}
		}

	}

	ksort($solved, SORT_NATURAL | SORT_FLAG_CASE);

	foreach ($solved as $item) {
		echo '<div class="infoItem"><b>'.$item['enigme'].'</b> a été résolue par '.$item['name'].' il y a moins de '.$item['date'].'h</div>';	
	}
}

?>