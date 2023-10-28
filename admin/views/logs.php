<?php

if (!isset($_GET['justdata'])) { // appel ajax juste pour les données ?

	?>
	<h1>Mots de passe testés</h1>

	<table>
	<thead>
		<tr>
			<th>Date</th>
			<th><input type="text" name="team" class="textbox logs-input"></th>
			<th><input type="text" name="enigme" class="textbox logs-input"></th>
			<th><input type="text" name="mdp" class="textbox logs-input"></th>
		</tr>
	</thead>
	<tbody id="log-table">
	<?php

}

require_once '../controllers/initialize.php';

$filters = (isset($_GET['team']) && $_GET['team']!='') ? ' AND equipe LIKE "%'.$_GET['team'].'%"' : '';
$filters .= (isset($_GET['enigme']) && $_GET['enigme']!='') ? ' AND enigme LIKE "%'.$_GET['enigme'].'%"' : '';
$filters .= (isset($_GET['mdp']) && $_GET['mdp']!='') ? ' AND mdp LIKE "%'.$_GET['mdp'].'%"' : '';

$limit = (isset($_GET['all'])) ? '' : 'LIMIT 400';

$SQL = 'SELECT * FROM rallye_try WHERE equipe != "orga" '.$filters.' ORDER BY date DESC '.$limit;

$search = $bdd->prepare($SQL);

if ($search->execute()) {
	while ($log = $search->fetch()) {

		$oldcar = array(" ", "-", "'", "é", "è", "à", "ê", "â", "ô", "ç", "û", "ù", "ï", "î", "’");
        $newcar = array("", "", "", "e", "e", "a", "e", "a", "o", "c", "u", "u", "i", "i", "");
        $mdp = strtolower(str_replace($oldcar, $newcar, $log['mdp']));

		echo $rallyeContent[$log['enigme']][2] == $mdp ? '<tr class="goodguess">' : '<tr>';
		echo '<td class="dat">'.$log['date'].'</td><td class="nom">'.$log['equipe'].'</td><td class="eni">'.substr($log['enigme'],0, 3).'</td><td class="mdp">'.htmlspecialchars($log['mdp']).'</td>';
		echo '</tr>';
	}
}

if ($limit != '') {
	?> <tr><td colspan="4"><div class="loadmore" onclick="loadLogs('all&');">Charger tous les logs</div></td></tr> <?
}

?>
