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

// on vérifie qu'il y a bien un code attaché à l'URL
$code1 = 'IllIlllIIIlIIl';
$code2 = 'lIIlllIlIIlIII';
if ( isset($_GET['y']) && ($_GET['y'] == $code1 || $_GET['y'] == $code2) ) {

	require_once '../controllers/db.php';
	require_once '../controllers/login.php';

	// si l'utilisateur n'est pas déjà loggé on lui donne le formulaire d'uathentification light (juste le nom d'équipe)
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
	$team = $_SESSION['rdvgalant'];
	$thisCode = $_GET['y'];
	$timer = 60*2; // temps de course en secondes

	// Est-ce que la personne est déjà en train de courir ? (elle a déjà scanné un QRcode)
	$sth = $bdd->prepare('SELECT * FROM rallye_escapade WHERE login = :login ORDER BY date DESC LIMIT 1');
	$tempsrestant = -1; // non par défaut
	if ($sth->execute(array(':login' => $team)) {
		$result = $sth->fetchAll();
		if( count($result) > 0 ) { 
			
			// la personne a déjà scanné un QRcode, on enregistre lequel et quand
			$lastCode = $result[0]['code'];
			$tempsrestant = $timer - (time() - strtotime($result[0]['date']));
			
			// on vérifie si le chrono est terminé
			if ($tempsrestant > 0) {
			
				// le chrono est en cours et il reste du temps ! On vérifie si le QRcode qui vient d'être scanné est bien l'autre
				if ( ($lastCode == $code1 && $thisCode == $code2) || ($lastCode == $code2 && $thisCode == $code1) ) {

					// C'est bien l'autre code, c'est gagné, on affiche le prochain tiroir
					// ...

				}else{

					// la personne a rescanné le même code (ou rechargé la page), on ré-affiche le chrono en cours
					// ...

				}
			
			}elseif ($tempsrestant <= 0 && $tempsrestant > -5*60) {

				// le chrono est terminé depuis moins de 5 minute, on vérifie si le QRcode qui vient d'être scanné est bien l'autre
				if ( ($lastCode == $code1 && $thisCode == $code2) || ($lastCode == $code2 && $thisCode == $code1) ) {

					// C'est bien l'autre code, mais c'est trop tard ^^ on affiche raté
					// ...

				}else{

					// la personne a rescanné le même code (ou rechargé la page), on considère que c'est un le début d'une nouvelle course, donc on enregistre ce code en BDD et on lance le chrono
					// ...

				}

			}else{

				// le chrono est terminé depuis plus de 5 minute, on considère que c'est un le début d'une nouvelle course, donc on enregistre ce code en BDD et on lance le chrono
				// ...

			}

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
			echo '<h1>raté :(</h1>';
		}
	}

}else{

	//aucun code n'a été founi dans l'URL...
	echo "Erreur, scannez à nouveau le QRcode svp.";

}

?>

</body>
</html>