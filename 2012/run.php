<?php
$link = mysql_connect("localhost", "rallyedh_simon", "6778");
$db = mysql_select_db('rallyedh_rallye', $link);
$res = mysql_query("SELECT login, password FROM `Comptes_Utilisateurs` ORDER BY `password` ASC");
?>
<html>
<body>
<table border=1 cellspacing=0 cellpadding=4>
<?
for($i=0;$i<37;$i++){
	$element = mysql_fetch_array($res);
	echo '<tr><td>';
	echo $element['login'];
	echo'</td><td>';
	$b = $element['password'];
	echo $b;
	echo'</td><td>';
	$a = crypt($element['password'], "bob");
	echo $a;
	echo '</td><td>';
	mysql_query("	UPDATE `Comptes_Utilisateurs` 
					SET `password` = '".$a."' 
					WHERE `Comptes_Utilisateurs`.`login` ='".$element['login']."' 
					LIMIT 1" );
	echo '</td></tr>';
}
?>
</table>
</body>
</html>
