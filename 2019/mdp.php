<!DOCTYPE html>
<html>

<head>
	<title>Rallye d'Hiver 2016</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style type="text/css">
	body { font-family: calibri; font-size: 14px; }
	table { border-collapse: collapse; }
	td { border: 1px solid #ccc; border-bottom:2px solid #333; border-top:2px solid #333; }
	</style>
</head>

<body>
<form action="?" method="post">
<div>

<?

if (isset($_POST['mdp'])) {	echo password_hash($_POST['mdp'], PASSWORD_DEFAULT); }

?>
</div>
<input type="text" name="mdp" value="<?= (isset($_POST['mdp'])) ? $_POST['mdp'] : ''; ?>"><br>
<input type="submit" value="GO !">
</form>
</body>