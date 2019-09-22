<!DOCTYPE html>
<html>

<!-- Bon état d'esprit ! Mais tu ne trouveras rien ici à part du code d'une qualité exceptionnelle -->

<head>
	<title>RH2016 | Inscription</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-62904031-1', 'auto');
		ga('send', 'pageview');

	</script>

	<script>
		$(document).ready(function(){void 0==document.createElement("input").placeholder&&$("[placeholder]").focus(function(){$(this).val()==$(this).attr("placeholder")&&$(this).val("")}).blur(function(){""==$(this).val()&&$(this).val($(this).attr("placeholder"))}).blur().parents("form").submit(function(){$(this).find("[placeholder]").each(function(){$(this).val()==$(this).attr("placeholder")&&$(this).val("")})})});
	</script>

	<script>
		function ajouterCo () {
			nb = $('.member').length;
			if (nb < 8) {
				$('.member:last').after('<tr class="member"><td><input name="member'+(nb+1)+'" type="text" class="textbox font2 medium" placeholder="Prénom et nom du coéquipier"/></td><td><input name="membermail'+(nb+1)+'" type="email" class="textbox font2 medium" placeholder="Son adresse e-mail"/></td></tr>');
			};
			if (nb == 7) {
				$('.addmember').hide();
			};
		}
	</script>

	<style type="text/css">
		@font-face {
			font-family: 'Altus';
			src: url('res/Altus.eot');
			src: url('res/Altus.eot?#iefix') format('embedded-opentype'),
			     url('res/Altus.woff2') format('woff2'),
			     url('res/Altus.woff') format('woff'),
			     url('res/Altus.ttf') format('truetype'),
			     url('res/Altus.svg#Altus') format('svg');
			font-weight: normal;
			font-style: normal;
		}
		a { outline: none; text-decoration: none; color: inherit; }
		html { font-size: 100%; } 
		body { background: #df5537 url("res/bg.png") repeat; padding: 0; margin: 0; font-family: "Altus", Helvetica, sans-serif; font-size: 1.5rem; text-align: center; }
		#soon { text-align: left; margin: 5% 0; background-color: rgba(54, 41, 46, 0.8); color: #fff; padding:50px 15%; border-radius: 25px; display: inline-block; }
		h1 { font-size: 2rem; }
		#errorMessage { color: #e85938; margin-bottom: 20px; font-size: 22px; }
		.medium { width: 260px; }
		.large { width: 400px; }
		.textbox { background: none; border: none; border-bottom: 1px solid #bdc3c7; padding: 5px; color: #fff; vertical-align: middle; outline:none; }
		.btn { cursor: pointer; color: #fff; background-color: #e85938; border: none; padding: 6px 20px; margin-top: 10px; 
			vertical-align: middle; border-radius: 4px; transition: background-color .25s linear; }
		.btn:hover { background-color: #e68772; }
		.font2 { font: 13px "open sans", sans-serif; }
		table { border-spacing: 10px; border-collapse: separate; }
	</style>

</head>
<body>
<div id="soon">

<?

$displayForm = true;
$errorMessage = '';

if (isset($_POST['team']) || isset($_POST['leader']) || isset($_POST['leadermail'])) {
	
	if (!isset($_POST['team']) || $_POST['team'] == "") { $errorMessage .= "Vous devez saisir un nom d'équipe.<br>"; }
	if(!isset($_POST['leader']) || $_POST['leader'] == "") { $errorMessage .= "Vous devez saisir le nom du chef d'équipe.<br>"; }
	if(!isset($_POST['leadermail']) || $_POST['leadermail'] == "") { $errorMessage .= "Vous devez saisir le mail du chef d'équipe.<br>"; }

	if(isset($_POST['team']) && isset($_POST['leader']) && isset($_POST['leadermail']) && $_POST['team'] != "" && $_POST['leader'] != "" && $_POST['leadermail'] != ""){

		// ouverture de la bdd et préparation des requêtes
		require 'db.php';
		$search = $bdd->prepare('SELECT `id` FROM rallye_people WHERE nom = :nom');
		$add = $bdd->prepare('INSERT INTO rallye_people (login, nom, contact) VALUES (:login, :nom, :contact)');
		
		// création d'un objet json contenant les membres et leurs 
		$contact = array($_POST['leader'] => $_POST['leadermail']);
		$i = 1;
		while (isset($_POST['member'.$i]) && $_POST['member'.$i] != "") {
			$contact[$_POST['member'.$i]] = isset($_POST['membermail'.$i]) ? $_POST['membermail'.$i] : "";
			$i++;
		}
		$contact = json_encode($contact);
		
		$oldcar = array(" ", "'", "é", "è", "à", "ê", "â", "ô", "ç", "û", "ù", "ï", "î");
		$newcar = array("-", "", "e", "e", "a", "e", "a", "o", "c", "u", "u", "i", "i");
		$login = strtolower(str_replace($oldcar, $newcar, $_POST['team']));

		// on vérifie si le nom de l'équipe est déjà enregistré
		$search->execute(array(':nom' => $_POST['team']));
		$result = $search->fetchAll();
		if( count($result) > 0 ) {
			$errorMessage = "Le nom d'équipe <b>".htmlspecialchars($_POST['team'])."</b> existe déjà :(<br>";
			$errorMessage .= "Si vous cherchez simplement à modifier les informations pour votre équipe, contactez nous (terpsichore.team@gmail.com).<br>";
			$errorMessage .= "Sinon, il vous faut trouver un nouveau nom d'équipe !";
		}else{
			if ($add->execute(array(':login' => $login, ':nom' => $_POST['team'], ':contact' => $contact))) {
				$displayForm = false;
				echo "L'inscrition de votre équipe <b>".htmlspecialchars($_POST['team'])."</b> a bien été prise en compte. Merci !<br>";
				echo "Pour finaliser votre inscription, n'oubliez pas de nous faire parvenir un chèque de 25€, à l'ordre d'Audrey Darmon, à l'adresse ci-dessous :<br><br>";
				echo "<i>Audrey Darmon<br>9 rue Jean-François Gerbillon<br>75006 Paris</i><br><br>";
				echo "Vos identifiants pour accéder au site du rallye vous seront communiqués une fois votre participation reçue.<br>A bientôt !";
			}else{
				$errorMessage = "Désolé, nous n'avons pas pu prendre en compte cette demande. Si l'erreur persiste, contactez nous (terpsichore.team@gmail.com) en nous copiant l'erreur ci-dessous :<br><br>";
				print_r($bdd->errorInfo());
			}
		}
	}
};

if ($displayForm) {
?>

<h1>Inscrivez-vous ici pour participer au Rallye d'Hiver 2016</h1>
<? if ($errorMessage) { echo '<div id="errorMessage">'.$errorMessage.'</div>'; } ?>
<form id="inscriptionForm" action="?" method="post">
<table>
	
	<tr>
		<td colspan="2"><input name="team" type="text" class="textbox font2 large" placeholder="Nom de votre équipe" <? echo isset($_POST['team']) ? 'value="'.htmlspecialchars($_POST['team']).'"' : ""; ?> /></td>
	</tr>
	
	<tr>
		<td><input name="leader" type="text" class="textbox font2 medium" placeholder="Prénom et nom du chef d'équipe" <? echo isset($_POST['leader']) ? 'value="'.htmlspecialchars($_POST['leader']).'"' : ""; ?> /></td>
		<td><input name="leadermail" type="email" class="textbox font2 medium" placeholder="Son adresse e-mail" <? echo isset($_POST['leadermail']) ? 'value="'.htmlspecialchars($_POST['leadermail']).'"' : ""; ?> />
	</tr>

	<tr class="member">
		<td><input name="member1" type="text" class="textbox font2 medium" placeholder="Prénom et nom du coéquipier" <? echo isset($_POST['member1']) ? 'value="'.htmlspecialchars($_POST['member1']).'"' : ""; ?> /></td>
		<td><input name="membermail1" type="email" class="textbox font2 medium" placeholder="Son adresse e-mail" <? echo isset($_POST['membermail1']) ? 'value="'.htmlspecialchars($_POST['membermail1']).'"' : ""; ?>/></td>
	</tr>

<?	$i = 2;
	while (isset($_POST['member'.$i]) && $_POST['member'.$i] != "") {
?>
		<tr class="member">
			<td><input name="member<? echo $i; ?>" type="text" class="textbox font2 medium" placeholder="Prénom et nom du coéquipier" value="<? echo htmlspecialchars($_POST['member'.$i]); ?>" /></td>
			<td><input name="membermail<? echo $i; ?>" type="email" class="textbox font2 medium" placeholder="Son adresse e-mail" <? echo isset($_POST['membermail'.$i]) ? 'value="'.htmlspecialchars($_POST['membermail'.$i]).'"' : ""; ?> /></td>
		</tr>
<?		$i++;
	} 
?>
	
	<tr class="addmember">
		<td colspan="2" class="font2"><a href="#" onclick="ajouterCo(); return false;"><button class="btn font2">Ajouter un coéquipier</button><a/></td>
	</tr>
	
	<tr>
		<td colspan="2"><input name="submit" type="submit" value="Soumettre votre inscription" class="btn font2" /></td>
	</tr>

</table>
</form>

<? } ?>

</div>
</body>
</html>