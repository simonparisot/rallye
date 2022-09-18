<?php 
$dbyear="rallyehiver2020";
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
			// if user does not exist for this edition, we create it (that is only for migration to unified login)
			$sth = $bdd->prepare("INSERT INTO rallye_people (nom, login, pwd, unlocked, token) VALUES (:nom, :login, '', :unlocked, '')");
			$unlocked = '{"E01sNRdEvwG":false,"E02LzsJLTKf":false,"E03cZKvpne4":false,"E04re7Hgq9d":false,"E05q4BSryWM":false,"E06nGzJzuHZ":false,"E07FfqM7BBd":false,"E08wwTmEyCw":false,"E09jt79wRSM":false,"E10KYLyUhGY":false,"P00wiG7d67n":false,"PBONUSBONUS":false,"P01SBCdwwqc":false,"P02PdMmYs2z":false,"P03m8YQAq6p":false,"P04LzuBEawE":false,"P05EubtHzh4":false,"P06T2VxsxKk":false,"P07Q6AfQt7A":false,"E21fh74gZx9":false,"P08NFeWKhZb":false,"E11YcdRWwzc":false,"E12mSedBRcj":false,"E13D8jf7Uts":false,"E14FqqZ8N6F":false,"E15fcGWBAwF":false,"E16Jcz74Jqh":false,"E17ucgHNV8F":false,"E18NNjPUs3K":false,"P09RKJPrLcH":false,"E19EKsmu647":false,"E20RZcq4LqZ":false,"P10xtdwXzHF":false,"P11s2wzbJRN":false}';
			$sth->execute(array(':nom' => $user['nom'], ':login' => $user['login'], ':unlocked' => $unlocked));
			$editionData[0]['unlocked'] = $unlocked;
		}

		$_SESSION['login'] = $user['login'];
		$_SESSION['nom'] = $user['nom'];
		$_SESSION['admin'] = ($user['login'] == 'orga');
		$_SESSION['unlocked'] = json_decode($editionData[0]['unlocked'], true);
	}
}

?>