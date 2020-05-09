<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Rallye | Indices</title>
</head>
<body>

<?

if(isset($_GET['bob'])){

	require_once 'db.php';	

?>
		
		<div style="width:400px;text-align:center;margin:50px auto 0px auto;font-size:24px;font-weight:bold;color:#006d96;padding:20px;border:1px solid black;">
			<form METHOD=POST ACTION="files.php?bob">
				Nouveau fichier reçu<br/><br/>
				<table style="text-align:right;font-size:16px;color:black;margin-left:50px;">
					<tr><td>Equipe : 				</td> <td align=left>	<input type="text" name="equipe" />	</td></tr>
					<tr><td>Dossier de réponse 		</td> <td align=left>	<input type="checkbox" name="dossier" />	</td></tr>
					<tr><td>Nombre de vidéos : 		</td> <td align=left>	<input type="text" name="nb" maxlength="2"/>	</td></tr>
					<tr><td colspan=2><input type="submit" />	</td> </tr>
				</table>
			</form>
			<br/>
			<div style="font-size:16px;">
			
			
<? 
			
	if( isset($_POST['equipe']) && isset($_POST['nb']) && $_POST['equipe'] != ''){
		$upload = 0;
		if(isset($_POST['dossier']))$upload += 100;
		$upload += $_POST['nb'];
		if($upload == 0) $upload = -1;
		$store = mysqli_query($link, "UPDATE `comptes_utilisateurs` SET `upload` =  '".$upload."' WHERE `nom` LIKE '%".$_POST['equipe']."%'");
		if($store){
			$res = mysqli_query($link, "SELECT `nom` FROM `comptes_utilisateurs` WHERE `nom` LIKE '%".$_POST['equipe']."%' AND `upload` = '".$upload."'");
			$nb = mysqli_num_rows($res);
			for($i = 0; $i < $nb; $i++){
				$select = mysqli_fetch_array($res);
				if(isset($_POST['dossier'])){
					if($_POST['nb'] == 0) echo 'L\'équipe '.$select['nom'].' a envoyé son dossier de réponse. L\'équipe est notifiée !<br/>';
					else 				  echo 'L\'équipe '.$select['nom'].' a envoyé son dossier de réponse et '.$_POST['nb'].' vidéo(s). L\'équipe est notifiée !<br/>';
				}else{
					if($upload == -1) 	echo 'Réinitialisation pour l\'équipe '.$select['nom'].'. L\'équipe n\'est plus notifiée !<br/>';
					else				echo 'L\'équipe '.$select['nom'].' a envoyé '.$_POST['nb'].' vidéo(s). L\'équipe est notifiée !<br/>';
				}
				
			}
		}else{
			echo 'L\'op&eacute;ration a &eacute;chou&eacute;e ...<br/>';
		}
	}	
?>


		</div>
	</div>
	
	<div style="position:absolute;top:10px;left:10px;">
		<ul>
<?

	$res = mysqli_query($link, "SELECT `nom`,`upload` FROM `comptes_utilisateurs` WHERE `upload` != '-1' ORDER BY  `nom` ASC");
	if(!$res)createLog(mysqli_error($link));
	$nb = mysqli_num_rows($res);
	for($i = 0; $i < $nb; $i++){
		$select = mysqli_fetch_array($res);
		if($select['upload'] >= 100){
			if(($select['upload'])%100 == 0)  echo '<li>' . $select['nom'] . ' : dossier réponse</li>';
			else 				  echo '<li>' . $select['nom'] . ' : dossier réponse et '.(($select['upload'])%100).' vidéo(s)</li>';
		}else{
			echo '<li>' . $select['nom'] . ' : '.(($select['upload'])%100).' vidéo(s)</li>';
		}
	}
?>
		</ul>
	</div>
	
<? } ?>
</body>
</html>