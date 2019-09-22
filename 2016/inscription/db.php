<?php 
try
{
	$bdd = new PDO('mysql:host=mysql51-32.perso;dbname=swiitbdd;charset=utf8', 'swiitbdd', 'Mag1cJ3w3ls');
}
catch (Exception $e)
{
	die('<b>DB connection error</b> : ' . $e->getMessage());
}
?>