<?php

$link = mysql_connect("localhost", "rallyedh_simon", "6778");
$db = mysql_select_db('rallyedh_rallye', $link);
echo '<table cellspacing=0 cellpadding=5 border=1 style="margin:0px auto 0px auto;">';
for ($i = 1; $i < 23; $i++){
	$r = mysql_query("	SELECT COUNT(*)
						FROM log
						WHERE enigme = '".$i."'
	");
	$result = mysql_fetch_array($r);
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