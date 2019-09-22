<?php

	if ( isset($_POST['reponse']) ) {
		
		$oldcar = array(" ", "-", "'", "é", "è", "à", "ê", "â", "ô", "ç", "û", "ù", "ï", "î");
        $newcar = array("", "", "", "e", "e", "a", "e", "a", "o", "c", "u", "u", "i", "i");
        $reponse = strtolower(str_replace($oldcar, $newcar, $_POST['reponse']));

		if ( $reponse == "emeraude" ) {
			header('Location: theend.php');exit;
		}else{
			$fail = "";
		}
	}

?>

<!DOCTYPE html>
<html>

<head>
	<title>Rallye d'Hiver 2016</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style type="text/css">
		body { margin:0; padding: 0; font-size: 3em; font-family: sans-serif; text-align: center; }
		h1 { font-size: 3em; font-family: sans-serif; }
		#logo { margin: 10px 0; }
		input { margin-top: 2em; font-size: 1em; padding: 1em; }
		input[type='submit'] { margin-bottom: 2em; }
		p { max-width: 982px; margin: 1em auto; }
	</style>
</head>

<body>

<div id="logo"> <img src="logo.png"> </div>
<p>Bien joué ! Tant que vous êtes ici, pourriez-vous en profiter pour étudier ces quelques photos ?</p>
<div> <img src="img1.jpg"> </div>
<div> <img src="img2_new.jpg"> </div>
<div> <img src="img3.jpg"> </div>
<div> <img src="img4.jpg"> </div>
<div> <img src="img5.jpg"> </div>
<div> <img src="img6.jpg"> </div>
<div> <img src="img7.jpg"> </div>
<div> <img src="img8.jpg"> </div>

<form action="?" method="POST">
	<input type="text" name="reponse" placeholder="Qu'en pensez-vous ?"><br>
	<input type="submit" value="Valider">
</form>

</body>
</html>