<?php 

if (!isset($bdd)) {
	require_once '../ressources/info.php';
	require_once '../controllers/db.php';
	require_once '../controllers/login.php';
}

echo '<ol id="quest-list" start="0">';

foreach ($rallyeContent as $key => $value) {
	
	if ($key[0]=="P") {
		// si le parcours est publié ou qu'il est débloqué par l'utilisateur
		if ( array_key_exists($key, $_SESSION['unlocked']) ) {
			echo "<li code=\"$key\">$value[0]</li>";
		}else{
			echo "<li class=\"deactivated\">$value[0]</li>";
		}
	}
}

echo '</ol>';

?>

