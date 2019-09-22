<?php 
try
{
	$bdd = new PDO('mysql:host=172.31.39.172:3306;dbname=rallyehiver2019;charset=utf8', 'root', 'ydpFqquiXOd0');
}
catch (Exception $e)
{
	die('<b>DB connection error</b> : ' . $e->getMessage());
}
?>