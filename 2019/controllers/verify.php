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

        // Si le mot de passe est bon
    	if ( $enigmeList[$enigme-1][2] == $input ) {

            // initialisation variables et requêtes SQL
            $texte = 'Bonne réponse ! Par contre une erreur nous empêche de débloquer le parcours :( Contactez-nous !';
            $newEni = false;
            $newQuest = false;
            $take = $bdd->prepare('SELECT quest, enigmes FROM rallye_people WHERE login = :login LIMIT 1'); 
            $storeQ = $bdd->prepare('UPDATE rallye_people SET quest = :quest WHERE login = :login');
            $storeE = $bdd->prepare('UPDATE rallye_people SET enigmes = :enigmes WHERE login = :login');
            // $code = array_search($enigmeList[$enigme-1][1], $questList);
            $specialComment = '';
                
            // Routine spécifique pour les énigmes de rapidité
            if ($enigme == 18 || $enigme == 19 || $enigme == 20) {
                $compte = 0;
                $search = $bdd->prepare('SELECT * FROM rallye_people WHERE login != "theb2" AND login != "orga" AND login != "sacregrallye" ORDER BY id');
                if ($search->execute()) {
                    while ($team = $search->fetch()) {
                        // on compte le nombre d'équipes qui a déjà résolu l'énigme
                        $e = (array)json_decode($team['enigmes'], true);
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
                else $specialComment = "Vous êtes la " . ((int)$compte+1) . "ème équipe à avoir résolu cette énigme de rapidité :)<br>";


            }
            // ----------------------------------------------------------------------

            // récupération des énigmes résolues et parcours débloqués
            if ($take->execute(array(':login' => $_SESSION['login']))) {
                $result = $take->fetchAll();
                $enigmes = json_decode($result[0]['enigmes'], true);
                $quest = json_decode($result[0]['quest'], true);

                // si on est en accès anonyme, on n'enregistre rien
                if ($_SESSION['login'] == "anonymous") {
                    $texte = 'Félicitation ! C\'est la bonne réponse.';
                    $d = array('ok' => true, 'texte' => $texte, 'newEni' => $newEni, 'newQuest' => $newQuest) ;

                // si c'est la première fois que cette énigme est résolue
                }elseif (!isset($enigmes[$enigme])) {

                    // on update la liste des énigmes résolues par l'équipe
                    $enigmes[$enigme] = time();
                    $storeE->execute(array(':enigmes' => json_encode($enigmes), ':login' => $_SESSION['login']));
                    $newEni=true;

                    // on détermine le parcours à débloquer
                    // si c'est le quatrième parcours débloqué, c'est forcément l'escape game
                    if (count($quest) == 3) {
                        $code = array_search("Jeu d'échappatoire", $questList);
                        $newQuest=true;
                    }
                    // si c'est le septième parcours débloqué, c'est forcément le musée de la contrefaçon
                    elseif (count($quest) == 7) {
                        $code = array_search("Faux et usages de faux", $questList);
                        $newQuest=true;
                    }
                    // si l'équipe a débloqué tous les parcours, on stoppe ici
                    elseif (count($quest) >= count($questList)) {
                        $texte = 'Bonne réponse ! '.$specialComment.'Vous avez déjà débloqué tous les parcours de ce Rallye !';
                        $d = array('ok' => true, 'texte' => $texte, 'newEni' => true, 'newQuest' => false) ;
                        echo json_encode($d);
                        exit;
                    }
                    // sinon on choisi au hasard dans les parcours non débloqués
                    else {
                        // on construit un tableau avec les parcours potentiels
                        foreach ($questList as $key => $value){
                            //echo "(DEBUG)$value$key // ";
                            if (!in_array($key, $quest) && $value != "Jeu d'échappatoire" && $value != "Faux et usages de faux") $t[] = $key;
                        }
                        // puis on tire au sort et on push dans la liste des parcours débloqués
                        $code = $t[array_rand($t)];
                        $newQuest=true;
                    }

                    // on update la liste des questionnaires débloqués par l'équipe
                    $quest[] = $code;
                    $storeQ->execute(array(':quest' => json_encode($quest), ':login' => $_SESSION['login']));
                    $texte = 'Bonne réponse ! '.$specialComment.'Vous avez débloqué le parcours "'.$questList[$code] . '"';
                    $_SESSION['someQuest'] = true;
                    $d = array('ok' => true, 'texte' => $texte, 'code' => $code, 'newEni' => $newEni, 'newQuest' => $newQuest) ;
                 
                // si l'énigme a déjà été résolue       
                }else{
                    $texte = 'Bonne réponse ! Vous avez déjà résolu cette énigme le '.date("d/m", $enigmes[$enigme]).' :)';
                    $d = array('ok' => true, 'texte' => $texte, 'newEni' => $newEni, 'newQuest' => $newQuest) ;
                }

            }

        // si le mot de passe est mauvais mais qu'il existe un message spécial
    	}elseif( isset($mauvais_mdp[$input]) && ($mauvais_mdp[$input][0] == $enigme || !$mauvais_mdp[$input][0]) ) {
        	$texte = $mauvais_mdp[$input][1];
            $d = array('ok' => false, 'texte' => $texte);

    	// si le mot de passe est mauvais
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

?>