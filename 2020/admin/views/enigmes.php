<h1>Infos sur les énigmes</h1>
<p>Nombre d'équipes qui a résolu chaque énigme, et première équipe qui l'a résolu.</p>
<table style="border-collapse: collapse; text-align: left;">
	<tr>
		<th>Enigme</th>
		<th>Total</th>
		<th>Prem's</th>
	</tr>

<?

require '../controllers/db.php';
require '../ressources/info.php';
$search = $bdd->prepare('SELECT * FROM rallye_people WHERE login != "orga" AND login != "simon" ORDER BY id');
$infoEnigmes = array();
$dategraph = array();

if ($search->execute()) {
	while ($team = $search->fetch()) {

		$enigmes = (array)json_decode($team['enigmes'], true);

		// on récupère plusieurs infos sur chaque énigme
		foreach ($enigmes as $num => $date) {
			if ( !isset($infoEnigmes[$num]) || $infoEnigmes[$num]['date'] > ($date - mktime(0, 0, 0, 12, 21, 2018)) ) {
				$infoEnigmes[$num]['date'] = $date - mktime(0, 0, 0, 12, 21, 2018);
				$infoEnigmes[$num]['team'] = $team['nom'];
			}
			$infoEnigmes[$num]['nb'] = isset($infoEnigmes[$num]['nb']) ? $infoEnigmes[$num]['nb']+1 : 1;
			//echo '<tr><td style="border: 1px solid #666;">'.date("d/m/y G:i:s", $date).'</td></tr>';
		}

	}

	for ($i=1; $i <= 21 ; $i++) { 
		if (isset($infoEnigmes[$i])) { echo '<tr><td>'.$enigmeList[$i-1][0].'</td><td>'.$infoEnigmes[$i]['nb'].' éq.</td><td>(en '.nicedate($infoEnigmes[$i]['date']).') '.$infoEnigmes[$i]['team'].'</td></tr>'; }
		else { echo '<tr><td>'.$enigmeList[$i-1][0].'</td><td colspan="2" style="color:#aaa;">non résolue</td>'; }
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