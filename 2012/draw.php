<?php

require_once 'db.php';

$res = mysqli_query($link, "SELECT *  
					FROM `log` 
					WHERE (`log`.`equipe` LIKE '%".$_GET['e']."%' AND `log`.`ok` = 1) 
					GROUP BY `log`.`mdp`, `log`.`enigme` 
					ORDER BY  `log`.`date` ASC");
$res2 = mysqli_query($link, "SELECT *  
					FROM `log` 
					WHERE (`log`.`equipe` LIKE '%".$_GET['e']."%' AND `log`.`date` >= '2011-12-20 00:00:00') 
					GROUP BY `log`.`mdp`, `log`.`enigme`, `log`.`ok` 
					ORDER BY  `log`.`date` ASC");
$res3 = mysqli_query($link, "SELECT questionnaire, bonus 
					FROM `comptes_utilisateurs` 
					WHERE `nom` LIKE '%".$_GET['e']."%'");
	
if($res && mysqli_num_rows($res) !=0){

	$element = mysqli_fetch_array($res3);
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

	$nb = mysqli_num_rows($res);
	$nb2 = mysqli_num_rows($res2);
	
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
			$element = mysqli_fetch_array($res2);
			
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