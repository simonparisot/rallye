<h1>Messages aux organisateurs</h1>

<?

require_once '../controllers/initialize.php';

$search = $bdd->prepare('SELECT equipe, msg, date FROM rallye_msg ORDER BY date DESC');

if ($search->execute()) {
	while ($msg = $search->fetch()) {

		echo '<div class="infoItem">';
		echo '<div class="meta"><b>'.$msg['equipe'].'</b> le '.Date('d/m à H:i', strtotime($msg['date'])).'</div><p>'.nl2br(htmlspecialchars($msg['msg'])).'</p>';
		echo '</div>';
		
	}
}

?>