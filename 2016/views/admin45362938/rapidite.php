
<ol>

<?

require '../../controllers/db.php';
require '../../ressources/info.php';
$search = $bdd->prepare('SELECT * FROM rallye_people WHERE login != "terpsichore" AND login !="euterpe" ORDER BY id');
$enigme7 = array();
$enigme8 = array();

if ($search->execute()) {
	while ($team = $search->fetch()) {

		$enigmes = json_decode($team['enigmes'], true);

		// on récupère plusieurs infos sur chaque énigme
		foreach ($enigmes as $num => $date) {
			if ( $num == 7 ) {
				$enigme7[$team['nom']] = $date - mktime(20, 00, 00, 1, 29, 2016);
			}
			elseif ($num == 8) {
				$enigme8[$team['nom']] = $date - mktime(20, 15, 00, 2, 12, 2016);
			}
		}

	}

	asort($enigme7);
	asort($enigme8);

	echo "<h1>Enigme 7 - L'eau d'Issey</h1><ol>";
	foreach ($enigme7 as $equipe => $date) {
		echo '<li>'.$equipe.' (en '.nicedate($date).')</li>';
	}
	echo "</ol><h1>Enigme 8 - La cérémonie des césars</h1><ol>";
	foreach ($enigme8 as $equipe => $date) {
		echo '<li>'.$equipe.' (en '.nicedate($date).')</li>';
	}
	echo "</ol>";
}

function nicedate ($delay)
{
	if( $delay < 3600 ) 		{ return floor($delay/60).'min'; }
	elseif( $delay < 3600*24 )	{ return floor($delay/3600).'h'; }
	else 						{ return floor($delay/3600/24).'j'; }

}

?>