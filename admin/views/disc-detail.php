<?php

if( isset($_GET['enigme']) && isset($_GET['team']) ) {

	require_once '../controllers/initialize.php';

	$search = $bdd->prepare('SELECT date, nom, text FROM rallye_posts WHERE equipe = :equipe AND enigme = :enigme ORDER BY date DESC');

	if ($search->execute(array( ':equipe' => $_GET['team'], ':enigme' => $_GET['enigme'] ))) {
		while ($disc = $search->fetch()) {
			$text_ok = nl2br(htmlspecialchars($disc['text']));
			//$text_ok = preg_replace('@(http)?(s)?(://)?(([-\w]+\.)+([^\s]+)+[^,.\s])@', '<a href="http$2://$4" target="_blank" rel="nofollow">$1$2$3$4</a>', $text_ok);
			$nom_ok = htmlspecialchars($disc['nom']);
			echo '<div class="disc">';
			echo '<span class="disc-name">'.$nom_ok.'</span>';
			echo '<div class="disc-date">'.nicedate($disc['date']).'</div>';
			echo '<p class="disc-post">'.$text_ok.'</p>';
			echo '</div>';
		}
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