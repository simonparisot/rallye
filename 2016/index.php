<?php
require_once 'controllers/initialize.php';
?>

<!DOCTYPE html>
<html>

<head>
	<title>Rallye d'Hiver 2016</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="icon" type="image/png" href="ressources/img/favicon.png" />
	<link type="text/css" rel="stylesheet" href="ressources/style.css?<?= filemtime('ressources/style.css'); ?>" />
	<script src="ressources/jquery-1.11.2.min.js"></script>
	<script src="controllers/client_controller.js?<?= filemtime('controllers/client_controller.js'); ?>"></script>
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

<?if(preg_match('/(?i)msie [5-8]/',$_SERVER['HTTP_USER_AGENT'])) { require 'views/iewarning.php'; }?>

<div id="container">

	<div class="curtain white <? if($auth){ echo $_SESSION['admin'] ? 'reduced john' : ''; }else{ echo 'fixed'; } ?>">
		<div class="header">
			<img id="logo" src="ressources/img/logo.png" />
		</div>
		<div class="title">Enigmes</div>
		<div class="main-content">
			<div class="col-gauche"><? include $auth ? 'views/enigmes-list.php' : 'views/enigmes-list-public.php'; ?></div>
			<div class="col-droite"><? include $auth ? 'views/enigmes-content.php' : ''; ?></div>
		</div>
		<div class="border white_border"></div>
	</div>

	<div class="curtain grey <? if($_SESSION['admin']){ echo 'reduced john'; }else{ echo $_SESSION['someQuest'] ? '' : 'fixed'; } ?>">
		<div class="header">
			<img src="ressources/img/crown.png" class="diego" ref="crown" />
		</div>
		<div class="title"><? echo $auth ? 'Questionnaires' : 'Informations'; ?></div>
		<div class="main-content">
			<div class="col-gauche"><? include $auth ? 'views/quest-list.php' : 'views/info.php'; ?></div>
			<div class="col-droite"><? include $auth ? 'views/quest-content.php' : ''; ?></div>
		</div>
		<div class="border grey_border"></div>
	</div>

	<div class="curtain purple <? echo $_SESSION['admin'] ? 'expanded john' : 'fixed'; ?>">
		<div class="header">
			<img src="ressources/img/diamond.png" class="diego" ref="diamond" />
		</div>
		<div class="title teamName"><? echo $auth ? $_SESSION['nom'] : 'Connexion'; ?></div>
		<div class="main-content">
			<?
			if($auth) { include $_SESSION['admin'] ? 'views/admin45362938/page-template.php' : 'views/team-content.php';
			}else{ 
				include 'views/loginform.php';
			}
			?>
		</div>
		<div class="border purple_border"></div>
	</div>

</div>

<? if($_SESSION['jetlag']) echo '<script src="controllers/jetlag.js"></script>' ?>

</body>
</html>