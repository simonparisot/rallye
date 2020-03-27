<!DOCTYPE html>
<html>

<head>
	<title>Rallye d'Hiver 2019</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, height=device-height,  initial-scale=1.0"/>

	<link rel="icon" type="image/png" href="ressources/img/favicon.png" />
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

	<style type="text/css">
		a { outline: none; text-decoration: none; color: inherit; }
		html { font-size: 100%; } 
		body { background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), #000 url(ressources/img/waldo.jpg) center/cover no-repeat fixed; padding: 0; margin: 0; font-family: 'Open Sans', sans-serif; font-size: 1em; text-align: center; }
		#soon { text-align: left; margin: 5% 0; background-color: rgba(255, 255, 255, 0.9); color: #333; padding:50px 10%; border-radius: 25px; display: inline-block; }
		h1 { font-size: 1.3em; margin-bottom: 30px; }
		#errorMessage { color: red; margin-bottom: 20px; width: 350px; }
		.medium { width: 350px; }
		.medium span { font-size: 0.8em; }
		.textbox { background: none; border: none; border-bottom: 1px solid #bdc3c7; padding: 5px; color: #333; vertical-align: middle; outline:none; }
		.btn { cursor: pointer; color: #333; background-color: #fff000; border: 1px solid #ccc; padding: 6px 20px; margin-top: 20px; 
			vertical-align: middle; border-radius: 4px; transition: background-color .25s linear; -webkit-appearance: none; }
		.btn:hover { font-weight: bold; border: 1px solid #999; }
		input { display: block; margin: 15px 0; font: 1em 'Open Sans', sans-serif; }
	</style>

	<script src="ressources/jquery-1.11.2.min.js"></script>
	<script>
		$(document).ready(function(){void 0==document.createElement("input").placeholder&&$("[placeholder]").focus(function(){$(this).val()==$(this).attr("placeholder")&&$(this).val("")}).blur(function(){""==$(this).val()&&$(this).val($(this).attr("placeholder"))}).blur().parents("form").submit(function(){$(this).find("[placeholder]").each(function(){$(this).val()==$(this).attr("placeholder")&&$(this).val("")})})});
	</script>

</head>

<body>
<div id="soon">



<?php

if ( isset($_POST['equipe']) && isset($_POST['mdp_old']) && isset($_POST['mdp1']) && isset($_POST['mdp2']) ) {
	if ( $_POST['equipe'] == '' || $_POST['mdp_old'] == '' || $_POST['mdp1'] == '' || $_POST['mdp2'] == '' ) {
		echo '<div id="errorMessage">Oups, vous avez oublié de remplir certains champs.</div>';
	}elseif ( $_POST['mdp1'] != $_POST['mdp2']) {
		echo '<div id="errorMessage">La confirmation ne correspond pas... Veuillez svp ressaisir votre nouveau mot de passe et le confirmer à nouveau.</div>';
	}elseif ( strlen($_POST['mdp1']) < 6 ) {
		echo '<div id="errorMessage">Votre nouveau mot de passe doit contenir au moins 6 caractères (il serait dommage que l\'on vous vole les parcours que vous aurez durement acquis, n\'est-ce pas !).</div>';
	}else{
		require "controllers/db.php";
		sleep(3);
		$sth = $bdd->prepare('SELECT id, nom, pwd FROM rallye_people WHERE login = :login LIMIT 1');
		if ($sth->execute(array(':login' => $_POST['equipe']))) {
			$user = $sth->fetchAll();
			if( count($user) > 0 && password_verify($_POST['mdp_old'], $user[0]['pwd'])) {
					
					$hash = password_hash($_POST['mdp1'], PASSWORD_DEFAULT);
					$setpwd = $bdd->prepare('UPDATE rallye_people SET pwd = :pwd WHERE id = :id');
					$setpwd->execute(array(':pwd' => $hash, ':id' => $user[0]['id']));
					?>
						<h1>C'est fait !</h1>
						<img src="ressources/img/welldone.gif"><br>
						<div class="medium">
							<p>Votre mot de passe a bien été modifié.</p>
							<p>N'oubliez surtout pas de le communiquer aux autres membres de votre équipe <span>(sans cela ce rallye deviendrait franchement difficile pour eux...)</span>.</p>
						</div>
					<?
					exit;

			}else{
				echo '<div id="errorMessage">Cet identifiant n\'existe pas ou bien l\'ancien mot de passe n\'est pas le bon.</div>';
			}
		}else{
			echo '<div id="errorMessage">Désolé, erreur technique : contactez moi : <i>parisot.simon@gmail.com</i></div>';
		}
	}

}

?>

	<h1>Changer votre mot de passe</h1>
	<form action="" method="post" autocomplete="off">
		<input name="equipe" type="text" class="textbox medium" placeholder="Identifiant de votre équipe">
		<input name="mdp_old" type="text" class="textbox medium" placeholder="Ancien mot de passe">
		<input name="mdp1" type="text" class="textbox medium" placeholder="Nouveau mot de passe">
		<input name="mdp2" type="text" class="textbox medium" placeholder="Confirmez le nouveau mot de passe">
		<input type="submit" value="Envoyer" class="btn" >
	</form>
</div>

</body>
</html>