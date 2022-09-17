<?php 
try
{
	$bdd = new PDO('mysql:host=127.0.0.1:3306;dbname=rallyehiver2023;charset=utf8', 'root', '??????????????');
}
catch (Exception $e)
{
	die('<b>DB connection error</b> : ' . $e->getMessage());
}
?>
