<h1>Dernières résolutions</h1>

<?

require '../controllers/db.php';
require '../ressources/info.php';

$search = $bdd->prepare('SELECT nom, enigmes FROM rallye_people WHERE login != "orga" ORDER BY id');
$solved = array();

if ($search->execute()) {
	while ($team = $search->fetch()) {

		$enigmes = (array)json_decode($team['unlocked'], true);

		foreach ($enigmes as $num => $date) {
			if ($date) {
				
				$howold = time() - $date;
				if ( $howold < 3600*24 ) {
					$solved[$howold.'##'.$team['nom']]['name'] = $team['nom'];
					$solved[$howold.'##'.$team['nom']]['enigme'] = $rallyeContent[$num][0];
					$solved[$howold.'##'.$team['nom']]['date'] = floor($howold/3600)+1;
				}

			}
		}

	}

	ksort($solved, SORT_NATURAL | SORT_FLAG_CASE);

	foreach ($solved as $item) {
		echo '<div><b>'.$item['enigme'].'</b> a été résolue par '.$item['name'].' il y a moins de '.$item['date'].'h</div>';	
	}
}

?>