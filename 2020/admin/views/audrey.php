<?

require_once '../controllers/db.php';

$search = $bdd->prepare('SELECT nom, contact FROM rallye_people WHERE nom != "Orga" ORDER BY id');

$teamCount = 0;
$teamList = '';

if ($search->execute()) {
	while ($team = $search->fetch()) {
		$teamCount++;
		$contact = json_decode($team['contact'], true);
		$teamList .= "<tr><td>".htmlspecialchars($team['nom'])."</td>";
		foreach ($contact as $member => $mail) {
			$teamList .= "<td>".$member." &#60;".$mail."&#62;</td>";
			//$teamList .= "$mail<br>";
		}
		$teamlist .= "</tr>";
	}
}
$teamList = "<table>$teamList</table>";

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
	<? echo $teamList; ?>
</body>