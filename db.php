<?php 
try
{
	$bdd = new PDO("mysql:host=127.0.0.1:3306;dbname=$dbyear;charset=utf8", "root", "DRhUEMRkh7eRSjHt");
}
catch (Exception $e)
{
	die('<b>DB connection error</b> : ' . $e->getMessage());
}
?>
