<?php

// AJAX controller
// ---------------

// on vérifie si l'utilisateur a une session en cours
require_once '../ressources/info.php';
require_once 'db.php';
require_once 'login.php';
if (!$auth) { echo json_encode(array('loginerror')); exit; }


// vérifier un mot de passe d'énigme
if(isset($_GET['enigme']) && isset($_GET['mdp'])) {
    if(($_GET['enigme'] !== '') && ($_GET['mdp'] !== '')) {
            
        $storeTry = $bdd->prepare('INSERT INTO rallye_try (equipe, enigme, mdp) VALUES (:equipe, :enigme, :mdp)');
        $storeTry->execute(array(':equipe' => $_SESSION['login'], ':enigme' => $_GET['enigme'], ':mdp' => $_GET['mdp']));

        $oldcar = array(" ", "-", "'", "é", "è", "à", "ê", "â", "ô", "ç", "û", "ù", "ï", "î", "’");
        $newcar = array("", "", "", "e", "e", "a", "e", "a", "o", "c", "u", "u", "i", "i", "");
        $input = strtolower(str_replace($oldcar, $newcar, $_GET['mdp']));
        $oldpwd = array("jalmahalpalace", "jalmahal", "lakepalacehotel", "mmeleblancmatraque", "dianeleblancmatraque", "blancheleblancmatraque", "3");
        $newpwd = array("lakepalace", "lakepalace", "lakepalace", "leblancmatraque", "leblancmatraque", "leblancmatraque", "trois");
        $input = str_replace($oldpwd, $newpwd, $input);

        $enigme = $_GET['enigme'];

    	if ( $enigmeList[$enigme-1][2] == $input ) {

            $code = array_search($enigmeList[$enigme-1][1], $questList);
            $texte = 'Bonne réponse ! Par contre une erreur nous empêche de débloquer le questionnaire :( Contactez-nous !';
            $newEni = false;
            $newQuest = false;

            // on stocke en bdd le nouveau questionnaire débloqué
            $take = $bdd->prepare('SELECT quest, enigmes FROM rallye_people WHERE login = :login LIMIT 1'); 
            $storeQ = $bdd->prepare('UPDATE rallye_people SET quest = :quest WHERE login = :login');
            $storeE = $bdd->prepare('UPDATE rallye_people SET enigmes = :enigmes WHERE login = :login');
            if ($take->execute(array(':login' => $_SESSION['login']))) {
                $result = $take->fetchAll();
                $enigmes = json_decode($result[0]['enigmes'], true);
                $quest = json_decode($result[0]['quest'], true);

                // texte spécifique pour les énigmes de rapidité
                $specialComment = '';
                if ($enigme == 7 || $enigme == 8) {
                    $compte = 0;
                    $search = $bdd->prepare('SELECT * FROM rallye_people WHERE login != "terpsichore" AND login !="euterpe" ORDER BY id');
                    if ($search->execute()) {
                        while ($team = $search->fetch()) {
                            // on compte le nombre d'équipes qui a déjà résolu l'énigme
                            $e = json_decode($team['enigmes'], true);
                            foreach ($e as $num => $date) {
                                if ( $num == $enigme ) $compte++;
                            }

                        }
                    }
                    if ($compte == 0) $specialComment = "Vous êtes la première équipe à avoir résolu cette énigme de rapidité, félicitation :)<br>";
                    elseif ($compte == 1) $specialComment = "Vous êtes la seconde équipe à avoir résolu cette énigme de rapidité, félicitation :)<br>";
                    elseif ($compte == 2) $specialComment = "Vous êtes la troisième équipe à avoir résolu cette énigme de rapidité, félicitation :)<br>";
                    elseif ($compte == 3) $specialComment = "Vous êtes la quatrième équipe à avoir résolu cette énigme de rapidité, félicitation :)<br>";
                    elseif ($compte == 4) $specialComment = "Vous êtes la cinquième équipe à avoir résolu cette énigme de rapidité, félicitation :)<br>";
                }

                // on update la liste des questionnaires débloqués par l'équipe
                if (!in_array($code, $quest)) {
                    $quest[] = $code;
                    $storeQ->execute(array(':quest' => json_encode($quest), ':login' => $_SESSION['login']));
                    $texte = 'Bonne réponse ! '.$specialComment.'Vous avez débloqué le questionnaire "'.$enigmeList[$enigme-1][1] . '"';
                    $_SESSION['someQuest'] = true;
                    $newQuest=true;
                }else{
                    $texte = 'Bonne réponse ! '.$specialComment.'Cette énigme débloque le questionnaire "'.$enigmeList[$enigme-1][1] .'", que vous avez déjà.';
                }

                // on update la liste des énigmes résolues par l'équipe
                if (!isset($enigmes[$enigme])) {
                    $enigmes[$enigme] = time();
                    $storeE->execute(array(':enigmes' => json_encode($enigmes), ':login' => $_SESSION['login']));
                    $newEni=true;
                }else{
                    $texte = 'Bonne réponse ! Vous avez déjà résolu cette énigme le '.date("d/m", $enigmes[$enigme]).' et elle débloque toujours le questionnaire "'.$enigmeList[$enigme-1][1] . '" :)';
                }

            }
            $d = array('ok' => true, 'texte' => $texte, 'code' => $code, 'newEni' => $newEni, 'newQuest' => $newQuest) ;

    	}elseif( isset($mauvais_mdp[$input]) && ($mauvais_mdp[$input][0] == $enigme || !$mauvais_mdp[$input][0]) ) {
        	$texte = $mauvais_mdp[$input][1];
            $d = array('ok' => false, 'texte' => $texte);

    	}else{
        	$texte = $wrong[array_rand($wrong)];
            $d = array('ok' => false, 'texte' => $texte);
    	}
        

    } else {
        $texte = 'Désolé, nous n\'avons pas reçu votre mot de passe :(';
        $d = array('ok' => false, 'texte' => $texte);
    }

    echo json_encode($d);

} 


// vérifier le code de l'énigme JetLag
if ( isset($_GET['diego']) ) {

    if (isset($_GET['diego']) && $_GET['diego']=="ddcdcdccddtdcdccdcd" ) {
    //if (isset($_GET['diego']) && $_GET['diego']=="cdc" ) {

        $sth = $bdd->prepare('UPDATE rallye_people SET jetlag = 1 WHERE login = :login');
        $sth->execute(array(':login' => $_SESSION['login']));
        $_SESSION['jetlag'] = true;
        echo file_get_contents('jetlag.js');
        exit;

    }else{ echo 'false'; }

}


// vérifier les horloges de l'énigme JetLag
if ( isset($_POST['clock1']) && isset($_POST['clock2']) && isset($_POST['clock3']) && isset($_POST['clock4']) && isset($_POST['clock5']) ) {

    $clock1 = false; $clock2 = false; $clock3 = false; $clock4 = false; $clock5 = false; 

    if(substr($_POST['clock1'], 0, 2)==12 && substr($_POST['clock1'], 3, 2)==25)                                       { $clock1 = true; }
    if(substr($_POST['clock2'], 0, 2)==13 && substr($_POST['clock2'], 3, 2)==30)                                       { $clock2 = true; }
    if(substr($_POST['clock3'], 0, 2)==12 && substr($_POST['clock3'], 3, 2)>=20 && substr($_POST['clock3'], 3, 2)<=25) { $clock3 = true; }
    if(substr($_POST['clock4'], 0, 2)==12 && substr($_POST['clock4'], 3, 2)>=55 && substr($_POST['clock4'], 3, 2)<=59) { $clock4 = true; }
    if(substr($_POST['clock5'], 0, 2)==16 && substr($_POST['clock5'], 3, 2)>=50 && substr($_POST['clock5'], 3, 2)<=55) { $clock5 = true; }

    $d = array('clock1' => $clock1, 'clock2' => $clock2, 'clock3' => $clock3, 'clock4' => $clock4, 'clock5' => $clock5);
    if ($clock1 && $clock2 && $clock3 && $clock4 && $clock5) {

$d['welldone'] = <<<'EOD'
$('body').prepend('<div class="help_bg"></div>');
$('.help_bg').html('<img src="ressources/img/quit.png" class="helpquit" onclick="location.reload();"><img src="ressources/img/youkounkoun.png" class="diego_a">');
EOD;

    };
    echo json_encode($d);

}

?>