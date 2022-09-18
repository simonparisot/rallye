<?php

// AJAX controller
// ---------------

// on vérifie si l'utilisateur a une session en cours
require_once 'initialize.php';
if (!$auth) { echo json_encode(array('loginerror')); exit; }


// envoyer toute la discussion liée à une énigme
if(isset($_GET['enigme'])){ 

	$equipe = $_SESSION['login'];
	$reponse = array();

	if ($_GET['enigme'] == 20) {
		// pour l'énigme 20 'THEORIE DE JEUX', la discussion est différente des autres énigmes. La discussion est commune à un groupe d'équipe.
		//$sth = $bdd->prepare('SELECT * FROM rallye_posts WHERE enigme = 20 ORDER BY date DESC');
		$sth = $bdd->prepare('SELECT rallye_posts.* FROM rallye_posts INNER JOIN rallye_people ON rallye_posts.equipe=rallye_people.login AND rallye_people.`e20-groupe`= :group	WHERE rallye_posts.enigme=20 ORDER BY rallye_posts.date DESC');
		$sth->execute(array(':group' => $_SESSION['e20-groupe']));
	
	}else{
		// si ce n'est pas l'énigme 20, on renvoit tous les posts liés à cette énigme et cette équipe
		$sth = $bdd->prepare('SELECT * FROM rallye_posts WHERE equipe = :equipe AND enigme = :enigme ORDER BY date DESC');
		$sth->execute(array(':equipe' => $equipe, ':enigme' => $_GET['enigme']));
	}
		
	while ($post = $sth->fetch()) {
		$text_ok = nl2br(htmlspecialchars($post['text']));
		$text_ok = preg_replace('@(http)?(s)?(://)?(([-\w]+\.)+([^\s]+)+[^,.\s])@', '<a href="http$2://$4" target="_blank" rel="nofollow">$1$2$3$4</a>', $text_ok);
		$nom_ok = htmlspecialchars($post['nom']);
		$reponse[] = array('nom' => $nom_ok, 'texte' => $text_ok, 'date' => $post['date'], 'nicedate' => nicedate($post['date']));
	}

	echo count($reponse) != 0 ? json_encode($reponse) : json_encode(array('nothing'));


// stocker un nouveau post dans la discussion
}elseif (isset($_POST['newpost']) && isset($_POST['enigme']) && isset($_POST['nom']) && $_POST['newpost'] != '' && $_POST['enigme'] != '' && $_POST['nom'] != '') {
	
	$equipe = $_SESSION['login'];
	if ($equipe == "sacregrallye") $_POST['newpost'] = "Je vous dis que ça ne fonctionne pas !";
	$sth = $bdd->prepare('INSERT INTO rallye_posts (`equipe`, `enigme`, `nom`, `text`) VALUES (:equipe, :enigme, :nom, :newpost)');
	$sth->execute(array(':equipe' => $equipe, ':enigme' => $_POST['enigme'], ':nom' => $_POST['nom'], ':newpost' => $_POST['newpost']));

// supprimer un post
}elseif (isset($_GET['delete']) && isset($_POST['date']) && isset($_POST['nom']) && isset($_POST['enigme']) && $_POST['date'] != '' && $_POST['nom'] != '' && $_POST['enigme'] != '' && $_POST['enigme'] != 20) {
	
	$equipe = $_SESSION['login'];
	if ($equipe != "sacregrallye") {
		$sth = $bdd->prepare('DELETE FROM rallye_posts WHERE date = :date AND nom = :nom AND equipe = :equipe');
		$sth->execute(array(':equipe' => $equipe, ':date' => $_POST['date'], ':nom' => $_POST['nom'] ));
	}


}else{
	echo json_encode(array('error'));
}

// ------------------------------------------
// transforme une date en un format sympa (qq sec, 3min, 2h, hier, 5 sept, ...)
function nicedate ($date)
{
	$delay = time() - strtotime($date);
		if( $delay < 60 ) 		{ return 'qq sec'; }
	elseif( $delay < 3600 ) 	{ return floor($delay/60).'min'; }
	elseif( $delay < 3600*24 )	{ return floor($delay/3600).'h'; }
	elseif( $delay < 3600*48 ) 	{ return 'hier'; }
	else 						{ return date('d/m', strtotime($date)); }

}

?>