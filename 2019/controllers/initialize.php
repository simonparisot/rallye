<?php 
$dbyear="rallyehiver2019";
require_once realpath(dirname(__FILE__).'/../info.php');
require_once realpath(dirname(__FILE__).'/../../db.php');
require_once realpath(dirname(__FILE__).'/../../login.php');

// function that updates the session with common infos (name, login, ...) and year specific features (unlocked content, ...)
function majSession($user) {

	global $bdd;
	$sth = $bdd->prepare('SELECT * FROM rallye_people WHERE login = :login LIMIT 1');
	if ($sth->execute(array(':login' => $user['login']))) {
		$editionData = $sth->fetchAll();
		
		if( count($editionData) == 0 ){
			// if user does not exist, we create it (that's for migration to unified login)
			$sth = $bdd->prepare("INSERT INTO rallye_people (nom, login, pwd, enigmes, quest, token, `e20-groupe`, `e20-enigme`) VALUES (:nom, :login, '', '', :quest, '', '1', '1')");
			$quest = '["gkehb0p5av","8mdiu77eah","c12m85wqby","rakl26jbe9","q6ktqn8nf4","62ygx5pcd3","7xp2fvpuc7","9nejv8fggv","ymdgth734c"]';
			$sth->execute(array(':nom' => $user['nom'], ':login' => $user['login'], ':quest' => $quest));
			$editionData[0]['quest'] = $quest;
			$editionData[0]['e20-groupe'] = 1;
			$editionData[0]['e20-enigme'] = 1;
		}

		$_SESSION['login'] = $user['login'];
		$_SESSION['nom'] = $user['nom'];
		$_SESSION['admin'] = ($user['login'] == 'orga');
		$_SESSION['someQuest'] = count(json_decode($editionData[0]['quest'], true)) != 0;
		$_SESSION['e20-groupe'] = $editionData[0]['e20-groupe'];
		$_SESSION['e20-enigme'] = $editionData[0]['e20-enigme'];
	}
}

?>