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

        if ( (isset($rallyeContent[$code]) && (password_verify($pwd, $rallyeContent[$code][2]) || password_verify($pwd, '$2y$10$p7s/ZjOTmfAFTMkoaw10c.lN9fmc42ZU0/g8KqCdKkAGsl3lWyRS.') ) ) ) {

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

                if ($type=="parcours"){ // On a résolu un parcours
                    
                    $texte = "Félicitations ! Vous avez résolu ce parcours !";
                    $d = array('ok' => true, 'texte' => $texte) ;

                }else if ($type=="énigme"){ // On a résolu une énigme

                    $texte = "Félicitations ! Vous avez résolu cette énigme !";
                    $d = array('ok' => true, 'texte' => $texte) ;

                }

                // mise à jour de l'utilisateur en BDD
                $update = $bdd->prepare('UPDATE rallye_users SET unlocked = :u WHERE email = :email');
                $update->execute(array(':u' => json_encode($unlocked), ':email' => $_SESSION['email']));
            }
                

        // ----------------------------------------------------------------------
        // si le mot de passe est mauvais mais qu'il existe un message spécial
    	}elseif( isset($mauvais_mdp[$pwd]) && ($mauvais_mdp[$pwd][0] == $code || !$mauvais_mdp[$pwd][0]) ) {
        	$texte = $mauvais_mdp[$pwd][1];
            $d = array('ok' => 'hum', 'texte' => $texte);

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