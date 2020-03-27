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
<?php
require_once '../controllers/db.php';

$search = $bdd->prepare('SELECT * FROM rallye_posts ORDER BY date DESC');

if ($search->execute()) {
	while ($team = $search->fetch()) {

		echo '<b>Enigme '.$team['enigme'].' - '.$team['equipe'].'</b> ('.$team['nom'].'), le '.Date('d/m à H:i', strtotime($team['date'])).'<br>';
		echo $team['text']."<br><br>";
	}
}
?>
</body>