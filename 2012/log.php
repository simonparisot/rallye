<?php

$link = mysqli_connect("127.0.0.1:3306", "root", "dLPqYp7C7vTp", "rallyehiver2012");

echo '<table cellspacing=0 cellpadding=5 border=1 style="margin:0px auto 0px auto;">';
for ($i = 1; $i < 23; $i++){
	$r = mysqli_query($link, "	SELECT COUNT(*)
						FROM log
						WHERE enigme = '".$i."'
	");
	$result = mysqli_fetch_array($r);
	if($i == 21){
		$opus = 'Tino Rossi';
	}elseif($i == 22){
		$opus = 'Opus diner';
	}else{
		$opus = 'Opus '.$i;
	}
	echo '<tr><td>'.$opus.'</td><td>'.$result[0].' logs</td></tr>';
		
}
echo '</table>';
?>