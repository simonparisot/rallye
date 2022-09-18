<?php 
$dbyear="rallyehiver2016";
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
			$sth = $bdd->prepare("INSERT INTO rallye_people (nom, login, pwd, enigmes, quest, token, contact, indices) VALUES (:nom, :login, '', '', :quest, '', '', 0)");
			$quest = '["q6ktqn8n64","9nejv8ffgv","rakl26jbu9","7xp2fvpux7","c12m85wqay","62ygx5pcx3","gkehb0p5iv","q0gwu3mnhp","kq4set7edj"]';
			$sth->execute(array(':nom' => $user['nom'], ':login' => $user['login'], ':quest' => $quest));
			$editionData[0]['quest'] = $quest;
			$editionData[0]['jetlag'] = '';
		}

		$_SESSION['login'] = $user['login'];
		$_SESSION['nom'] = $user['nom'];
		$_SESSION['admin'] = ($user['login'] == 'terpsichore');
		$_SESSION['someQuest'] = count(json_decode($editionData[0]['quest'], true)) != 0;
		$_SESSION['jetlag'] = $editionData[0]['jetlag'];
	}
}

?>