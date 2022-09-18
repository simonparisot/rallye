<?php

// AJAX controller
// ---------------

ob_start();

if( isset($_GET['code']) ) {

	require_once 'initialize.php';
	isset( $rallyeContent[$_GET['code']] )? $content = $rallyeContent[$_GET['code']] : exit;
	$type = ($_GET['code'][0]=="E")? "Enigme":"Parcours";
	$file = '../content/'.$_GET['code'].'.pdf';
	if (file_exists($file)) {
		ob_get_clean();
	    header('Content-Description: File Transfer');
	    header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename="'.$type.' - '.$content[0].'.pdf"');
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	    header('Content-Length: '.filesize($file));
	    readfile($file);
	    exit;
	}
}

?>