<?php

// on vérifie que la bdd est bien initialisée (sinon cela signifie que l'on appelle en ajax)
if (!isset($bdd)) {
	require_once '../ressources/info.php';
	require_once '../controllers/db.php';
	require_once '../controllers/login.php';
}

// on récupére la liste des énigmes et questionnaires débloqués par l'équipe
$sth = $bdd->prepare('SELECT quest, enigmes FROM rallye_people WHERE nom = :nom LIMIT 1');

	if ($sth->execute(array(':nom' => $_SESSION['nom']))) {
		
		$answer = $sth->fetch();
		$enigmes = json_decode($answer['enigmes'], true);
		$quest = json_decode($answer['quest'], true);

		$moustache = '<span class="tooltip solved" rel="%s" date="%s"><i class="fas fa-puzzle-piece"></i><span><img class="callout" src="ressources/img/callout.gif"><b>Enigme %s - %s</b><br>débloquée le %s</span></span>';
		$shoes = '<i class="fas fa-chess-knight"></i>';
?>

<? if (count($enigmes) == 0): ?>
<div class="bienvenue">Bienvenue sur le site du Rallye d'Hiver 2019</div>
<? endif; ?>

<div class="display_logs"></div>

<? if (count($enigmes) != 0): ?>
<div class="stats statEni">
	<span class="nbQE"><?= count($enigmes) ?></span> enigmes résolues
	<div class="stats-img">
		<? foreach ($enigmes as $enigme => $date) echo sprintf($moustache, $enigme, Date("d/m à G\hi", $date), $enigme, $enigmeList[intval($enigme)-1][0], Date("d/m à G\hi", $date)); ?>
	</div>
</div>
<div class="stats statQuest">
	<span class="nbQE"><?= count($quest) ?></span> parcours disponibles
	<div class="stats-img">
		<? foreach ($quest as $enigme => $date) echo $shoes; ?>
	</div>
</div>
<? endif; ?>


<div class="docsutiles">
	<span>Quelques liens utiles</span>
	<a href="docs/classement.pdf">
		<div class="file" style="color:#0bafd2;">
			<i class="fas fa-medal"></i>
			Les résultats de 2019
		</div>
	</a>
	<a href="docs/reglement_rh2019.pdf">
		<div class="file">
			<i class="fas fa-book"></i>
			Les règles du jeu
		</div>
	</a>
	<a href="docs/guide_debutant_rh2019.pdf">
		<div class="file">
			<i class="fas fa-ambulance"></i>
			Guide du débutant en rallye
		</div>
	</a>
	<a href="docs/RH2019 - Enigmes.pdf">
		<div class="file">
			<i class="fas fa-download"></i>
			Télécharger toutes les énigmes
		</div>
	</a>
	<a href="?disconnect">
		<div class="file">
			<i class="fas fa-power-off"></i>
			Se déconnecter 
		</div>
	</a>
</div>

<div class="commentaires">
	<form>
		<textarea class="font2 textbox" placeholder="Un avis sur les dernières énigmes résolues ? Des idées d'améliorations ?"></textarea>
		<input type="submit" value="Envoyer un mot aux organisateurs" class="btn font2">
	</form>
</div>

<? }else{ echo 'Problème de récupération des infos personnelles :('; } ?>