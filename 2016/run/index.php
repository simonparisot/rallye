<!DOCTYPE html>
<html>

<head>
	<title>Rallye d'Hiver 2016</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style type="text/css">
		body { font-size: 2em; font-family: sans-serif; text-align: center; }
		h1 { font-size: 3em; font-family: sans-serif; }
		input { margin-top: 2em; font-size: 2em; padding: 1em; }
		input[type='submit'] { margin-bottom: 2em; }
	</style>
</head>

<body>

<?php

require_once '../controllers/db.php';
require_once '../controllers/login.php';

//unset($_SESSION['rdvgalant']);

if(!isset($_SESSION['rdvgalant']) && !$auth && (!isset($_POST['equipe']) || $_POST['equipe']=='') ) { ?>

	<h1>Bienvenue !</h1>
	<p>Ceci est une énigme du Rallye d'Hiver 2016 !</p>
	<p>Si vous êtes déjà un participant du rallye, entrez le nom de votre équipe ci-dessous pour que votre avancement soit compatibilisé. Si vous n'êtes pas un participants mais un simple passant curieux, n'hésitez pas à jouer également en entrant votre nom ci-dessous :)</p>
	<p>Vous pouvez découvrir le Rallye d'Hiver sur le site <i>rallyehiver.fr.</i></p>
	<form id="authform" method="post">
	<input name="equipe" type="text" placeholder="votre nom d'équipe...">
	<input type="submit" value="Envoyer">
	</form>

<?	exit;
}

if(!isset($_SESSION['rdvgalant'])) $_SESSION['rdvgalant'] = $auth ? $_SESSION['login'] : $_POST['equipe'];
$code1 = 'IllIlllIIIlIIl';
$code2 = 'lIIlllIlIIlIII';
$timer = 60*2; // temps de course en secondes

# on récupère le moment du dernier scan du 1er qrcode
$sth = $bdd->prepare('SELECT * FROM rallye_escapade WHERE login = :login ORDER BY date DESC LIMIT 1');
$tempsrestant = -1;
if ($sth->execute(array(':login' => $_SESSION['rdvgalant']))) {
	$result = $sth->fetchAll();
	if( count($result) > 0 ) { 
		$tempsrestant = $timer - (time() - strtotime($result[0]['date']));
	}
}

# l'utilisateur a scanné le premier qrcode
if ( isset($_GET['y']) && $_GET['y'] == $code1 ) {

	# Si il n'y a pas eu de scan avant, ou il est trop vieux
	if ($tempsrestant < 0) {
		$sth = $bdd->prepare('INSERT INTO rallye_escapade (login) VALUES (:login)');
		$sth->execute(array(':login' => $_SESSION['rdvgalant']));
		$tempsrestant = $timer;
	}

	?>

	<h1 id="timer"></h1>
	<script>
	var timer = <?= $tempsrestant ?>;
	var zeTimer = setInterval(function () {
			minutes = parseInt(timer / 60, 10);
	        seconds = parseInt(timer%60, 10);
	        minutes = minutes < 10 ? "0" + minutes : minutes;
	        seconds = seconds < 10 ? "0" + seconds : seconds;
	        document.querySelector('#timer').textContent = minutes + ":" + seconds;
	        if(--timer<0) timer=0;
	    }, 1000);
	</script>
	<p><?= ucfirst($_SESSION['rdvgalant']) ?>, vous avez 2 minutes pour trouver et scanner le prochain QRcode !</p>
	<img src="code2location.jpg" />

	<?

# Si l'utilisateur scanne le second code
}elseif ( isset($_GET['y']) && $_GET['y'] == $code2 ){

	if ($tempsrestant > 0) {
		$sth = $bdd->prepare('UPDATE rallye_escapade SET reussi = 1 WHERE login = :login');
		$sth->execute(array(':login' => $_SESSION['rdvgalant']));
		header('Location: welldone.php');
	}else{
		//echo '<h1>raté :(</h1>';
		echo "<h1>Trop tard !</h1><p>Scannez à nouveau le code 1.</p>";
	}

}else{ echo "Erreur, re-scannez le QRcode."; }

?>

</body>
</html>