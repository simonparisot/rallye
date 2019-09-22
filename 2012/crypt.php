<?php
if(isset($_GET['t'])){
	echo strtolower(substr(crypt($_GET['t'], "bob"), 8));
}
if(isset($_GET['c'])){
	echo 'MD5 de '.$_GET['c'].' :<br>';
	echo crypt($_GET['c'], "bob");
}
if(isset($_GET['s'])){
	$t = array();
	echo serialize($t);
}
if(isset($_GET['us'])){
	print_r(unserialize($_GET['us']));
}
?>
