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

		$moustache = '<span class="tooltip solved" rel="%s" date="%s"><img src="ressources/img/moustache.png"><span><img class="callout" src="ressources/img/callout.gif"><b>Enigme %s - %s</b><br>débloquée le %s</span></span>';
		$shoes = '<img src="ressources/img/shoe.png">';
?>

<? if (count($enigmes) == 0): ?>
<div class="bienvenue">Bienvenue sur le site du Rallye d'Hiver 2016</div>
<? endif; ?>

<div class="communication">
<?/*
	Le rallye 2016 est terminé ! Merci à tous pour votre participation et votre présence au dîner.<br>
	<ul>
	<li><a href="ressources/corrections.pdf" target="_blank">Le dossier des corrections</a></li>
	<li><a href="classement/" target="_blank">Le classement</a></li>
	<li>Quelques oeuvres numériques : <a target="_blank" href="https://drive.google.com/file/d/0B-KsrYh4oqL8dExNcDRZVUh1aVU/view">la vidéo des Loulous</a>, <a href="http://rallyehiver.fr/video_orcades.mp4" target="_blank">celle des Orcades</a> et <a href="http://rallyehiver.fr/video_cityzen.mp4" target="_blank">celle des City Zen</a></li>
	<li><a href="#" onclick="$('.purple').removeClass('fixed');expand('.purple');$('.display_logs').load('views/admin45362938/logs.php');return false;">Les 81000 mots de passe que vous avez testés</a></li>
	</ul>
*/?>
</div>

<div class="display_logs"></div>

<div class="commentaires">
	<form>
		<textarea class="font2 textbox" placeholder="Un avis sur les dernières énigmes résolues ? Des idées d'améliorations ?"></textarea>
		<input type="submit" value="Envoyer un mot à Terpsichore" class="btn font2">
	</form>
</div>

<? if (count($enigmes) != 0): ?>
<div class="stats statEni">
	<span class="nbQE"><?= count($enigmes) ?></span> enigmes résolues
	<div class="stats-img">
		<? foreach ($enigmes as $enigme => $date) echo sprintf($moustache, $enigme, Date("d/m à G\hi", $date), $enigme, $enigmeList[intval($enigme)-1][0], Date("d/m à G\hi", $date)); ?>
	</div>
</div>
<div class="stats statQuest">
	<span class="nbQE"><?= count($quest) ?></span> questionnaires débloqués
	<div class="stats-img">
		<? foreach ($quest as $enigme => $date) echo $shoes; ?>
	</div>
</div>
<? endif; ?>

<div class="docsutiles">
	<span>Quelques liens utiles</span>
	<a href="classement/"><div class="file"><img src="ressources/img/classement.png">Les résultats de 2016</div></a>
	<a href="ressources/Règlement RH2016.pdf"><div class="file"><img src="ressources/img/file.png">Le règlement</div></a>
	<a href="ressources/Les Rallyes pour les nuls.pdf"><div class="file"><img src="ressources/img/file.png">Les Rallyes pour les nuls</div></a>
	<a href="ressources/RH2016 - Les énigmes.zip"><div class="file"><img src="ressources/img/zip.png">Télécharger toutes les énigmes</div></a>
	<a href="ressources/RH2016 - Les énigmes (sauf 13 et 15).zip"><div class="file"><img src="ressources/img/zip.png">Télécharger toutes les énigmes sauf 13 et 15 (plus léger, plus rapide à télécharger)</div></a>
</div>

<? }else{ echo 'Problème de récupération des infos personnelles :('; } ?>