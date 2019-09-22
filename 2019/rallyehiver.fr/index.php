<?php
require_once 'ressources/info.php';
require_once 'controllers/db.php';
require_once 'controllers/login.php';

if (isset($_SESSION['admin']) && $_SESSION['admin']) {
	header('Location: http://orga.rallyehiver.fr/');
	exit();
}

?>

<!DOCTYPE html>
<html>

<head>

	<title>Rallye d'Hiver 2019</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, height=device-height,  initial-scale=1.0"/>

	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
	<link rel="manifest" href="/site.webmanifest">
	<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="msapplication-TileColor" content="#ffc40d">
	<meta name="theme-color" content="#ffffff">

	<link type="text/css" rel="stylesheet" href="ressources/style.css?<?= filemtime('ressources/style.css'); ?>" />
	<link href="https://fonts.googleapis.com/css?family=Indie+Flower|Open+Sans" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	
	<script src="ressources/jquery-1.11.2.min.js"></script>
	<script src="controllers/client_controller.min.js?<?= filemtime('controllers/client_controller.min.js'); ?>"></script>
	<!--[if lte IE 9]> <style> .col-gauche li.deactivated { cursor: default; color: #ccc; margin-left: 0; } </style> <![endif]-->
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		ga('create', 'UA-62904031-1', 'auto');
		ga('send', 'pageview');
	</script>
</head>

<body>

<?php 
	if (file_exists("views/staging.php")) require 'views/staging.php';
	if (preg_match('/(?i)msie [5-8]/',$_SERVER['HTTP_USER_AGENT'])) require 'views/iewarning.php';
?>

<div id="container">

	<div class="theend">
		<div class="helper"></div>
		<img src="ressources/img/end.gif">
	</div>

	<div class="logoheader">
		<img class="logo logo1" src="ressources/img/logo.png" />
		<img id="logo" class="logo logo2" src="ressources/img/logo.png" />
	</div>

	<div class="curtain white folded <? if(!$auth){ echo 'fixed'; } ?>">
		<img class="card-decoration" src="ressources/img/card-aspique.png">
		<div class="title">Enigmes</div>
		<div class="main-content">
			<div class="col-gauche"><? include $auth ? 'views/enigmes-list.php' : 'views/enigmes-list-public.php'; ?></div>
			<div class="col-droite"><? include $auth ? 'views/enigmes-content.php' : ''; ?></div>
		</div>
	</div>

	<div class="curtain grey folded <? if($auth) { echo $_SESSION['someQuest'] ? '' : 'fixed'; } ?>">
		<img class="card-decoration" src="ressources/img/card-2coeur.png">
		<div class="title"><? echo $auth ? 'Parcours' : 'Le Rallye d\'Hiver'; ?></div>
		<div class="main-content">
			<div class="col-gauche"><? include $auth ? 'views/quest-list.php' : 'views/info.php'; ?></div>
			<div class="col-droite"><? include $auth ? 'views/quest-content.php' : ''; ?></div>
		</div>
	</div>

	<div class="curtain purple folded fixed">
		<img class="card-decoration" src="ressources/img/card-7trefle.png">
		<div class="title teamName"><? echo $auth ? $_SESSION['nom'] : 'Connexion'; ?></div>
		<div class="main-content">
			<?
			if($auth) {
				if ($_SESSION['admin']) {
					header('Location: http://orga.rallyehiver.fr/');
					exit();
				}else{
					include 'views/team-content.php';
				}
			}else{ 
				echo '<form id="authform" action="?" method="post">';
				include 'views/loginform.php';
				echo '</form>';
			}
			?>
		</div>
	</div>

	<div id="popin">
		<section></section>
	</div>

</div>

<script>
	$('.folded').removeClass('folded');
</script>

</body>
</html>