<!DOCTYPE html>
<html>

<head>
	<title>Rallye d'Hiver 2016</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style type="text/css">
	body { font-family: 'Arial', sans-serif; font-size: 18px; padding: 20px; background-color: #ddd; text-align: center;}
	input { margin-bottom: 10px; width: 300px; padding: 10px; font-size: 18px; }
	</style>
</head>

<body>
<form action="?" method="post">
<input type="text" name="mdp" value="<?= (isset($_POST['mdp'])) ? $_POST['mdp'] : ''; ?>"><br>
<input type="submit" value="GO !">
</form>

<div> 
<?php
if (isset($_POST['mdp'])) {	echo "Résultat : <br><b>".password_hash($_POST['mdp'], PASSWORD_DEFAULT)."</b>"; }
?>
</div>

</body>