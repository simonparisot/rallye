<?php

// AJAX controller

// ----------------------------------------------------------------------
// on vérifie si l'utilisateur a une session en cours
require_once 'initialize.php';
if (!$auth) { 

	echo json_encode(array('loginerror'));
	exit; 

}else{
	
	$questClueList = array();

	// pour chaque contenu débloqué
	foreach ($_SESSION['unlocked'] as $code => $value) {
		
		// si c'est un parcours et qu'il est résolu
		if ($code[0]=="P" && $value) {
			
			$questClueList[$code] = $rallyeContent[$code][3];

		}

	}

	echo json_encode( $questClueList );

}

?>