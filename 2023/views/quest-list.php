<?php 

if (!isset($bdd)) {
	require_once '../ressources/info.php';
	require_once '../controllers/db.php';
	require_once '../controllers/login.php';
}

echo '<ol id="quest-list">';

$i = 0;
foreach ($rallyeContent as $key => $value) {
	
	if ($key[0]=="P") {

		// pour afficher des parcours en 2 parties
		$class = "";
		if ( $value[3] ) $class = 'style="list-style-type: none;"';
		else $i++;

		// si le parcours est publié ou qu'il est débloqué par l'utilisateur
		if ( array_key_exists($key, $_SESSION['unlocked']) ) {
			echo "<li code=\"$key\" value=\"$i\" $class>$value[0]</li>";
		}else{
			echo "<li class=\"deactivated\" value=\"$i\" $class>$value[0]</li>";
		}
	}
}

echo '</ol>';

?>

