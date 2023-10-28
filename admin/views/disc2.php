<h1>Discussions récentes</h1>
<p>Cliquez pour afficher la discussion entière</p>

<?php
require_once '../controllers/initialize.php';

// on récupère la liste de toutes les derniers messages, groupé par équipe et énigme 
$search = $bdd->prepare('SELECT * FROM rallye_posts t1 INNER JOIN (SELECT equipe, enigme, max(date) as maxdate FROM rallye_posts GROUP BY equipe, enigme) t2 ON t1.equipe=t2.equipe AND t1.enigme=t2.enigme AND t1.date=t2.maxdate ORDER BY date DESC');
//$search = $bdd->prepare('SELECT * FROM rallye_posts ORDER BY date DESC');

if ($search->execute()) {
	while ($disc = $search->fetch()) {

		echo '<div class="infoItem disc-detail" en="'.$disc['enigme'].'" eq="'.$disc['equipe'].'">';
		echo '<div><b>'.$disc['equipe'].'</b> sur l\'énigme <b>'.$enigmeList[$disc['enigme']-1][0].'</b></div>';

		$text_ok = nl2br(htmlspecialchars($disc['text']));
		//$text_ok = preg_replace('@(http)?(s)?(://)?(([-\w]+\.)+([^\s]+)+[^,.\s])@', '<a href="http$2://$4" target="_blank" rel="nofollow">$1$2$3$4</a>', $text_ok);
		$nom_ok = htmlspecialchars($disc['nom']);

		echo '<div class="disc-container">';
		echo '<div class="disc">';
		echo '<span class="disc-name">'.$nom_ok.'</span>';
		echo '<div class="disc-date">'.nicedate($disc['date']).'</div>';
		echo '<p class="disc-post">'.$text_ok.'</p>';
		echo '</div></div>';
		
		echo '</div>';
	}
}

// ------------------------------------------
// transforme une date en un format sympa (qq sec, 3min, 2h, hier, 5 sept, ...)
function nicedate ($date)
{
	$delay = time() - strtotime($date);
		if( $delay < 60 ) 		{ return 'qq sec'; }
	elseif( $delay < 3600 ) 	{ return floor($delay/60).'min'; }
	elseif( $delay < 3600*24 )	{ return floor($delay/3600).'h'; }
	elseif( $delay < 3600*48 ) 	{ return 'hier'; }
	else 						{ return date('d/m', strtotime($date)); }

}
?>