<?php

$link = mysql_connect("localhost", "rallyedh_simon", "6778");
$db = mysql_select_db('rallyedh_rallye', $link);

$res = mysql_query("SELECT *  
					FROM `log` 
					WHERE (`log`.`equipe` LIKE '%".$_GET['e']."%' AND `log`.`ok` = 1) 
					GROUP BY `log`.`mdp`, `log`.`enigme` 
					ORDER BY  `log`.`date` ASC");
$res2 = mysql_query("SELECT *  
					FROM `log` 
					WHERE (`log`.`equipe` LIKE '%".$_GET['e']."%' AND `log`.`date` >= '2011-12-20 00:00:00') 
					GROUP BY `log`.`mdp`, `log`.`enigme`, `log`.`ok` 
					ORDER BY  `log`.`date` ASC");
$res3 = mysql_query("SELECT questionnaire, bonus 
					FROM `Comptes_Utilisateurs` 
					WHERE `nom` LIKE '%".$_GET['e']."%'");
	
if($res && mysql_num_rows($res) !=0){

	$element = mysql_fetch_array($res3);
	$questio = unserialize($element['questionnaire']);
	$total = 0;	
	for ($y = 0; $y < 21; $y++){
		if($questio[$y]){
			$total++;
		}
	}
	if($element['bonus'] > 4){
		$total++;
	}

	$nb = mysql_num_rows($res);
	$nb2 = mysql_num_rows($res2);
	
	$max = 2*floor(($total+2)/2);
	
	if(2*round(($total-$nb-2)/2)>=0){
		$min = 2*round(($total-$nb-2)/2);
	}else{
		$min = 0;
	}
	
	if($nb>10){ $inter = 2; }else{ $inter = 1; }
	echo 'var yinter = ' . $inter . ';';
	echo 'var ymin = ' . $min . ';';
	echo 'var ymax = ' . $max . ';';
	
	echo 'var d = [';
	
	$taille = $total-$nb;
	echo '[(new Date("2011/12/20 00:00:00")).getTime(), ' . $taille . ']';
	for($i = 0; $i < $nb2; $i++){
			$element = mysql_fetch_array($res2);
			
			$log_i = explode("-", $element['date']);
			$log_j = explode(" ", $log_i[2]);
			$log_k = explode(":", $log_j[1]);
			$log_date = $log_i[0].'/'.$log_i[1].'/'.$log_j[0].' '.$log_k[0].':'.$log_k[1].':'.$log_k[2];			
			
			if($element['ok'] == 1){ $taille++; }
			
			echo ',[(new Date("' . $log_date . '")).getTime(),' . $taille . ']';
			
	}
	echo ',[(new Date("' . date('Y/m/d H:i:s') . '")).getTime(), ' . $total . ']';
		
	echo '];';
}
?>