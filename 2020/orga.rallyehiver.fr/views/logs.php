<?
if (!isset($_GET['justdata'])) { // appel ajax juste pour les données ?
?>

<h1>Mots de passe testés</h1>

<script type="text/javascript">
	$(document).ready(function() { 
		$('input').keyup(function() { loadLogs(); })
		$('input').change(function() { loadLogs(); })
		refreshIntervalId = setInterval(function(){ 
            loadLogs();
        }, 3000);
	});

	function loadLogs (all) {
		if(typeof all === "undefined") all='';
		Fteam = $( "input[name='team']" ).val();
		Fenigme = $( "input[name='enigme']" ).val();
		Fmdp = $( "input[name='mdp']" ).val();
		$('#log-table').load('views/logs.php?'+all+'justdata&team='+Fteam+'&enigme='+Fenigme+'&mdp='+Fmdp);
	}
</script>

<table>
<thead>
	<tr>
		<th>Date</th>
		<th><input type="text" name="team" class="textbox" placeholder="Equipe"></th>
		<th><input type="number" min="1" max="21" name="enigme" class="textbox" placeholder="Enigme"></th>
		<th><input type="text" name="mdp" class="textbox" placeholder="Mot de passe"></th>
	</tr>
</thead>
<tbody id="log-table">
<?

}

require '../controllers/db.php';
require '../ressources/info.php';

$filters = (isset($_GET['team']) && $_GET['team']!='') ? ' AND equipe LIKE "%'.$_GET['team'].'%"' : '';
$filters .= (isset($_GET['enigme']) && $_GET['enigme']!='') ? ' AND enigme = '.$_GET['enigme'] : '';
$filters .= (isset($_GET['mdp']) && $_GET['mdp']!='') ? ' AND mdp LIKE "%'.$_GET['mdp'].'%"' : '';

$limit = (isset($_GET['all'])) ? '' : 'LIMIT 400';

$SQL = 'SELECT * FROM rallye_try WHERE equipe != "orga" AND equipe != "theb2" '.$filters.' ORDER BY date DESC '.$limit;
//echo $SQL.'<br>';
$search = $bdd->prepare($SQL);

if ($search->execute()) {
	while ($log = $search->fetch()) {

		$oldcar = array(" ", "-", "'", "é", "è", "à", "ê", "â", "ô", "ç", "û", "ù", "ï", "î", "’");
        $newcar = array("", "", "", "e", "e", "a", "e", "a", "o", "c", "u", "u", "i", "i", "");
        $mdp = strtolower(str_replace($oldcar, $newcar, $log['mdp']));

		echo $enigmeList[$log['enigme']-1][2] == $mdp ? '<tr class="goodguess">' : '<tr>';
		echo '<td class="dat">'.$log['date'].'</td><td class="nom">'.$log['equipe'].'</td><td class="eni">'.$log['enigme'].'</td><td class="mdp">'.htmlspecialchars($log['mdp']).'</td>';
		echo '</tr>';
	}
}

if ($limit != '') {
	?> <tr><td colspan="4"><div class="loadmore" onclick="loadLogs('all&');">Charger tous les logs</div></td></tr> <?
}

?>
