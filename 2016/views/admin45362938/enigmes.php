<h1>résolutions des énigmes par date</h1>
<table style="border-collapse: collapse;">

<?

require '../../controllers/db.php';
require '../../ressources/info.php';
$search = $bdd->prepare('SELECT * FROM rallye_people WHERE login != "terpsichore" AND login !="euterpe" ORDER BY id');
$infoEnigmes = array();
$dategraph = array();

if ($search->execute()) {
	while ($team = $search->fetch()) {

		$enigmes = json_decode($team['enigmes'], true);

		// on récupère plusieurs infos sur chaque énigme
		foreach ($enigmes as $num => $date) {
			if ( !isset($infoEnigmes[$num]) || $infoEnigmes[$num]['date'] > ($date - mktime(0, 0, 0, 12, 22, 2015)) ) {
				$infoEnigmes[$num]['date'] = $date - mktime(0, 0, 0, 12, 22, 2015);
				$infoEnigmes[$num]['team'] = $team['nom'];
			}
			$infoEnigmes[$num]['nb'] = isset($infoEnigmes[$num]['nb']) ? $infoEnigmes[$num]['nb']+1 : 1;
			//echo '<tr><td style="border: 1px solid #666;">'.date("d/m/y G:i:s", $date).'</td></tr>';
		}

	}

	for ($i=1; $i <= 21 ; $i++) { 
		if (isset($infoEnigmes[$i])) { echo '<tr><td><b>Enigme '.$i.'</b></td><td>résolue par '.$infoEnigmes[$i]['nb'].' équipes</td><td> - la première fois en '.nicedate($infoEnigmes[$i]['date']).' par '.$infoEnigmes[$i]['team'].'</td></tr>'; }
		else { echo '<tr><td><b>Enigme '.$i.'</b></td><td colspan="2" style="color:#aaa;">non publiée</td>'; }
	}
}

function nicedate ($delay)
{
	if( $delay < 3600 ) 		{ return floor($delay/60).'min'; }
	elseif( $delay < 3600*24 )	{ return floor($delay/3600).'h'; }
	else 						{ return floor($delay/3600/24).'j'; }

}

?>

</table>