<?php

// AJAX controller
// ---------------

ob_start();
require_once '../ressources/info.php';

// Si l'utilisateur veut télécharger une énigme
if( isset($_GET['enigme']) ) {

	$index = $_GET['enigme']-1;

	if (isset($enigmeList[$index]) || $enigmeList[$index] != "") {

		if ($_GET['enigme'] == 2) {
			$file = "../enigmes/Enigme 2 - Les 7 familles en or.mp3";
		} else {
			$file = '../enigmes/Enigme '.$_GET['enigme'].' - '.$enigmeList[$index][0].'.pdf';
		}		

		if (file_exists($file)) {
			ob_get_clean();
		    header('Content-Description: File Transfer');
		    header('Content-Type: application/octet-stream');
		    header('Content-Disposition: attachment; filename="'.basename($file).'"');
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate');
		    header('Pragma: public');
		    header('Content-Length: '.filesize($file));
		    readfile($file);
		    exit;
		}
	}

// Si l'utilisateur veut télécharger un questionnaire
}else if( isset($_GET['code']) && strlen($_GET['code'])==10 ) {

	if (isset($questList[$_GET['code']]) || $questList[$_GET['code']] != "") {

		$file = '../quest/'.$_GET['code'].' - '.$questList[$_GET['code']].'.pdf';

		if (file_exists($file)) {
			ob_get_clean();
		    header('Content-Description: File Transfer');
		    header('Content-Type: application/octet-stream');
		    header('Content-Disposition: attachment; filename="Parcours '.$questList[$_GET['code']].'.pdf"');
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate');
		    header('Pragma: public');
		    header('Content-Length: '.filesize($file));
		    readfile($file);
		    exit;
		}
	}
}

?>