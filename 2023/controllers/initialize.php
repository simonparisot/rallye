<?php 
$dbyear="rallyehiver2023";
require_once realpath(dirname(__FILE__).'/../info.php');
require_once realpath(dirname(__FILE__).'/../../db.php');
require_once realpath(dirname(__FILE__).'/../../login2.php');

// function that updates the session with common infos (name, login, ...) and year specific features (unlocked content, ...)
function majSession($email) {

	global $bdd;
	$sth = $bdd->prepare('SELECT * FROM rallye_users WHERE email = :email LIMIT 1');
	if ($sth->execute(array(':email' => $email ))) {
		$team = $sth->fetchAll();
			
			// if the email is not found is this year DB, it means that the person behind is not the leader of a team this year
			if( count($team) == 0 ){
				echo "Cette équipe n'est pas trouvée dans les inscrits de cette année. Si vous pensez qu'il s'agit d'une erreur, merci de contacter les organisateurs.";
			}else{
				$team = $team[0];
				$_SESSION['email'] = $email;
				$_SESSION['login'] = $team['login'];
				$_SESSION['nom'] = $team['name'];
				$_SESSION['admin'] = ($team['type'] == 'admin');
				$_SESSION['unlocked'] = json_decode($team['unlocked'], true);
			}
	}
}

?>