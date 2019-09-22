<?	
if ($_FILES['dossier']['error']) {    
	switch ($_FILES['dossier']['error']){    
		case 1: // UPLOAD_ERR_INI_SIZE    
		$message = "La taille de votre fichier dépasse la limite autorisée (2 Go).";    
		break;    
		case 2: // UPLOAD_ERR_FORM_SIZE    
		$message = "La taille de votre fichier dépasse la limite autorisée (2 Go).";
		break;    
		case 3: // UPLOAD_ERR_PARTIAL    
		$message = "L'envoi du fichier a été interrompu pendant le transfert.";    
		break;    
		case 4: // UPLOAD_ERR_NO_FILE    
		$message = "Erreur : vous n'avez pas choisi de fichier (ou celui-ci a une taille nulle).";
		break;    
	}    
}elseif(isset($_FILES['dossier']['name']) && $_FILES['dossier']['name'] != ""){
	$filename = strtolower(date("d.m.Y H\hi").'~'.$_COOKIE["_nom_equipe"].'~'.$_FILES['dossier']['name']);
	$path = realpath('upload.php');
	$chemin_destination = explode('.php', $path);
	move_uploaded_file($_FILES['dossier']['tmp_name'], $chemin_destination[0].'/'.$filename);
	$message = 'Votre dossier de réponse <i>'.$_FILES['dossier']['name'].'</i> a été transféré correctement !<br/>Vous serez prévenu par mail de sa bonne réception par l\'équipe Terpsichore.';
}else{
	$message = 'Erreur lors du transfert de votre fichier. N\'hésitez pas à contacter le webmaster par mail <a href=mailto:"simon@rallyedhiver2012.fr"><font color="#76a7f2"><b>en cliquant ici</b></font></a>.';
} 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" media="screen" type="text/css" title="style" href="stylesheet.css" />
</head>

<body>

<div id="page_bof">
	
	<a href="index.php"><div id="logo" style="margin-bottom:32px;"></div></a>
	
	<div style="position:relative;z-index:10;margin-left:78px;"><a href="index.php?page=perso"><img class="bouton" src="pictures/retour.png" /></a></div>
	
	<div id="content_bof">
		<div id="bof_header"></div>
		<div id="bof">
			<div id="online_view" style="padding:40px 20px;color:white;font-size:18px;">
					
			<? echo $message; ?>
	
	
			</div>
					
		</div>
		<div id="bof_footer"></div>
	</div>
	
</div>


</body>
</html>
