<?php
$ok = 0;
if(preg_match("@fasila$@", $_GET['piano'])){
	$ok = 'accordeon';
}
echo $ok;
?>
