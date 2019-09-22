<?php

echo '<ol id="enigmes-list">';

foreach ($enigmeList as $value) {
	if ($value[1]) { // si le statut de publication de l'énigme est true
		
		if 		($value[0]=="Petites Annonces" && $_SESSION['login']=="sacregrallye") echo "<li rel=\"-akzjvbiea\">$value[0]</li>";
		else if ($value[0]=="La theorie des jeux") echo "<li rel=\"-" . $_SESSION['e20-enigme'] . "\">$value[0]</li>";
		else echo "<li>$value[0]</li>";

	}else{
		echo "<li class=\"deactivated\">$value[0]</li>";
	}

}

echo '</ol>';

?>