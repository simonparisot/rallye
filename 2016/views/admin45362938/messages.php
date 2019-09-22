<h1>Messages des équipes</h1>

<?

require '../../controllers/db.php';
$search = $bdd->prepare('SELECT t.equipe, t.msg, t.date, tm.contact FROM rallye_msg t INNER JOIN (SELECT nom, contact FROM rallye_people) tm ON t.equipe = tm.nom ORDER BY t.date DESC');

if ($search->execute()) {
	while ($msg = $search->fetch()) {
		$recipients ='';
		$contacts = json_decode($msg['contact'], true);
		foreach ($contacts as $key => $value) $recipients .= $value.';';
		echo '<div class="infoItem">';
		echo '<p><b>'.$msg['equipe'].'</b> le '.Date('d/m à H:i', strtotime($msg['date'])).'</p><p>'.nl2br(htmlspecialchars($msg['msg'])).'</p>';
		echo '<a href="mailto:'.$recipients.'?cc=terpsichore@rallyehiver.fr"><div class="repondreMsg"></div></a>';
		echo '</div>';
	}
}

?>