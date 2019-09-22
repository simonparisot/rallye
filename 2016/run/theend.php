<!DOCTYPE html>
<html>

<head>
	<title>Rallye d'Hiver 2016</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style type="text/css">
		body { margin:0; padding: 0; font-size: 3em; font-family: sans-serif; text-align: center; }
		h1 { font-size: 3em; font-family: sans-serif; }
		#logo { margin: 1em 0; }
		#clef { width: 100%; }
		#help { font-size: 0.5em; font-style: italic; }
		input { margin-top: 1em; font-size: 1em; padding: 1em; }
		input[type='submit'] { margin-bottom: 1em; }
	</style>
</head>

<body>

<div id="logo"> <img src="logo.png"> </div>

<?php
	
	if ( isset($_GET['mail']) ) {
	
		echo '<form action="?" method="POST"><input type="email" name="mailto" placeholder="Saisissez votre e-mail"><br><input type="submit" value="Valider"></form>';
	
	}elseif ( isset($_POST['mailto']) ) {
	
		$message = <<<EOD
Après votre rendez-vous (vert) galant, il vous reste à résoudre une dernière énigme !
http://rallyehiver.fr/run/theend.php

Bon courage !

Terpsichore
EOD;
		
		$headers = 'From: terpsichore@rallyehiver.fr'."\r\n".
		'Reply-To: terpsichore@rallyehiver.fr'."\r\n" .
		'X-Mailer: PHP/' . phpversion();

		mail($_POST['mailto'], 'Enigme Rendez-vous galant', $message, $headers);
		echo 'message envoyé !<br><a href="?">Revenir à l\'énigme</a>';
	
	}else{
?>

Il est la clé de cette énigme :<br>
<img id="clef" src="theend.jpg">
<div id="help">Vous pouvez vous envoyer cette page par mail pour la résoudre plus tard.<br> <a href="?mail">Pour cela, cliquez-ici.</a></div>

<? 	} ?>

</body>
</html>