<?php

if (!isset($bdd)) {
	require_once '../ressources/info.php';
	require_once '../controllers/db.php';
	require_once '../controllers/login.php';
}

echo '<ol id="enigmes-list" start="0">';

foreach ($rallyeContent as $key => $value) {

	if ($key[0]=="E") {
		// si l'énigme est publiée ou bien qu'elle est débloquée par l'utilisateur
		if ( array_key_exists($key, $_SESSION['unlocked']) ) {
			echo "<li code=\"$key\">$value[0]</li>";
		}else{
			echo "<li class=\"deactivated\">$value[0]</li>";
		}
	}
}

echo '</ol>';

?>