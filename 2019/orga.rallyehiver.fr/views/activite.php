<h1>Activité des équipes</h1>

<?

require '../controllers/db.php';

// requête pour prendre uniquement la dernère connexion de chaque équipe
$search = $bdd->prepare('SELECT t.equipe, t.date FROM rallye_log t INNER JOIN (SELECT equipe, max(date) AS MaxDate FROM rallye_log GROUP BY equipe) tm ON t.equipe = tm.equipe AND t.date = tm.MaxDate WHERE t.equipe != "orga" AND t.equipe != "theb2" ORDER BY t.date DESC');

if ($search->execute()) {
	while ($team = $search->fetch()) {
		$old = time() - strtotime($team['date']);
		/*if ($old <= 3600*24) { $opa = 1; $old = 'moins de '.(floor($old/3600)+1).'h'; }
		elseif ($old > 3600*24 && $old <= 3600*48) { $opa = 0.8; $old = '1j'; }
		elseif ($old > 3600*48 && $old <= 3600*72) { $opa = 0.6; $old = '2j'; }
		elseif ($old > 3600*72 && $old <= 3600*24*7) { $opa = 0.4; $old = floor($old/3600/24).'j'; }
		elseif ($old > 3600*24*7) { $opa = 0.2; $old = floor($old/3600/24).'j'; }*/
		echo '<div>'.nicedate($old).': <b>'.$team['equipe'].'</b> s\'est connecté</div>';
	}
}

function nicedate ($delay)
{
		if( $delay < 60 ) 		{ return 'Il y a qq sec'; }
	elseif( $delay < 3600 ) 	{ return 'Il y a '.floor($delay/60).'min'; }
	elseif( $delay < 3600*24 )	{ return 'Il y a '.floor($delay/3600).'h'; }
	elseif( $delay < 3600*48 ) 	{ return 'Hier'; }
	else 						{ return 'Il y a '.floor($delay/(3600*24)).' jours'; }

}

?>
