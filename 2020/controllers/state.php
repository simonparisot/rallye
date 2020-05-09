<?php

// AJAX controller

// ----------------------------------------------------------------------
// on vérifie si l'utilisateur a une session en cours
require_once '../ressources/info.php';
require_once 'db.php';
require_once 'login.php';
if (!$auth) { 

	echo json_encode(array('loginerror'));
	exit; 

}else{

	echo $_SESSION['unlocked']==null? '{}' : json_encode($_SESSION['unlocked']);

}

?>