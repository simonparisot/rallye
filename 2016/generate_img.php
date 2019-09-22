<?php

ob_start();
require_once 'ressources/info.php';

echo '<pre>';
/*foreach ($questList as $code => $name) {
	
	$file = "$code - $name";
	exec('gs -dBATCH -dNOPAUSE -dSAFER -dQUIET -sDEVICE=jpeg -dTextAlphaBits=4 -dGraphicsAlphaBits=4 -r200 -sOutputFile="quest/temp/'.$file.'-%02d.jpg" "quest/'.$file.'.pdf"', $output);
	
	unset($output);

	if (is_file("quest/temp/$file-01.jpg")) {
		
		$img_src = imagecreatefromjpeg("quest/temp/$file-01.jpg");
		$img_dst = imagecreatetruecolor(1654, 2339);
		list($width, $height) = getimagesize("quest/temp/$file-01.jpg");
		imagecopyresampled($img_dst, $img_src, 0, 0, 0, 0, 1654, 2339, $width, $height);

		for ($i=2; $i < 5; $i++) { 
			if (file_exists("quest/temp/$file-0$i.jpg")) {
				$img_new = imagecreatefromjpeg("quest/temp/$file-0$i.jpg");
				list($width, $height) = getimagesize("quest/temp/$file-0$i.jpg");
				$img_temp = imagecreatetruecolor(1654, $i*2339);
				imagecopy($img_temp, $img_dst, 0, 0, 0, 0, 1654, ($i-1)*2339);
				imagecopyresampled($img_temp, $img_new, 0, ($i-1)*2339, 0, 0, 1654, 2339, $width, $height);
				$img_dst = $img_temp;
			}else{ break; }
		}
		imagejpeg($img_dst, "quest/img/$file.jpg");
		echo "Questionnaire $name exporté<br>";
		ob_flush();
	
	}else{
		echo "<span style=\"color:red; font-weight:bold;\">Impossible d'exporter le questionnaire $name</span><br>";
		ob_flush();
	}
}*/

echo "<br>";

foreach ($enigmeList as $key => $name) {
	if ($name[0] == "Métronome") { echo "<span style=\"color:red; font-weight:bold;\">Enigme $name[0] non exportée (export manuel)</span><br>"; continue; }
	$key++;
	$file = "Enigme $key - $name[0]";
	exec('gs -dBATCH -dNOPAUSE -dSAFER -dQUIET -sDEVICE=jpeg -dTextAlphaBits=4 -dGraphicsAlphaBits=4 -r300 -sOutputFile="enigmes/temp/'.$file.'.jpg" "enigmes/'.$file.'.pdf"', $output);
	
	if (count($output) != 0) {
		echo "<span style=\"color:red; font-weight:bold;\">Impossible d'exporter l'énigme ($key) $name[0]</span><br>";
		ob_flush();
	}else{
		/*$img_src = imagecreatefromjpeg("enigmes/temp/$file.jpg");
		$img_dst = imagecreatetruecolor(707, 1000);
		imagesavealpha($img_dst, false);
		list($width, $height) = getimagesize("enigmes/temp/$file.jpg");
		imagecopyresampled($img_dst, $img_src, 0, 0, 0, 0, 707, 1000, $width, $height);
		imagejpeg($img_dst, "enigmes/img/$file.jpg");*/
		echo "Enigme $name[0] exportée<br>";
		ob_flush();
	}
	unset($output);
}

ob_end_flush();

?>