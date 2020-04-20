<?php
$link = mysqli_connect("127.0.0.1:3306", "root", "dLPqYp7C7vTp", "rallyehiver2012");

$res = mysqli_query($link, "SELECT login, password FROM `Comptes_Utilisateurs` ORDER BY `password` ASC");
?>
<html>
<body>
<table border=1 cellspacing=0 cellpadding=4>
<?
for($i=0;$i<37;$i++){
	$element = mysqli_fetch_array($res);
	echo '<tr><td>';
	echo $element['login'];
	echo'</td><td>';
	$b = $element['password'];
	echo $b;
	echo'</td><td>';
	$a = crypt($element['password'], "bob");
	echo $a;
	echo '</td><td>';
	mysqli_query($link, "	UPDATE `Comptes_Utilisateurs` 
					SET `password` = '".$a."' 
					WHERE `Comptes_Utilisateurs`.`login` ='".$element['login']."' 
					LIMIT 1" );
	echo '</td></tr>';
}
?>
</table>
</body>
</html>
