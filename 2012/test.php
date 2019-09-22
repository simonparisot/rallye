<?
// echo filesize('upload/bob.mp3');
$MyDirectory = opendir('upload') or die('Erreur lors de l\'ouverture de la directory');
while($Entry = @readdir($MyDirectory)) {
	if($Entry != '.' && $Entry != '..' && $Entry != 'index.html'){
		if(filesize('upload/'.$Entry) < 1000000) $Fsize = round(filesize('upload/'.$Entry)/1000).' Ko';
		else $Fsize = round(filesize('upload/'.$Entry)/1000000).' Mo';
		echo $Entry.' : '.$Fsize;
	}
}
closedir($MyDirectory);
?>