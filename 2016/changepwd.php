<!DOCTYPE html>
<html>

<head>
	<title>RH2016 | Changer son mot de passe</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<style type="text/css">
		a { outline: none; text-decoration: none; color: inherit; }
		html { font-size: 100%; } 
		body { background: #df5537 url("ressources/img/bg.png") repeat; padding: 0; margin: 0; font-family: 'Open Sans', sans-serif; font-size: 1em; text-align: center; }
		#soon { text-align: left; margin: 5% 0; background-color: rgba(54, 41, 46, 0.8); color: #fff; padding:50px 10%; border-radius: 25px; display: inline-block; }
		h1 { font-size: 1.3em; }
		#errorMessage { color: #e85938; margin-bottom: 20px; width: 350px; }
		.medium { width: 350px; }
		.medium span { font-size: 0.8em; }
		.textbox { background: none; border: none; border-bottom: 1px solid #bdc3c7; padding: 5px; color: #fff; vertical-align: middle; outline:none; }
		.btn { cursor: pointer; color: #fff; background-color: #e85938; border: none; padding: 6px 20px; margin-top: 20px; 
			vertical-align: middle; border-radius: 4px; transition: background-color .25s linear; }
		.btn:hover { background-color: #e68772; }
		input { display: block; margin: 15px 0; font: 1em 'Open Sans', sans-serif; }
	</style>
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
		echo '<div id="errorMessage">Votre nouveau mot de passe doit contenir au moins 6 caractères (il serait dommage que l\'on vous vole les questionnaires que vous aurez durement acquis, n\'est-ce pas !).</div>';
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
							<br>
							<i>Terpsichore</i>
						</div>
					<?
					exit;

			}else{
				echo '<div id="errorMessage">Cet identifiant n\'existe pas ou bien l\'ancien mot de passe n\'est pas le bon.</div>';
			}
		}else{
			echo '<div id="errorMessage">Désolé, erreur technique : contactez <i>simon@rallyehiver.fr</i></div>';
		}
	}

}

?>

	<h1>Changer votre mot de passe</h1>
	<form action="" method="post" autocomplete="off">
		<input name="equipe" type="text" class="textbox font2 medium" placeholder="Identifiant de votre équipe">
		<input name="mdp_old" type="text" class="textbox font2 medium" placeholder="Ancien mot de passe">
		<input name="mdp1" type="text" class="textbox font2 medium" placeholder="Nouveau mot de passe">
		<input name="mdp2" type="text" class="textbox font2 medium" placeholder="Confirmez le nouveau mot de passe">
		<input type="submit" value="Envoyer" class="btn font2" >
	</form>
</div>

</body>
</html>