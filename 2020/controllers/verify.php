<?php

// AJAX controller

// ----------------------------------------------------------------------
// on vérifie si l'utilisateur a une session en cours
require_once 'initialize.php';
if (!$auth) { echo json_encode(array('loginerror')); exit; }


// ----------------------------------------------------------------------
// on vérifie que l'on a reçu les bons paramètres
if(isset($_GET['code']) && isset($_GET['pwd'])) {
    if(($_GET['code'] !== '') && ($_GET['pwd'] !== '')) {

        $code = $_GET['code'];
        $pwd = $_GET['pwd'];
        
            
        // ----------------------------------------------------------------------
        // on loggue l'essaie de mot de passe
        $storeTry = $bdd->prepare('INSERT INTO rallye_try (equipe, enigme, mdp) VALUES (:equipe, :enigme, :mdp)');
        $storeTry->execute(array(':equipe' => $_SESSION['login'], ':enigme' => $code, ':mdp' => $pwd));

        // ----------------------------------------------------------------------
        // on applique quelques transformations sur le mot de passe
        $oldcar = array(" ", "-", "'", "é", "è", "à", "ê", "â", "ô", "ç", "û", "ù", "ï", "î", "’", "É", "È", "Ç","À","Ù");
        $newcar = array("", "", "", "e", "e", "a", "e", "a", "o", "c", "u", "u", "i", "i", "", "e", "e", "c","a","u");
        $pwd = strtoupper(str_replace($oldcar, $newcar, $pwd));

        // ----------------------------------------------------------------------
        // on teste si le mot de passe est correct 

        if ( (isset($rallyeContent[$code]) && (password_verify($pwd, $rallyeContent[$code][2]) || password_verify($pwd, '$2y$10$n0IZQvChToSp.VUU9YXcHOgW4gM62gyU2qGRbLWW75ZkGobCVcI42') ) ) ) {

            $unlocked = $_SESSION['unlocked'];
            // est-ce que c'est une énigme ou un parcours ?
            $type = ($code[0]=="E")?"énigme":"parcours";

            if ($unlocked[$code]) {

                // si le contenu a déjà été résolu par l'utilisateur
                if ($type=="énigme") $texte = 'Bonne réponse ! Vous aviez déjà résolu cette énigme le '.date("d/m", $unlocked[$code]).' :)';
                else $texte = 'Bonne réponse ! Vous aviez déjà résolu ce parcours le '.date("d/m", $unlocked[$code]).' :)';
                $d = array('ok' => true, 'texte' => $texte) ;

            }else{

                $unlocked[$code] = time(); // on ajoute le temps de résolution

                // ----------------------------------------------------------------------
                // Logique de déblocage du contenu

                if ($code == 'P00wiG7d67n') {   // PARCOURS 0 (prologue)

                    $unlocked["E21fh74gZx9"] = false;
                    $texte = "Bien joué. J'espère que votre rencontre avec le Baron s'est bien déroulée ! Vous avez maintenant accès à l'énigme finale. Oh et j'oubliais, il me semble que cet indice pourrait vous être utile : ".$rallyeContent[$code][3].".";
                    $d = array('ok' => true, 'texte' => $texte) ;

                
                }else if ($code == 'P11s2wzbJRN') {   // PARCOURS 11 (épilogue)

                    $texte = "Félicitations pour votre efficacité ! La SSGV vous informe que le Baron Haussmann a réussi à retourner dans son temps.";
                    $d = array('ok' => true, 'texte' => $texte) ;

                
                }else if($code == 'E21fh74gZx9'){    // ENIGME FINALE
                    
                    $unlocked["P11s2wzbJRN"] = false;
                    $texte = "Impressionnant ... Vous avez parcouru avec succès les visites de ce rallye et avez résolu l'énigme finale. Serez-vous à la hauteur pour un tout dernier parcours ? Vous venez de le débloquer.";
                    $d = array('ok' => true, 'texte' => $texte) ;


                }else if ($type=="parcours"){ // On a résolu un parcours
                    
                    if ( !isset($unlocked['E11YcdRWwzc']) ) {
                        $unlocked["E11YcdRWwzc"] = false;
                        $unlocked["E12mSedBRcj"] = false;
                        $texte = "Bravo ! Vous avez débloqué deux énigmes supplémentaires. Cet indice pourrait également vous être utile : ".$rallyeContent[$code][3];
                    }else if ( !isset($unlocked['E13D8jf7Uts']) ) {
                        $unlocked["E13D8jf7Uts"] = false;
                        $unlocked["E14FqqZ8N6F"] = false;
                        $texte = "Félicitations ! Vous avez débloqué deux énigmes supplémentaires. Vous pourriez également avoir besoin de cet indice : ".$rallyeContent[$code][3];
                    }else if ( !isset($unlocked['E15fcGWBAwF']) ) {
                        $unlocked["E15fcGWBAwF"] = false;
                        $unlocked["E16Jcz74Jqh"] = false;
                        $texte = "Bien joué ! Vous avez débloqué deux énigmes supplémentaires. Je serais vous, je noterais aussi cet indice : ".$rallyeContent[$code][3];
                    }else if ( !isset($unlocked['E17ucgHNV8F']) ) {
                        $unlocked["E17ucgHNV8F"] = false;
                        $unlocked["E18NNjPUs3K"] = false;
                        $texte = "Bravo ! Vous avez débloqué deux énigmes supplémentaires. Cet indice pourrait également vous être utile : ".$rallyeContent[$code][3];
                    }else if ( !isset($unlocked['E19EKsmu647']) ) {
                        $unlocked["E19EKsmu647"] = false;
                        $unlocked["E20RZcq4LqZ"] = false;
                        $texte = "Bien joué ! Vous avez débloqué les énigmes 19 et 20. Vous devriez également noter cette indice : ".$rallyeContent[$code][3];
                    }else{
                        $texte = "Bravo ! Vous ne débloquez pas de nouvelle énigme, mais cet indice pourrait vous être utile : ".$rallyeContent[$code][3];
                    }

                    $d = array('ok' => true, 'texte' => $texte) ;


                }else if ($type=="énigme"){ // On a résolu une énigme

                    // on débloque le prochain parcours, sauf si il n'y en a plus de dispo
                    if ( isset($unlocked["P10xtdwXzHF"]) ) {
                        $texte = "Bravo ! Vous ne débloquez pas de nouveau parcours mais vous gagnez des points ;)";
                        $d = array('ok' => true, 'texte' => $texte) ;
                    }else{
                        foreach ($rallyeContent as $key => $value) {
                            if ( $key[0]=="P" && !isset($unlocked[$key]) ) {
                                $unlocked[$key] = false;
                                $texte = "Bravo ! Vous débloquez un nouveau parcours : ".$value[0];
                                $d = array('ok' => true, 'texte' => $texte) ;
                                break;
                            }
                        }
                    }

                }

                // mise à jour de l'utilisateur en BDD
                $update = $bdd->prepare('UPDATE rallye_people SET unlocked = :u WHERE login = :login');
                $update->execute(array(':u' => json_encode($unlocked), ':login' => $_SESSION['login']));
            }
                

        // ----------------------------------------------------------------------
        // si le mot de passe est mauvais mais qu'il existe un message spécial
    	}elseif( isset($mauvais_mdp[$pwd]) && ($mauvais_mdp[$pwd][0] == $code || !$mauvais_mdp[$pwd][0]) ) {
        	$texte = $mauvais_mdp[$pwd][1];
            $d = array('ok' => false, 'texte' => $texte);

         // ----------------------------------------------------------------------
    	// si le mot de passe est mauvais
        }else{
        	$texte = $wrong[array_rand($wrong)];
            $d = array('ok' => false, 'texte' => $texte);
    	}
        
    // ----------------------------------------------------------------------
    // s'il y a une autre erreur
    } else {
        $texte = 'Désolé, il y a eu une erreur dans la vérification de votre mot de passe :( contactez-nous.';
        $d = array('ok' => false, 'texte' => $texte);
    }

    // ----------------------------------------------------------------------
    // on encode et on envoie la réponse ajax
    echo json_encode($d);

}

?>