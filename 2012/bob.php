<?
echo 'fonction BOB.PHP :<br/><br/>';
$file = "23.03.2012 19h47~simon~di\'ver\'di.mov";
$new =  "23.03.2012 19h47~simon~video di`ver`di.mov";
$bob  = rename($file, $new);
if($bob){
	echo "OK ! '".$file."' a été renommé en '".$new."'";
}else{
	echo "echec de l'opération (impossible de renommer '".$file."' en '".$new."'";
}
?>