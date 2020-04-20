<?php

$link = mysqli_connect("127.0.0.1:3306", "root", "dLPqYp7C7vTp", "rallyehiver2012");


?>
<html>
<head>
	<title>Logs</title>
</head>
<body>
	<div style="position:absolute;top:4px;left:30px;background-color:white;z-index:100;">Restriction</div>
	<div style="position:absolute;top:15px;left:10px;padding:10px;border:solid 1px black;background-color:#f7f7f7;">
		<table>
			<tr><form action="log753.php" method="post" style="margin:0;">
				<td><input type=text id=equipe name=equipe /></td>
				<td><input type=submit /></td>
			</form></tr>
			
			<tr><form action="log753.php" method="post" style="margin:0;">
				<td colspan=2 ALIGN=right><input value="Tous les résultats" name="all" type=submit /></td>
			</form></tr>
		</table>
	</div>
	<div style="width:600px;margin:0px auto 0px auto;">

<?
if(isset($_POST['equipe']) && !isset($_POST['all'])){

	$wat = explode(" ", $_POST['equipe']);
	if(count($wat) != 1){
		
		if(is_numeric($wat[0])){
			$wat = explode(" ", $_POST['equipe'], 2);
			$res = mysqli_query($link, "SELECT * FROM `log` WHERE `log`.`enigme` = '".$wat[0]."' AND `log`.`equipe` LIKE '%".$wat[1]."%' ORDER BY  `log`.`id` DESC");			
		}
		if(is_numeric($wat[count($wat)-1])){
			$wat2 = $wat[0];
			for($i = 1; $i < count($wat)-1; $i++){
				$wat2 .= ' ' . $wat[$i];
			}
			$res = mysqli_query($link, "SELECT * FROM `log` WHERE `log`.`enigme` = '".$wat[count($wat)-1]."' AND `log`.`equipe` LIKE '%".$wat2."%' ORDER BY  `log`.`id` DESC");			
		}
		
	}else{
	
		$res = mysqli_query($link, "SELECT * FROM `log` WHERE `log`.`enigme` = '".$_POST['equipe']."' AND `log`.`enigme` != 0 ORDER BY  `log`.`id` DESC");
		if(mysqli_num_rows($res)==0)$res = mysqli_query($link, "SELECT * FROM `log` WHERE `log`.`equipe` LIKE '%".$_POST['equipe']."%' ORDER BY  `log`.`id` DESC");
		if(mysqli_num_rows($res)==0)$res = mysqli_query($link, "SELECT * FROM `log` WHERE `log`.`mdp` LIKE '%".$_POST['equipe']."%' ORDER BY  `log`.`id` DESC");
		
	}
}
else{
	$res = mysqli_query($link, "SELECT * FROM `log` ORDER BY  `log`.`id` DESC");
}

if($res && mysqli_num_rows($res) !=0){
	$nb = mysqli_num_rows($res);
	$dateTemp = 0;
	for($i = 0; $i < $nb; $i++){
		$element = mysqli_fetch_array($res);
		$log_i = explode("-", $element['date']);
		$log_j = explode(" ", $log_i[2]);
		$log_k = explode(":", $log_j[1]);
		if($log_k[0] == '00' && $log_k[1] == '00' && $log_k[2] == '00'){
			$log_date[$i] = $log_j[0].'/'.$log_i[1];
		}else{
			$log_date[$i] = $log_j[0].'/'.$log_i[1].' &agrave; '.$log_k[0].':'.$log_k[1];
		}
		if($dateTemp != $log_j[0]){ $log_newDate[$i] = 'Log du '.$log_j[0].'/'.$log_i[1].' : '; }
		$dateTemp = $log_j[0];
		
		$log_equipe[$i] = stripslashes($element['equipe']);
		$log_mdp[$i] = stripslashes($element['mdp']);
		$log_enigme[$i] = $element['enigme'];
		$log_ok[$i] = $element['ok'];
	}

	echo '<table>';
	for ($i = 0; $i < count($log_mdp); $i++){
		if(isset($log_newDate[$i]))echo '<tr><td><b>' . $log_newDate[$i] . '</b></td><td></td><td></td><td></td></tr>';
		if($log_ok[$i] == 1){
			echo '<tr style="color:grey"><td>[' . $log_date[$i] . ']</td>';
		}else{
			echo '<tr><td>[' . $log_date[$i] . ']</td>';
		}
		echo '<td style="padding-right:20px;">' . $log_equipe[$i] . '</td>';
		echo '<td style="width:130px;">' . $log_mdp[$i] . '</td>';
		echo '<td>(&eacute;nigme ' . $log_enigme[$i] . ')</td></tr>';
	}
	echo '</table>';
}else{
	echo 'Aucun résultat ...';
}

echo '</div></body></html>';

?>
