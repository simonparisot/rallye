<?php

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// SMTP parameters (https://eu-west-1.console.aws.amazon.com/ses/home?region=eu-west-1#/smtp)
$usernameSmtp = 'AKIAQQ6TPVCR2WT5RIV7';
$passwordSmtp = 'BMdDoDFL4MVu4nrjj5xP90WB/y+yiWd1t2D+KSJLf7+N';
$host = 'email-smtp.eu-west-1.amazonaws.com';
$port = 587;

// location of the Composer autoload.php file.
require '../../vendor/autoload.php';

// connection to DB
$dbyear="rallyehiver2023";
require_once realpath(dirname(__FILE__).'/../../db.php');

if( isset($_POST['email']) ) {

    $sth = $bdd->prepare('SELECT * FROM rallyecommon.users2 WHERE email = :email LIMIT 1');
    if ($sth->execute(array(':email' => $_POST['email']))) {
        $user = $sth->fetchAll();
        if( count($user) > 0 ) {
            $user = $user[0];

            // Replace recipient@example.com with a "To" address. If your account
            // is still in the sandbox, this address must be verified.
            $teamLeaderMail = $_POST['email'];
            $teamCode = randomPassword();

            // store new pwd in db
            //$sth = $bdd->prepare('INSERT INTO rallye_log (ip, equipe, log) VALUES (:ip, :equipe, :log)');
            $sth = $bdd->prepare('UPDATE rallyecommon.users2 SET `code` = :code WHERE `users2`.`email` = :email');
            $sth->execute(array(':email' => $_POST['email'], ':code' => $teamCode));

            // sending parameters
            $sender = 'hello@rallyehiver.fr';
            $senderName = "Rallye d'Hiver";
            $replyfrom = "rallyehiver2023@gmail.com";
            $replyfromName = "Les organisateurs";

            // email parameters
            $subject = "Rallye d'Hiver 2023 : votre mot de passe";
            $bodyText =  "Bonjour, nous avons généré un nouveau code de connexion pour votre équipe. Il vous permet de vous connecter sur le site du Rallye d'Hiver. Le voici : $teamCode . Pensez à le communiquer à votre équipe. Bon rallye !";
            $bodyHtml = "
                <p>Bonjour,</p>
                <p>Nous avons généré un nouveau code de connexion pour votre équipe. Il vous permet de vous connecter sur le <a href='https://rallyehiver.fr'>site du Rallye d'Hiver</a>. Le voici :</p>
                <p><b>$teamCode</b><p>
                <p>Pensez à le communiquer à votre équipe.</p>
                <p>Bon rallye !</p>
            ";

            $mail = new PHPMailer(true);

            try {
                // Specify the SMTP settings.
                $mail->isSMTP();
                $mail->addReplyTo($replyfrom, $replyfromName);
                $mail->setFrom($sender, $senderName);
                $mail->Username   = $usernameSmtp;
                $mail->Password   = $passwordSmtp;
                $mail->Host       = $host;
                $mail->Port       = $port;
                $mail->SMTPAuth   = true;
                $mail->SMTPSecure = 'tls';
                //$mail->addCustomHeader('X-SES-CONFIGURATION-SET', $configurationSet);

                // Specify the message recipients.
                $mail->addAddress($teamLeaderMail);
                // You can also add CC, BCC, and additional To recipients here.

                // Specify the content of the message.
                $mail->isHTML(true);
                $mail->Subject    = $subject;
                $mail->Body       = $bodyHtml;
                $mail->AltBody    = $bodyText;
                $mail->Send();
                header('location: /?resetcode');
                exit;
            } catch (phpmailerException $e) {
                echo "An error occurred. {$e->errorMessage()}", PHP_EOL; //Catch errors from PHPMailer.
            } catch (Exception $e) {
                echo "Email not sent. {$mail->ErrorInfo}", PHP_EOL; //Catch errors from Amazon SES.
            }

        }
    }
}

function randomPassword() {
  // Array of scientists to choose from
  $words = array("Newton", "Einstein", "Galileo", "Curie", "Aristote", "DeVinci", "Darwin", "Edison", "Hubble", "Oppenheimer", "Armstrong", "Franklin", "Hawking", "Franklin", "Lovelace", "Ernest Rutherford", "Sagan", "Carson", "Archimede", "Bohr", "Mendeleïev", "Kepler", "Laplace", "Maxwell", "Faraday", "Tesla", "Copernic", "Pasteur", "Planck", "Langevin", "Pascal", "Volta", "Ptolémée", "Ohm", "DeBroglie", "Becquerel", "Dirac", "Descartes", "Ampère", "Michelson", "Schrödinger", "Turing", "Lavoisier", "Carnot", "Lister", "Hertz", "Boltzmann", "Higgs", "Cantor", "Shannon");

  // Get the word at the random index
  $randomPwd = $words[array_rand($words)]."-".$words[array_rand($words)]."-".$words[array_rand($words)]."-".$words[array_rand($words)];

  // Return the random word
  return $randomPwd;
}

?>

