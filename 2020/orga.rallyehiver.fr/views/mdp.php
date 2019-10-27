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


/* require_once '../../controllers/db.php';

if ( isset($_POST['nb']) ) {
	$setpwd = $bdd->prepare('UPDATE rallye_people SET pwd = :pwd WHERE id = :id');
	for ($i=0; $i <= 100 ; $i++) { 
		if ( isset($_POST[$i]) && $_POST[$i] != '') {
			$hash = password_hash($_POST[$i], PASSWORD_DEFAULT);
			$setpwd->execute(array(':pwd' => $hash, ':id' => $i));
		}
	}

}


?>

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
<table>

<?

$search = $bdd->prepare('SELECT id, login, nom FROM rallye_people WHERE nom != "Orga" ORDER BY id');
$nb = 0;
if ($search->execute()) {
	echo '<tr><th>Equipe</th><th>Identifiant</th><th>Mot de passe</th></tr>';
	while ($team = $search->fetch()) {
		$nb++;
		$contact = json_decode($team['contact'], true);
		echo '<tr>';
		echo '<td>'.htmlspecialchars($team['nom']).'</td>';
		echo '<td>'.htmlspecialchars($team['login']).'</td>';
		echo '<td><input type="text" name="'.$team['id'].'"></td>';
		echo "</tr>";
	}
	echo "</table>";
	echo '<input type="hidden" name="nb" value="'.$nb.'">';
}

*/
?>
</div>
<input type="text" name="mdp" value="<?= $_POST['mdp']; ?>"><br>
<input type="submit" value="GO !">
</form>
</body>