<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Rallye | Indices</title>
</head>
<body>

<?

if(isset($_GET['bob'])){

	$link = mysqli_connect("127.0.0.1:3306", "root", "dLPqYp7C7vTp", "rallyehiver2012");
	

?>
		
		<div style="width:400px;text-align:center;margin:50px auto 0px auto;font-size:24px;font-weight:bold;color:#006d96;padding:20px;border:1px solid black;">
			<form METHOD=POST ACTION="indices.php?bob">
				Changer le nombre d'indice<br/><br/>
				<table style="text-align:right;font-size:16px;color:black;margin-left:50px;">
					<tr><td>Equipe : 				</td> <td>	<input type="text" name="equipe" />	</td></tr>
					<tr><td>Nombre d'indice : 		</td> <td>	<input type="text" name="nb" />	</td></tr>
					<tr><td colspan=2><input type="submit" />	</td> </tr>
				</table>
			</form>
			<br/>
			<div style="font-size:16px;">
			
			
<? 
			
	if( isset($_POST['equipe']) && isset($_POST['nb']) && $_POST['equipe'] != ''){
		$store = mysqli_query($link, "UPDATE  `Comptes_Utilisateurs` SET  `indices` =  '".$_POST['nb']."' WHERE `nom` LIKE '%".$_POST['equipe']."%'");
		if($store){
			$res = mysqli_query($link, "SELECT `nom` FROM `Comptes_Utilisateurs` WHERE `nom` LIKE '%".$_POST['equipe']."%' AND `indices` = '".$_POST['nb']."'");
			$nb = mysqli_num_rows($res);
			for($i = 0; $i < $nb; $i++){
				$select = mysqli_fetch_array($res);
				echo 'L\'&eacute;quipe '.$select['nom'].' a demand&eacute; '.$_POST['nb'].' indices.<br/>';
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

	$res = mysqli_query($link, "SELECT `nom`,`indices` FROM `Comptes_Utilisateurs` WHERE `indices` != '0' ORDER BY  `nom` ASC");
	if(!$res)createLog(mysqli_error($link));
	$nb = mysqli_num_rows($res);
	$count = 0;
	for($i = 0; $i < $nb; $i++){
		$select = mysqli_fetch_array($res);
		$count += $select['indices'];
		echo '<li>' . $select['nom'] . ' : ' . $select['indices'] . ' indices.</li>';
	}
	echo '</ul><br/><br/><b>Total : ' . $count . '</b>'
?>
		</ul>
	</div>
	
<? } ?>
</body>
</html>