<?php 

// cette page peut être appelée en ajax, et dans ce cas il faut inclure info.php
if ( !isset($bdd) ) {
	require '../ressources/info.php';
	require '../controllers/db.php';
	require '../controllers/login.php';
}

echo '<ol id="quest-list">';

// on récupére la liste des questionnaires débloqués par l'équipe (la liste des token en fait)
$sth = $bdd->prepare('SELECT quest FROM rallye_people WHERE nom = :nom LIMIT 1');

if ($sth->execute(array(':nom' => $_SESSION['nom']))) {
	
	$answer = $sth->fetch();
	$unlocked = json_decode($answer['quest'], true);

	foreach ($questList as $token => $quest) {
		if (in_array($token, $unlocked) && $_SESSION['login']!="sacregrallye") {
			echo '<li code="'.$token.'">'.$quest.'</li>';
		}else{
			echo '<li class="deactivated">'.$quest.'</li>';
		}
	}

}else{ echo "erreur lors de la récupération des parcours."; }

echo '</ol>';

?>

