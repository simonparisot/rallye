<?php

$tmpdir = '/home/rallyedh/tmp';							// temporary upload folder
require('UploadProgressManager.class.php');				// The class UploadProgressManager
$UPM = new UploadProgressManager($tmpdir);				// new UploadProgressManager with temporary upload folder
if(($output = $UPM->getTemporaryFileSize()) === false)	// if UPM class cannot find the temporary file
	echo 0;												// the output for LoadVars will be undefined
else
	if(floor($output/1000) < 1000){						// else the output will be temporary file size
		echo floor($output/1000).' Ko';
	}else{
		echo (floor($output/10000)/100).' Mo';
	}
?>