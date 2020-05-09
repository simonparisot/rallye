<?

if ( isset($_POST['msg']) && $_POST['msg'] != '' ) {

	echo 'inside';
	require_once 'db.php';
	require_once 'login.php';
	if (!$auth) { echo json_encode(array('loginerror')); exit; }

	
	$sth = $bdd->prepare('INSERT INTO rallye_msg (equipe, msg) VALUES (:equipe, :msg)');
	if ( $sth->execute(array(':equipe' => $_SESSION['nom'], 'msg' => $_POST['msg'])) ) echo 'ok sql';
}

?>