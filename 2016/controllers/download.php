<?php

// AJAX controller
// ---------------

ob_start();
require_once 'initialize.php';

// Si l'utilisateur veut télécharger une énigme
if( isset($_GET['enigme']) ) {

	$index = $_GET['enigme']-1;

	if (isset($enigmeList[$index]) || $enigmeList[$index] != "") {

		switch ($_GET['enigme']) {
			case 6:
				$img = imagecreatefromjpeg("../enigmes/Enigme 6 - Métronome.jpg");
				header('Content-Description: File Transfer');
			    header('Content-Type: application/octet-stream');
			    header('Content-Disposition: attachment; filename="Enigme 6 - Métronome.jpg"');
			    header("Cache-Control: no-cache, must-revalidate");
				header("Expires: Sat, 1 Jan 2000 00:00:00 GMT");
			    header('Pragma: public');
			    imagejpeg($img);
				exit;
			case 13:
				$file = "../enigmes/Enigme 13 - Attrape-moi si tu peux.mp4"; break;
			case 15:
				$file = "../enigmes/Enigme 15 - L'or du Rhin.mp3"; break;
			case 19:
				header('location: ../enigmes/Enigme 19 - '.$enigmeList[$index][0].'.php?img&download'); exit;			
			default:
				$file = '../enigmes/Enigme '.$_GET['enigme'].' - '.$enigmeList[$index][0].'.pdf'; break;
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
		    header('Content-Disposition: attachment; filename="Questionnaire '.$questList[$_GET['code']].'.pdf"');
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