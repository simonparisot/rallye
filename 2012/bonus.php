<?php

if(isset($_COOKIE["_id_equipe"])){

	if(isset($_GET['x'])){
			
		require_once 'db.php';
		
		$res = mysqli_query($link, "SELECT bonus
							FROM `comptes_utilisateurs`
							WHERE id = ".mysqli_real_escape_string($link, $_COOKIE['_id_equipe']));
							
		$element = mysqli_fetch_array($res);
		if($element['bonus'] < 0){
			if($_GET['x'] == 0)$file = 'opus_diner_1_46ef5.pdf';
			if($_GET['x'] == 1)$file = 'opus_diner_2_ek53r.pdf';
			if($_GET['x'] == 2)$file = 'opus_diner_3_g75h6.pdf';
			if($_GET['x'] == 3)$file = 'opus_diner_4_cr6i5.pdf';
			if($_GET['x'] == 4)$file = 'opus_diner_5_k8fh7.pdf';
			echo 'true~'.$file;
			mysqli_query($link, "	UPDATE `comptes_utilisateurs` 
							SET `bonus` = '".$_GET['x']."' 
							WHERE `comptes_utilisateurs`.`id` =".mysqli_real_escape_string($link, $_COOKIE['_id_equipe'])." 
							LIMIT 1" );
		}else{
			echo 'false~'.$element['bonus'];
		}
	}
	
}else{

	//si l'utilisateur n'est pas connecté, on n'analyse rien, on renvoie un code qui entrainera une redirection directe vers la page de connexion
	echo 'loginfail';
	
}

?>
