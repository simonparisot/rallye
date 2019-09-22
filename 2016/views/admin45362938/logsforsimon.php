<?

require '../../controllers/db.php';
require '../../ressources/info.php';

$SQL = 'SELECT * FROM rallye_try WHERE equipe != "terpsichore" AND equipe !="euterpe" ORDER BY date DESC';

$search = $bdd->prepare($SQL);

echo '<table>';

if ($search->execute()) {
	while ($log = $search->fetch()) {

        $oldcar = array(" ", "-", "'", "é", "è", "à", "ê", "â", "ô", "ç", "û", "ù", "ï", "î", "’");
        $newcar = array("", "", "", "e", "e", "a", "e", "a", "o", "c", "u", "u", "i", "i", "");
        $mdp = strtolower(str_replace($oldcar, $newcar, $log['mdp']));

        $oldpwd = array("jalmahalpalace", "jalmahal", "lakepalacehotel", "mmeleblancmatraque", "dianeleblancmatraque", "blancheleblancmatraque", "3");
        $newpwd = array("lakepalace", "lakepalace", "lakepalace", "leblancmatraque", "leblancmatraque", "leblancmatraque", "trois");
        $mdp = str_replace($oldpwd, $newpwd, $mdp);

		echo "<tr>";
		echo '<td>'.$log['date'].'</td><td>'.$log['equipe'].'</td><td>'.$log['enigme'].'</td><td>'.htmlspecialchars($log['mdp']).'</td>';
		echo $enigmeList[$log['enigme']-1][2] == $mdp ? '<td>VRAI</td>' : '<td>FAUX</td>';
		echo '</tr>';
	}
}

echo "</table>";

?>
