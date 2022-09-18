<?php
require_once 'controllers/initialize.php';

if (isset($_SESSION['admin']) && $_SESSION['admin']) {
	header('Location: http://admin.rallyehiver.fr/');
	exit();
}

?>

<!DOCTYPE html>
<html>

<head>

	<title>Rallye d'Hiver 2020</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, height=device-height,  initial-scale=1.0"/>

	<link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
	<link rel="manifest" href="/favicon/site.webmanifest">
	<link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#5bbad5">
	<link rel="shortcut icon" href="/favicon/favicon.ico">
	<meta name="msapplication-TileColor" content="#ffc40d">
	<meta name="msapplication-config" content="/favicon/browserconfig.xml">
	<meta name="theme-color" content="#ffffff">

	<link type="text/css" rel="stylesheet" href="ressources/style.css?<?= filemtime('ressources/style.css'); ?>" />
	<link type="text/css" rel="stylesheet" href="ressources/style-mobile.css?<?= filemtime('ressources/style-mobile.css'); ?>" />
	<link href="https://fonts.googleapis.com/css?family=Abril+Fatface|Roboto:400,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	
	<script src="ressources/jquery-1.11.2.min.js"></script>
	<script src="controllers/client_controller.min.js?<?= filemtime('controllers/client_controller.min.js'); ?>"></script>
	
	<script>
		// Google Analytics tag
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		ga('create', 'UA-62904031-1', 'auto');
		ga('send', 'pageview');
	</script>

	<script> 
		// Browser update notification, from browser-update.org
		var $buoop = {required:{e:-4,f:-3,o:-3,s:-1,c:-3},insecure:true,api:2019.11 }; 
		function $buo_f(){ 
		 var e = document.createElement("script"); 
		 e.src = "//browser-update.org/update.min.js"; 
		 document.body.appendChild(e);
		};
		try {document.addEventListener("DOMContentLoaded", $buo_f,false)}
		catch(e){window.attachEvent("onload", $buo_f)}
	</script>

</head>

<body>

<div id="container">

<?php 
// AUTHENTICATED WEBSITE
if ($auth): ?>

	<div class="logoheader">
		<img class="logo" src="ressources/img/logo.png" />
	</div>

	<div class="curtain white folded <?php if(!$auth){ echo 'fixed'; } ?>">
		<div class="title">Enigmes</div>
		<div class="main-content">
			<div class="col-gauche"><?php include 'views/enigmes-list.php'; ?></div>
			<div class="col-droite"><?php include 'views/enigmes-content.php'; ?></div>
		</div>
	</div>

	<div class="curtain grey folded">
		<div class="title"><? echo $auth ? 'Parcours' : 'Le Rallye d\'Hiver'; ?></div>
		<div class="main-content">
			<div class="col-gauche"><?php include 'views/quest-list.php'; ?></div>
			<div class="col-droite"><?php include 'views/quest-content.php'; ?></div>
		</div>
	</div>

	<div class="curtain purple folded fixed">
		<div class="title teamName"><?php echo $_SESSION['nom']; ?></div>
		<div class="main-content"><?php include 'views/team-content.php'; ?></div>
	</div>

	<div id="popin">
		<section></section>
	</div>

<?php 
// PUBLIC LANDING PAGE
else: ?>

	<div class="logoheader">
		<img class="logo biglogo" src="ressources/img/logo.png" />
	</div>

	<div class="curtain grey folded">
		<div class="title teamName">Connexion</div>
		<div class="main-content"><?php include 'views/loginform.php'; ?></div>
	</div>

	<div class="curtain purple folded">
		<div class="title">Le Rallye d'Hiver</div>
		<div class="main-content">
			<div class="col-gauche"><?php include 'views/info.php'; ?></div>
		</div>
	</div>

<?php endif; ?>

</div>

</body>
</html>