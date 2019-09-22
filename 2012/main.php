<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Rallye d'hiver 2012 - Enigmes et découvertes à Paris</title>
	<link rel="stylesheet" media="screen" type="text/css" title="style" href="stylesheet2.css" />
	<link rel="icon" type="image/png" href="pictures/favicon2.png" />
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/toolbox.js"></script>
	<script type="text/javascript" src="js/display10.js"></script>
	<script type="text/javascript" src="js/end.js"></script>
	<script type="text/javascript" src="js/controle.js"></script>
<? if($login==1){ ?>
	<script type="text/javascript" src="js/lightbox.js"></script>
	<script src="js/flot.js" type="text/javascript"></script>
	<!--[if IE]>
	<script type="text/javascript" src="js/excanvas.js"></script>
	<![endif]-->   	
<? } ?>
	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-27051659-1']);
	  _gaq.push(['_setSiteSpeedSampleRate', 10]);
	  _gaq.push(['_trackPageview']);

	  (function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>
	<script type="text/javascript">
		
		var admin = <? if($login==1){ ?> true <? }else{ ?> false <? } ?>;
		var test_mdp;
		var bulle = 0;
		
		//récupération des questionnaires débloqués
		var quest_deblo = new Array();
		var lieu_deblo = new Array();
		
		<? 
			if(isset($data)){
				$nb = 0;
				foreach($data as $cle => $valeur){
					if($valeur){
						$nb++;
						$bob = explode('~', $valeur);
						echo 'quest_deblo['.$cle.'] = "'.$bob[0].'";';
						echo 'lieu_deblo['.$cle.'] = "'.$bob[1].'";';
						$quest_debloques = true;
					}else{
						echo 'quest_deblo['.$cle.'] = false;';
						echo 'lieu_deblo['.$cle.'] = false;';
					}
				}
				echo 'var indices = '.$indices.';';
				echo 'var enigmes = '.$nb.';';
			}
		?>
		
		$(document).ready(function(){
			$('.article_actif').fadeTo('100', 0.85);							// on affiche la première page
			
			$('#page').on("click", '.lien', function(e){ 						// lors d'un clic sur une class "lien" ...
				changer_page($(this));											// on change de page
			});
			
			$('#page').on("click", '.onglet', function(e){ 						// lors d'un clic sur une class "onglet" ...
				changer_onglet($(this));										// on change d'onglet
			});	
			
			$("#board_fame").on("click", ".bonusOn", function () {				// lors d'un clic sur une class "bonus_on" ...
				bonusOn($(this).attr('rel'));									// on affiche les infos sur l'énigme bonus
			});
			
			$("#board_fame").on("click", ".bonusOff", function () {				// lors d'un clic sur une class "bonus_off" ...
				bonusOff($(this).attr('rel'));									// on cache les infos sur l'énigme bonus
			});
			
			$('#board_fame').on("click", ".bonusSelect", function(e){ 			// lors d'un clic sur une class "bonus_select" ...
				bonusSelect($(this).attr('rel'));								// on selectionne l'énigme bonus
			});
			
			$('#dossierForm').submit(function(e){ 								// lors d'un clic sur une class "dossierSend" ...
				$('#dossierText').html('<b>Envoi en cours ...</b><br/><br/>');
				$('#dossierText').css('text-align', 'center');
				load();
				return true;
			});
			
			$("[name='diner']").change(function(){								// lors d'un clic la checkbox "enigme diner" ...
				controle2('diner');												// on lance la vérification
			});
			
			// document.getElementById("content").style.backgroundImage = 'url("pictures/background<? echo round(rand(1,2)); ?>.jpg")';
			// rebour();
			if(!admin)show_quest_deblo();
			if(admin)touchScroll('synthese_content');
			if(admin)touchScroll('board_c');
			if(admin)touchScroll('logScroll');
			touchScroll('reglement_content');
		});
	</script>
	
</head>

<body>

<script type="text/javascript">
	if(nav()<7){
		document.write('<div id="iewarning"><b>La version de votre navigateur internet (IE'+nav()+') n\'est plus à jour et ne permet pas d\'afficher ce site correctement.<br/>Nous vous invitons à installer un navigateur récent comme <a href="http://www.mozilla-europe.org/fr/">Firefox</a>. N\'hesitez pas à nous contacter pour plus d\'information.</b></div>')
	}
</script>

<img alt="" id="paper" src="pictures/paper.png" style="display:none;position:absolute;top:0px;left:0px;" onclick=" ();" />
<div id="paper_text" style="position:absolute;top:3px;left:3px;width:20px;" onclick="show_facileajouez();"></div>

<div id="page">
	
	<div id="logo"></div>
	
	<div id="menu">
			<a id="accueil_b" href="index.php?page=accueil">						<img alt="" id="bouton_1" class="bouton <? if($page == "accueil"){ ?>lien_selected<? } ?>" src="pictures/home.png" />		</a>
		<? if(!$login){ ?>
			<a id="connexion_b" class="lien" rel="#connexion" href="#">				<img alt="" id="bouton_2" class="bouton <? if($page == "perso"){ ?>lien_selected<? } ?>" src="pictures/connexion.png" />		</a>
		<? }else{ ?>
			<a id="perso_b" class="lien" rel="#perso" href="#">						<img alt="" id="bouton_2" class="bouton <? if($page == "perso"){ ?>lien_selected<? } ?>" src="pictures/groupe.png" />			</a>
		<? } ?>
			<a id="calendrier_b" class="lien" rel="#calendrier" href="#">			<img alt="" id="bouton_3" class="bouton <? if($page == "calendrier"){ ?>lien_selected<? } ?>" src="pictures/calendrier.png" />		</a>
			<a id="reglement_b" class="lien" rel="#reglement" href="#">				<img alt="" id="bouton_4" class="bouton <? if($page == "reglement"){ ?>lien_selected<? } ?>" src="pictures/reglement.png" />		</a>
			<a id="enigmes_b" class="lien" rel="#enigmes" href="#">					<img alt="" id="bouton_5" class="bouton <? if($page == "enigmes"){ ?>lien_selected<? } ?>" src="pictures/enigmes.png" />			</a>
			<a id="questionnaires_b" class="lien" rel="#questionnaires" href="#">	<img alt="" id="bouton_6" class="bouton <? if($page == "questionnaires"){ ?>lien_selected<? } ?>" src="pictures/questionnaires.png" />	</a>
			<a id="contacts_b" class="lien" rel="#contacts" href="#">				<img alt="" id="bouton_7" class="bouton <? if($page == "contacts"){ ?>lien_selected<? } ?>" src="pictures/contacts.png" />		</a>
			<a id="accueil_b" rel="#accueil"></a>
	</div>
	
	<div id="news">Vous pouvez maintenant accéder à toutes les énigmes diner.</div>
	
	<div id="theEnd" style="position:absolute;left:60px;top:260px;width:630px;text-align:center;font-size:20px;color:white;font-weight:bold;">
		<img id="signature" src="pictures/signature.png" style="display:none;z-index:500;position:absolute;left:435px;top:190px;" />
	</div>
	
	<div id="content">
	
		<div id="bulle" style="position:relative;z-index:20;"></div>
		
		<div id="accueil" class="<? if($page == "accueil"){ ?>article_actif<? } ?>">
			<img alt="Rallye d'hiver 2012" src="pictures/accueil.png" />
			<div class="inside-text">
					Bienvenu <? if($login){if(isset($row['nom'])){echo $row['nom'].' ';}elseif(isset($_COOKIE["_nom_equipe"])){echo $_COOKIE["_nom_equipe"].' ';}} ?>! 					
					Sur ce site, vous pouvez à tout moment consulter les énigmes, les informations importantes et venir débloquer les questionnaires. &Agrave; vous de jouer ! Que souhaitez-vous faire ?<br/><br/>
					
					<table style="margin:0px auto 0px auto;text-align:justify;font-size:16px;" cellpadding="<? if($login){ ?>10<? }else{ ?>20<? } ?>">
						<tr>
						<td valign=top style="width:125px;">
							<a class="lien" rel="#<? if(!$login){ ?>connexion<? }else{ ?>perso<? } ?>" href="#" img="#bouton_2"><? if(!$login){ ?><img alt="" src="pictures/option_connexion.png" style="margin-left:10px;" /><br/>Vous connecter et ainsi accéder à la partie questionnaire et à votre espace perso.<? }else{ ?><img alt="" src="pictures/option_perso.png" style="margin-left:10px;" /><br/><? if($login!=1){ ?>Se rendre sur votre page perso, pour accéder à tout vos questionnaires et au contenu particulier pour votre équipe.<? }else{ ?>Vous rendre sur la zone admin pour avoir un aperçu de l'avancement des équipes et consulter les commentaires.<? }} ?></a>
						</td><td valign=top style="width:155px;">
							<a class="lien" rel="#enigmes" href="#" img="#bouton_5"><img alt="" src="pictures/option_enigme.png" style="margin-left:10px;" /><br/>Voir ou télécharger les énigmes (ou bien le dossier complet).</a>
					<? if($login){ ?>
						</td><td valign=top style="width:143px;">
							<a class="lien" rel="#questionnaires" href="#" img="#bouton_6"><img alt="" src="pictures/option_questionnaire.png" style="margin-left:10px;" /><br/>Tester un mot de passe, et pourquoi pas, débloquer un questionnaire !</div></a>
					<? } ?>
						</td><td valign=top style="width:143px;">
							<? if(false){	/*if(round(rand(1,3)) == 1){*/ ?>
								<a class="lien" rel="#calendrier" href="#" img="#bouton_3"><img alt="" src="pictures/option_calendrier.png" style="margin-left:10px;"/><br/>Consulter le calendrier du Rallye pour avoir un aperçu de toutes dates importantes.</a>
							<? }else{ ?>	
								<a href="doc/rallyes_pour_les_nuls.pdf" target="_blank"><img alt="" src="pictures/option_theory3.png" style="margin-left:10px;"/><br/>Télécharger <i>Les Rallyes pour les Nuls</i>, edition revue et corrigée par JC Janin.</a>
							<? } ?>
						</td>
						</tr>
					</table>
			</div>
		</div>
		
	
		<div id="connexion" class="<? if($page == "connexion"){ ?>article_actif<? } ?>">
			<img alt="" src="pictures/connexion.png"/>
			<div class="inside-text">
			
				<table cellpadding="5"><form name="log" action="index.php" method="post">
					<tr>
						<td>Nom d'utilisateur : </td><td><input type="text" name="login" /></td>
					</tr><tr>
						<td>Mot de passe : </td><td><input type="password" name="pwd" /></td>
						<td><input type="submit" value="Envoyer" /></td>
					</tr>
				</form></table>
				
				<p><? if(isset($message)) echo $message; ?></p>
				
			</div>
		</div>
		
		
		<div id="perso" class="<? if($page == "perso"){ ?>article_actif<? } ?>">
			<? if($login!=1){ ?>
			<img alt="" src="pictures/groupe<? echo $login; ?>.png" style="margin-left:5px;" />
			<? }else{ ?>
			<img alt="" src="pictures/groupe1.png" style="margin-left:5px;" />
			<? } ?>
			<div class="inside-text" style="margin-top:0;">
			
				<? if(!$login){ ?>
				
				<br><span style="text-align: center">Connectez-vous pour accéder à cette page.</span>
					
				<? }else{ ?>
			
				<table cellpadding=5>
					<tr>
						<? if($login!=1){ ?>
							<td><input class="onglet" onglet="#synthese" type="submit" value="Synthèse" style="width:67px;height:18px;" /></td>
							<td><input class="onglet" onglet="#board_fame" type="submit" value="Enigme diner" style="width:88px;height:18px;" /></td>
							<td><input class="onglet" onglet="#board_c" type="submit" value="Donner votre avis" style="width:110px;height:18px;" /></td>
							<td><input class="onglet" onglet="#board_upload" type="submit" value="Envoyer le dossier de réponse" style="width:200px;height:18px;" /></td>
						<? }else{ ?>
							<td><input class="onglet" onglet="#synthese" type="submit" value="Synthèse" style="width:67px;height:18px;" /></td>
							<td><input class="onglet" onglet="#board_c" type="submit" value="Commentaires" style="width:100px;height:18px;" /></td>
							<td><input class="onglet" onglet="#board_log" type="submit" value="Voir les logs" style="width:84px;height:18px;" /></td>
							<td><input class="onglet" onglet="#board_fame" type="submit" value="Hall of fame" style="width:80px;height:18px;" /></td>
							<td><input class="onglet" onglet="#board_upload" type="submit" value="Fichiers uploadés" style="width:120px;height:18px;" /></td>
						<? } ?>
							<td><input type="submit" value="Déconnexion" onclick="acceder('index.php?deco=1');document.location.href='index.php?page=connexion';" style="width:87px;height:18px;" /></td>
					</tr>
				</table>
				
				<? if($login!=1){ 	/*---------------------------- PAGE EQUIPE -------------------------*/ ?>
				
					<div id="msg" style="margin-left:7px;color:#76a7f2;">
						<? if(isset($mdp_ok)){ ?><br/>Votre mot de passe a été changé avec succès.</div>
						<? }elseif(isset($comment_ok)){ ?><br/>Merci pour votre commentaire !<? } ?>
					</div>
					
					<div id="synthese" style="margin-left:7px;text-align:left;">
						<br/>
						<div id="dinerSolved">
							Nous vous donnons rendez-vous au restaurant <font color="#76a7f2"><b>La Crémaillère 1900</b></font>, 15 Place du Tertre, Paris 18ème, pour notre diner de clôture du Rallye le 11 avril.
						</div>
						<br/>
						<? 
							echo '';
							$html = '';
							if($dossierOK == -1){
								$html .= '<div id="count"></div>';
							}else{
								if($dossierOK < 100){
									$html .= '<div id="dossierOK">Nous avons bien reçu';
								}elseif($dossierOK == 100){
									$html .= '<div id="dossierOK">Nous avons bien reçu votre dossier réponse. Merci !</div>';
								}elseif($dossierOK > 100){
									$html .= '<div id="dossierOK">Nous avons bien reçu votre dossier réponse et';
								}
								if($dossierOK%100 == 1){ $html .= ' votre vidéo. Merci !</div>'; }
								if($dossierOK%100 > 1){ $html .= ' vos '.($dossierOK%100).' vidéos. Merci !</div>'; }
							}
							echo $html;
						?>
						
						<ul id="ul"></ul>
					</div>
					
					<div id="board_c" style="margin-left:100px;text-align:left;display:none;">
						<br/>
						<form action="index.php" method="post">
							<textarea name="board" id="board" placeholder="N'hésitez pas à nous laisser des commentaires ici !" style="margin:0px auto 0px auto;"></textarea><br/>
							<input type="submit" value="Envoyer" />
						</form>
					</div>
					
					<div id="board_fame" style="margin-left:7px;text-align:justify;display:none;">
						<br/>
						Notre diner de clôture du Rallye aura lieu le mercredi 11 avril. Pour connaitre le lieu de ce diner, résolvez l'une des 
						cinq énigmes ci-dessous.
							
						<p id="texteDiner" style="text-align:center;">
						<font color="#76a7f2"><b>Vous pouvez maintenant accéder à toutes les énigmes diner.<br/>Cliquez simplement sur une énigme pour la voir ou la télécharger.</b></font>
						</p>
						<br/>
						
						<div id="bonus0" class="bonus bonusOn" rel="0"><a href="#"><img src="pictures/bonus1.png" /></a></div>
						<div id="bonus1" class="bonus bonusOn" rel="1"><a href="#"><img src="pictures/bonus2.png" /></a></div>
						<div id="bonus2" class="bonus bonusOn" rel="2"><a href="#"><img src="pictures/bonus3.png" /></a></div>
						<div id="bonus3" class="bonus bonusOn" rel="3"><a href="#"><img src="pictures/bonus4.png" /></a></div>
						<div id="bonus4" class="bonus bonusOn" rel="4"><a href="#"><img src="pictures/bonus5.png" /></a></div>
						
					</div>
					
					<div id="board_pwd" style="display:none;margin:50px;">
						<form id="new_pwd" action="index.php" method="post">
							<table cellpadding="3" style="border-collapse:collapse;border-style:solid;border-width:1px;border-color:white;">
								<tr><td>Nouveau mot de passe : </td>
									<td></td>
									<td><input id="pwd1" type="password" name="change_pwd1" onKeyUp="check_pwd(this.value, document.getElementById('pwd2').value);" /> </td>
									<td><img alt="" id="img_pwd1" src="pictures/ko.png" />
								</tr>
								<tr><td>Confirmez votre nouveau mot de passe : </td>
									<td></td>
									<td><input id="pwd2" type="password" name="change_pwd2" onKeyUp="check_pwd(document.getElementById('pwd1').value, this.value);" /></td>
									<td><img alt="" id="img_pwd2" src="pictures/ko.png" /></td>
								</tr>
								<tr id="button_pwd" style="display:none;"><td colspan="4" align="center" style="padding:15px;"><input type="submit" name "chg_pwd" value="Valider"/></td></tr>
							</table>
						</form>
					</div>
					
					<div id="board_upload" style="display:none;margin:50px;">
						<form id="dossierForm" method="post" action="upload.php" enctype="multipart/form-data" style="text-align:center;margin:50px auto 0px auto;width:300px;">
							<p id="dossierText" align=justify>Envoyez-nous ici votre dossier réponse ou votre clip vidéo, vous avez jusqu'au 20 mars !</p><br/><br/>
							<input type="hidden" name="MAX_FILE_SIZE" value="2000000000">    
							<input type="file" name="dossier"><br/><br/>
							<input type="submit" value="Envoyer">   
						</form>
					</div>
				
				<? }else{ 	/*---------------------------- PAGE ADMIN -------------------------*/ ?>
				
					<div id="synthese">
							
						<div id="synthese_content" style="width:605px;height:350px;overflow:auto;margin-top:20px;margin-left:-2px;">
							<table cellspacing=2>
								<?	
								foreach($avancement as $cle => $valeur){
									$bob = explode('~', $valeur);
									
									//moche, mais j'ai la flemme de faire mieux ;) à modifier pour améliorer la scalabilité
									if($bob[2] == "D'hiver'di"){ $bob2 = 'hiver'; }else if($bob[2] == "Notes'in Gammes"){ $bob2 = 'gammes'; }else{ $bob2 = htmlentities($bob[2]); }
									while($bob[0][0] == 0){$bob[0] = substr($bob[0], 1);}
									
									echo '<tr>';
									if($bob[27]) 	echo '<td title="dossier de réponse reçu" style="width:4px;border: 1px solid #231924;background-color:#62afff;"></td>';
									else 			echo '<td title="pas de dossier de réponse reçu" style="width:4px;border: 1px solid #231924;">&nbsp;</td>';
									if($bob[28]) 	echo '<td title="vidéo reçue" style="width:4px;border: 1px solid #231924;background-color:#62afff;"></td>';
									else 			echo '<td title="pas de vidéo reçue" style="width:4px;border: 1px solid #231924;">&nbsp;</td>';
									echo '<td style="width:190px;border-top: 1px solid white;"><a href="#" onClick="light(\''.$bob2.'\', '.(int)$bob[1].');return false;" style="opacity:'.$bob[26].';">'.$bob[2].'</a></td>';
									for ($i=3; $i < 24; $i++){
										if($bob[$i] == 'true'){
											echo '<td title="'.$enigmes[$i-3].'" style="width:4px;border: 1px solid #231924;background-color:#62afff;"></td>';
										}else{
											echo '<td title="'.$enigmes[$i-3].'" style="width:4px;border: 1px solid #231924;">&nbsp;</td>';
										}
									}
									if($bob[24] >= 0){
										if($bob[24] > 4){
											echo '<td title="Enigme diner" align=center valign=middle style="width:10px;color:black;border: 1px solid #231924;background-color:#62afff;">'.($bob[24]%5+1).'</td>';
										}else{
											echo '<td title="Enigme diner" align=center valign=middle style="width:10px;border: 1px solid #231924;">'.($bob[24]+1).'</td>';
										}
									}else{
										echo '<td title="Enigme diner (pas encore choisie pour cette équipe ...)" style="width:10px;border: 1px solid #231924;">&nbsp;</td>';
									}
																		
									if($bob[25] > 0){
										echo '<td align=left valign=middle style="font-size:14px;padding-left:10px;border-right: 1px solid #231924;">'.$bob[25].' indices</td>';
									}else{
										echo '<td style="border-right: 1px solid #231924;"></td>';									
									}
									
									echo '<td align=left valign=middle style="font-size:14px;padding-left:10px;" title="Le nombre de points est simplement donné à titre indicatif. Il ne prend pas en compte les questionnaires.">'.$bob[0].' pts</td>';
									
									echo '</tr>';
								} 
								?>
							</table>
						</div>
						
						<!--div style="position:absolute;top:129px;left:86px;font-size:52px;width:132px;text-align:right;" title="somme des avancements de chaque équipe (en %) / nombre d'équipes actives"><? echo $stat[0] ?> %</div>
						<div style="position:absolute;top:183px;left:117px;font-size:12px;" title="somme des avancements de chaque équipe (en %) / nombre d'équipes actives">avancement global</div>
						<div style="position:absolute;top:145px;left:231px;background-color:white;height:50px;width:2px;"></div>
						<div style="position:absolute;top:144px;left:246px;font-size:18px;">Plus une équipe est affichée en clair,</div>
						<div style="position:absolute;top:169px;left:246px;font-size:18px;">plus sa dernière activité sur le site est récente !</div -->
						
					</div>
					
					<div id="board_c" style="display:none;height:340px;overflow:auto;padding-right:10px;margin:20px 7px;">
						<? for ($i = count($com_text)-1; $i >= 0; $i--){ ?>
							<? $date = explode('-', $com_date[$i]); ?>
							<u>Message de l'équipe <b><? echo $com_auteur[$i]; ?></b> du <? echo $date[2].'.'.$date[1].'.'.$date[0]; ?> :</u><br/>
							<p><? echo $com_text[$i]; ?></p>
						<? } ?>
					</div>
					
					<div id="board_log" style="display:none;padding-right:10px;text-align:center;margin-top:20px">
						<a href="log753.php" target="_blank"><font color="#76a7f2">Voir tous les logs</font></a><br/><br/>
						<div id="logScroll" style="overflow:auto;width:536px;height:320px;margin-left:42px;text-align:left;">
							<table>
							<? for ($i = 0; $i < count($log_mdp); $i++){ ?>
								<tr<? if($log_ok[$i] == 1){ ?> style="color:yellow"<? } ?>>
									<td>[<? echo $log_date[$i]; ?>]</td>
									<td style="width:150px;"><? echo $log_equipe[$i]; ?></td>
									<td style="width:100px;overflow:hidden;"><? echo $log_mdp[$i]; ?></td>
									<td>(&eacute;nigme <? echo $log_enigme[$i]; ?>)</td>
								</tr>
							<? } ?>
							<tr><td>...</td><td>...</td><td>...</td><td>...</td></tr>
							</table>
						</div>
					</div>
					
					<div id="board_fame" style="display:none;text-align:left;width:480px;height:350px;overflow:auto;margin-top:20px;margin-left:50px;">
						<table cellpadding=8>
						<tr>
							<td><img src="pictures/star.png"/></td>
							<td><b>Coupe "Lièvre et Tortue" : <font color="#76a7f2"><span id="lievre"></span></font></b><br/><font size=2><span id="lievre2">Démarré le plus tard avec le plus d'énigmes résolues</span></font></td>
							<td></td>
						</tr><tr>
							<td><img src="pictures/star.png"/></td>
							<td><b>Coupe "Aléa" : <font color="#76a7f2"><span id="alea"></span></font></b><br/><font size=2><span id="alea2">Le plus d’essais de mots de passe</span></font></td>
							<td></td>
						</tr><tr>
							<td><img src="pictures/star.png"/></td>
							<td><b>Coupe "One touch" : <font color="#76a7f2"><span id="oneTouch"></span></font></b><br/><font size=2><span id="oneTouch2">Meilleur ratio énigmes résolues/essais de mot de passe</span></font></td>
							<td></td>
						</tr><tr>
							<td><img src="pictures/star.png"/></td>
							<td><b>Coupe "Assisté" : <font color="#76a7f2"><span id="assiste"></span></font></b><br/><font size=2><span id="assiste2">A demandé le plus d'indice</span></font></td>
							<td></td>
						</tr><tr>
							<td><img src="pictures/star.png"/></td>
							<td><b>Coupe "Cycles" : <font color="#76a7f2">Orcades</font></b><br/><font size=2>Le 6 février 2012, à 23h21 et 43 secondes</font></td>
							<td></td>
						</table>
						<div id="calculerCoupes" style="position:absolute;top:214px;left:535px;">
							<input type="submit" value="Calculer" onclick="coupes();" />
						</div>
					</div>
					
					<div id="board_upload" style="display:none;padding-right:10px;text-align:center;margin-top:20px">
						<font color="#76a7f2">Fichiers envoyés par les équipes</font><br/><br/>
						<div id="logScroll" style="overflow:auto;width:604px;height:320px;text-align:left;">
							<table cellspacing=4 style="font-size:14px;">
							<? 	
							if(count($upload) == 0){ echo 'Pas de fichiers pour le moment.'; }
							foreach ($upload as $file){
								$infos = explode('~', $file);
								$link = $infos[0].'~'.$infos[1].'~'.$infos[2];
								echo '<tr><td style="padding:0px 10px;"><a href="upload/'.$link.'"><b>'.$infos[1].'</b></a></td>';
								echo '<td style="padding:0px 10px;width:170px;"><a href="upload/'.$link.'"><i>'.$infos[2].'</i></a></td>';
								echo '<td style="padding:0px 10px;width:125px;"><a href="upload/'.$link.'">(le '.$infos[0].')</a></td>';
								echo '<td style="padding:0px 10px;width:55px;"><a href="upload/'.$link.'">'.$infos[3].'</a></td></tr>';
							} 
							?>
							</table>
						</div>
					</div>
	
				<? } ?>
				
				<? } ?>
								
			</div>
		</div>
		
		<div id="calendrier" class="<? if($page == "calendrier"){ ?>article_actif<? } ?>">
			<img alt="" src="pictures/calendrier.png"/>
			<a href="#" onclick="show_facileajouez('a');"><div class="zone" style="height: 31px; top: 37px; left: 63px; width: 27px;"></div></a>
			<a href="#" onclick="show_facileajouez('d');"><div class="zone" style="left: 164px; height: 43px; top: 27px; width: 30px;"></div></a>
			<div class="inside-text">
				<br/>
				<b>Jeudi 15 décembre 2011</b> : Lancement du Rallye ! Ouverture du site.<br/><br/>
				<b>Mardi 20 mars 2012</b> : Fin du rallye, date limite pour l'envoi des dossiers de réponse.<br/><br/>
				<b>Mercredi 11 avril 2012</b> : Diner de cloture et annonce des résultats.<br/><br/>
			</div>
		</div>
		
		<div id="reglement" class="<? if($page == "reglement"){ ?>article_actif<? } ?>">
			<img alt="" src="pictures/reglement.png" />
			<div id="reglement_content" class="inside-text" style="overflow : auto;height:383px;padding-right:15px;">
				
				Pour télécharger le réglement du Rallye d'hiver 2012, <a href="doc/reglement.pdf"><font color="#76a7f2">cliquez ici</font></a>.<br/><br/>
				<i>Cette année, le rallye d'hiver 2012 vous propose de découvrir un Paris pittoresque à travers le prisme d'une thématique particulière : la musique. 
				En pratique, des équipes de 2 à 7 personnes ont les trois mois d'hiver pour résoudre une quinzaine d'énigmes qui les conduisent sur des lieux en rapport avec le thème du Rallye. 
				Là, les équipes doivent répondre à un questionnaire qui guide leur découverte du lieu. 
				C'est l'occasion de se cultiver en s'amusant, et d'occuper les longues soirées d'hiver et les weekend brumeux !</i><br/>
				<br/>
				<b>Article 1 Objet du règlement</b><br/>
				Ce règlement a pour objet d'informer les concurrents du rallye d'hiver 2012 des modalités de déroulement des épreuves du rallye.<br/>
				Le but du Rallye est de résoudre des énigmes et de visiter des lieux de Paris.<br/>
				La résolution de chaque énigme aboutit à la production d'un mot clé en rapport avec le thème du rallye et la conversion du mot clé en nom du lieu à visiter se fait en proposant sur le site internet du rallye le mot clé que vous avez trouvé. Si le mot clé que vous proposez concorde avec la solution de l'énigme, le nom du lieu à visiter et le questionnaire à remplir lors de la visite vous sont dévoilés. Sachant qu'il y a 10 lieux à visiter, plusieurs énigmes aboutissent aux mêmes lieux.<br/>
				Pour établir le classement final – qui apporte surtout l'identification d'une équipe arrivée en tête et à qui sera proposé le plaisir de construire le rallye de l'année prochaine – la résolution des énigmes et les correctes réponses aux questionnaires remplis lors des visites rapportent des points qui se cumulent.<br/>
				Au cas où vous rencontreriez quelque difficulté pour pénétrer l'esprit des énigmes, vous avez la possibilité de contacter les organisateurs pour solliciter un ou plusieurs indices qui vous mettront sur la voie. Vous l'aurez deviné : la publication d'indices coute quelques points, i.e. si vous résolvez l'énigme avec l'aide d'un indice, vous gagnerez moins de points que si vous la résolvez de manière autonome. Mais vous en gagnerez toujours plus que si vous ne résolvez pas l'énigme, et vous vous amuserez bien plus. Alors n'hésitez pas !<br/>
				<br/>
				<b>Article 2 Les énigmes</b><br/> 
				Les énigmes qui vous sont proposées pourront être traitées dans n'importe quel ordre. Les énigmes sont disponibles sur ce site où elles peuvent être téléchargées ou bien lues directement sur le site. Un envoi papier ou mail est possible pour les équipes qui le demandent vraiment, mais certaines énigmes présentent des images animées ou des sons, et ne sont accessibles (lisibles et téléchargeables) que sur le site.<br/>
				La résolution des énigmes permet d'amener à un lieu de visite. Les énigmes  sont au nombre de vingt mais seuls dix lieux sont à découvrir, ainsi plusieurs énigmes peuvent amener au même lieu (où un seul questionnaire est à remplir). Les dix premières énigmes amènent aux dix lieux.<br/>
				Les vingt énigmes présentent un niveau de difficulté non homogène, les premières énigmes étant les plus simples. Certaine énigmes jugées plus difficiles sont identifiées par une marque. <br/>
				Chaque énigme résolue fournit un mot de passe en rapport avec le thème du rallye (qui peut être le nom d'un lieu ou pas du tout !). Dans tous les cas, chacun des mots de passe correspond à un lieu à visiter <i>(cf Article 5)</i><br/>
				Des indices pour la résolution de chaque énigme sont disponibles auprès de l'équipe d'organisation Terpsichore. La résolution d'une énigme rapporte 100 points, chaque indice coûte 25 points. On comprend aisément qu'il vaut mieux demander un, deux voire trois indices plutôt que de ne pas résoudre l'énigme, et donc ne pas avoir accès au lieu ni au questionnaire correspondant. Toutes les énigmes sont largement déchiffrables grâce aux indices. Chaque demande d'indice devra préciser où l'équipe est arrivée dans la résolution de l'énigme, afin que l'indice fasse vraiment progresser l'équipe (voir Article 10 – Aide).<br/>
				Les énigmes nécessiteront de votre part la plus grande précision possible dans le dossier de réponse quant aux détails de leur résolution.<br/>
				<br/>
				<b>Article 3 Les lieux à visiter</b><br/>
				Les dix lieux à visiter sont situés dans Paris intra-muros, et présentent en majorité un rapport certain avec le thème du rallye.<br/> 
				<br/>
				<b>Article 4 Le site - </b><a href="www.rallyedhiver2012.fr"><font color="#76a7f2">www.rallyedhiver2012.fr</font></a><br/>
				Cette année, grande nouveauté ! Le Rallye dispose d'un site internet. Ce site vous permet :<br/> 
				<ul>
					<li>De consulter ou télécharger les énigmes <i>(cf Article 2)</i> et le règlement du Rallye.</li>
					<li>De débloquer l'accès à un questionnaire lorsque vous avez trouvé le mot de passe correspondant. Ces questionnaires seront à remplir sur les lieux à visiter <i>(cf Article 5)</i>.</li>
					<li>D'accéder à l'espace personnalisé pour chaque équipe, où vous trouverez votre avancement en termes d'énigmes résolues et de questionnaires débloqués, et pourrez laisser des commentaires à l'équipe organisatrice.</li>
				</ul>
				Le site est en accès libre, mais l'espace personnalisé permettant de voir son avancement et de débloquer les questionnaires nécessite une identification initiale avec le nom de l'équipe et un mot de passe.<br/>
				Notez qu'il est indispensable à toutes les équipes de pouvoir accéder au site pour récupérer les questionnaires. Exceptionnellement l'équipe Terpsichore peut envoyer les questionnaires à une équipe qui aurait résolu une énigme mais ne pourrait télécharger le questionnaire correspondant.<br/>
				<br/>
				<b>Article 5 Questionnaires</b><br/>
				<i>« Un esprit sain dans un corps sain »</i>. Pour arriver au bout de ce Rallye, il ne vous suffira donc pas de faire marcher votre intellect, mais également vos jambes ! Pour chaque énigme résolue, le mot de passe vous permettra de débloquer l'accès à un questionnaire que vous devrez remplir en visitant le lieu indiqué. Il y aura en tout dix sites, et donc dix questionnaires (donc il y aura plusieurs énigmes associées au même questionnaire !). Ces dix questionnaires sont accessibles sur le site internet.<br/>
				Pour avoir accès aux questionnaires, vous devez : vous connecter à l'espace perso de votre groupe, puis aller dans l'onglet « Questionnaires ». Là vous proposez le mot de passe issu de la résolution de l'énigme. Il faut entrer un mot unique et en minuscule (et sans accent). Par exemple, si vous avez trouvé "Opéra de Sydney" comme mot de passe, vous pouvez essayer "opera" et "sydney" et seul un des deux marchera.<br/>
				Après avoir proposé un mot de passe, pour éviter que les équipes proposent des mots de passe au hasard, le site vous demandera de préciser à quelle énigme correspond ce mot de passe proposé, et n'autorisera qu'une erreur par tranche de quatre heures. Ce qui signifie que si vous vous trompez de numéro d'énigme avec le bon mot de passe, vous devrez attendre quatre heures avant de reproposer le mot de passe avec le bon numéro d'énigme. Attention donc aux erreurs d'inattention !<br/>
				Chaque questionnaire est noté sur 200 points.<br/>
				Chaque questionnaire précise bien le point de départ de la visite, qui peut correspondre au mot de passe lui-même (Opéra de Sydney, dans l'exemple précédent) ou pas.<br/>
				Lors de la résolution des dix questionnaires, vous verrez sur certains d'entre eux apparaître des indices pour vous diriger vers un onzième lieu, dit "fantôme". Un onzième questionnaire, correspondant à un numéro d'énigme fictif 2A, est à récupérer sur le site pour visiter ce lieu "fantôme". Ce questionnaire est noté sur 100 points.<br/>
				<br/>
				<b>Article 6 Compétition</b><br/>
				Les énigmes et les questionnaires ont été conçus pour permettre aux férus de rallye de se régaler, et aux équipes plus novices de s'amuser pleinement.<br/>
				Certaines équipes se battront naturellement pour être dans le premier quart, c'est-à-dire les dix premières équipes. Celles-ci devront s'attacher à résoudre le maximum d'énigmes, avec si possible le minimum d'indices demandés, et de visiter tous les sites, y compris le site "fantôme".<br/>
				D'autres équipes ne devront pas hésiter à demander des indices pour résoudre les énigmes les plus difficiles, et surtout pour avoir accès aux dix lieux et aux dix questionnaires (+ le site et questionnaire "fantôme").<br/>
				A titre d'épreuve complémentaire et subsidiaire, il est demandé à chaque équipe de réaliser un lip dub, petit film vidéo montrant toute l'équipe chantant une chanson de son invention, sur un air connu, relatant son épopée, l'humour étant de mise, la qualité technique du film étant secondaire. Des points de bonus seront également attribués pour la réalisation de ce film. Naturellement, les droits d'utilisation seront aimablement conférés aux organisateurs pour une éventuelle diffusion lors de l'événement cité à l'article 11.<br/>
				<br/>
				<b>Article 7 Décisions du Jury</b><br/>
				Chaque année, des contestations quant à l'interprétation des énigmes ou les réponses aux questionnaires sont enregistrées. Malgré tous les soins apportés à la clarification des énigmes et à l'élaboration des questionnaires, les organisateurs ne pourront échapper aux revendications.<br/> 
				Sachez que les corrections seront réalisées sans préjugé et dans la plus grande objectivité. En conséquence, les décisions du jury seront, bien sûr, sans appel.<br/>
				<br/>
				<b>Article 8 Déontologie et courtoisie</b><br/>
				L'attention des participants est appelée sur le fait qu'ils doivent témoigner de la plus grande discrétion. Les sites verront se succéder plus de quarante équipes. Si cette année, aucun lieu privé n'est à trouver, certains endroits requièrent une attitude particulière.<br/>
				Comme les organisateurs n'ont pas les moyens de mettre un contrôleur derrière chaque concurrent, ils font confiance aux équipes pour qu'il n'y ait pas de fraude ou de tricherie.<br/>
				<br/>
				<b>Article 9 Envoi des dossiers de réponse</b><br/>
				Les dossiers de réponse devront être envoyés en mail à c.dumas@voila.fr au plus tard le 20 mars 2012 à 23h20 UTC, fin de l'hiver. Le respect de l'ordre des énigmes, des questionnaires et des questions en leur sein est indispensable.<br/>
				Le cas échéant le dossier de réponse peut être envoyé par la poste, au plus tard le 20 mars 2012, cachet de la poste faisant foi.<br/> 
				<p style="margin-left:20px;">
				Adresse d'envoi du dossier :<br/>
				<i>Christophe Dumas, 45 boulevard Gouvion St-Cyr, 75017</i>
				</p>
				La présentation sera appréciée par le jury qui délivrera un prix spécial à cet effet.<br/>
				<br/>
				<b>Article 10 Aide</b><br/>
				Vous aurez peut-être besoin d'aide pour résoudre une énigme. N'hésitez pas à demander des indices à <a href=mailto:"rallyedhiver2012@gmail.com"><font color="#76a7f2">rallyedhiver2012@gmail.com</font></a>.<br/>
				Une décote de 25 points sera appliquée par indice. Mais rappelons qu'une énigme non résolue sera naturellement bien plus coûteuse qu'une aide, même importante, qui aura été sollicitée.<br/>
				Chaque demande d'indice devra préciser où l'équipe est arrivée dans la résolution de l'énigme, afin que l'indice fasse vraiment progresser l'équipe.<br/>
				Si une équipe rencontre un problème internet sur le site, elle peut contacter le webmestre à l'adresse <a href=mailto:"simon@rallyedhiver2012.fr"><font color="#76a7f2">simon@rallyedhiver2012.fr</font></a><br/>
				D'une façon générale, sachez qu'il vous sera possible de contacter les organisateurs par courriel à l'adresse <a href=mailto:"rallyedhiver2012@gmail.com"><font color="#76a7f2">rallyedhiver2012@gmail.com</font></a> ou en téléphonant ou en envoyant un SMS à Marc au 06 07 74 86 38 ou Christophe au  06 13 01 70 67.<br/>
				<br/>
				<b>Article 11 Diner de clôture</b><br/>
				Un dîner de clôture sera organisé le 11 avril pour réunir toutes les équipes et présenter les réponses et résultats. Comme le veut la tradition, ce dîner sera très vivant, émaillé d'anecdotes …<br/>
				
			</div>
		</div>
		
		<div id="enigmes" class="<? if($page == "enigmes"){ ?>article_actif<? } ?>">
			<img alt="" src="pictures/enigmes.png" />
			<a href="#" onclick="show_facileajouez('s');"><div class="zone" style="height: 30px; width: 23px; top: 208px; left: 230px;"></div></a>
			<a href="#" onclick="show_facileajouez('i');"><div class="zone" style="width: 10px; top: 197px; height: 44px; left: 111px;"></div></a>
			<div class="inside-text" style="text-align:left;margin-top:15px;">
			
				<table cellspacing=0 cellpadding=0 style="margin: 0px auto 0px auto;border-collapse:collapse;">
				<tr>
				
				<td class="case_diese"><img alt="" src="pictures/bemol.png" /></td><td></td>
				<td class="case">	<a href="#" onclick="showEnigme(1,1, 133, 30);"><font color="#76a7f2">Opus 1 :</font><br/><font size=3><i>La Visite Amusée</i></font></a>	</td>
				<td></td><td></td>
				<td class="case">	<a href="#" onclick="showEnigme(8,1, 133, 247);"><font color="#76a7f2">Opus 8 :</font><br/><font size=3><i>Broken Tape</i></font></a>		</td>
				<td></td><td class="case_diese"><img alt="" src="pictures/diese.png" /></td>
				<td class="case">	<a href="#" onclick="showEnigme(15,1, 133, 463);"><font color="#76a7f2">Opus 15 :</font><br/><font size=3><i>Cycles</i></font></a>			</td>
				
				</tr>
				<tr>
				
				<td class="case_diese"><img alt="" src="pictures/bemol.png" /></td><td></td>
				<td class="case">	<a href="#" onclick="showEnigme(2,1, 195, 30);"><font color="#76a7f2">Opus 2 :</font><br/><font size=3><i>Les Bottes de Chef-Lieu</i></font></a>	</td>
				<td class="case_diese"><img alt="" src="pictures/diese.png" /></td><td></td>
				<td class="case">	<a href="#" onclick="showEnigme(9,1, 195, 247);"><font color="#76a7f2">Opus 9 :</font><br/><font size=3><i>Dans un Tridacne</i></font></a>			</td>
				<td class="case_diese"><img alt="" src="pictures/diese.png" /></td><td class="case_diese"><img alt="" src="pictures/diese.png" /></td>
				<td class="case">	<a href="#" onclick="showEnigme(16,1, 195, 463);"><font color="#76a7f2">Opus 16 :</font><br/><font size=3><i>La Cigale et la Fourmi</i></font></a>	</td>
				
				</tr>
				<tr>
				
				<td class="case_diese"><img alt="" src="pictures/bemol.png" /></td><td></td>
				<td class="case">	<a href="#" onclick="showEnigme(3,1, 258, 30);"><font color="#76a7f2">Opus 3 :</font><br/><font size=3><i>Strasbourg, 1792</i></font></a>	</td>
				<td></td><td></td>
				<td class="case">	<a href="bof.php"							   ><font color="#76a7f2">Opus 10 :</font><br/><font size=3><i>BOF !</i></font></a>				</td>
				<td></td><td></td>
				<td class="case">	<a href="#" onclick="showEnigme(17,1, 258, 463);"><font color="#76a7f2">Opus 17 :</font><br/><font size=3><i>Orchestre</i></font></a>		</td>
				
				</tr>
				<tr>
				
				<td></td><td></td>
				<td class="case">	<a href="#" onclick="showEnigme(4,1, 322, 30);"><font color="#76a7f2">Opus 4 :</font><br/><font size=3><i>Une Mélodie Internationale</i></font></a>						</td>
				<td></td><td></td>
				<td class="case">	<a href="#" onclick="showEnigme(11,1, 322, 247);"><font color="#76a7f2">Opus 11 :</font><br/><font size=3><i>Tout ce dont tu as<br/>besoin c'est d'amour</i></font></a>	</td>
				<td></td><td class="case_diese"><img alt="" src="pictures/diese.png" /></td>
				<td class="case">	<a href="#" onclick="showEnigme(18,1, 322, 463);"><font color="#76a7f2">Opus 18 :</font><br/><font size=3><i>Ca gaze pour <br/>le grand capitaine !</i></font></a>			</td>
				
				</tr>
				<tr>
				
				<td></td><td></td>
				<td class="case">	<a href="#" onclick="showEnigme(5,1, 384, 30);"><font color="#76a7f2">Opus 5 :</font><br/><font size=3><i>Les Arts Florissants</i></font></a>	</td>
				<td class="case_diese"><img alt="" src="pictures/diese.png" /></td><td></td>
				<td class="case">	<a href="#" onclick="showEnigme(12,1, 384, 247);"><font color="#76a7f2">Opus 12 :</font><br/><font size=3><i>Mode</i></font></a>				</td>
				<td></td><td class="case_diese"><img alt="" src="pictures/diese.png" /></td>
				<td class="case">	<a href="#" onclick="showEnigme(19,1, 384, 463);"><font color="#76a7f2">Opus 19 :</font><br/><font size=3><i>Armide</i></font></a>				</td>
				
				</tr>
				<tr>
				
				<td></td><td></td>
				<td class="case">	<a href="#" onclick="showEnigme(6,1, 448, 30);"><font color="#76a7f2">Opus 6 :</font><br/><font size=3><i>La légende de Joseph</i></font></a>	</td>
				<td></td><td></td>
				<td class="case">	<a href="#" onclick="showEnigme(13,1, 448, 247);"><font color="#76a7f2">Opus 13 :</font><br/><font size=3><i>Facile à Jouez</i></font></a>		</td>
				<td></td><td class="case_diese"><img alt="" src="pictures/diese.png" /></td>
				<td class="case">	<a href="#" onclick="showEnigme(20,1, 448, 463);"><font color="#76a7f2">Opus 20 :</font><br/><font size=3><i>La Tournée du patron</i></font></a></td>
				
				</tr>
				<tr>
				
				<td class="case_diese"><img alt="" src="pictures/diese.png" /></td><td></td>
				<td class="case">	<a href="#" onclick="showEnigme(7,1, 375, 30);"><font color="#76a7f2">Opus 7 :</font><br/><font size=3><i>Les Enfants de Michael</i></font></a>					</td>
				<td></td><td></td>
				<td class="case">	<a href="#" onclick="showEnigme(14,1, 375, 247);"><font color="#76a7f2">Opus 14 :</font><br/><font size=3><i>La Saga des 9</i></font></a>						</td>
				<td></td><td></td>
				<td class="case">	<a href="enigmes_todl/integrale_des_opus.pdf"		 ><font color="#76a7f2"><u>Intégrale des opus :</u></font><br/><font size=3><i>Toutes les énigmes !</i></font></a>	</td>
					
				</tr>
				</table>
				
			
			</div>
		</div>
		
		<div id="questionnaires" class="<? if($page == "questionnaires"){ ?>article_actif<? } ?>">
			<img alt="" src="pictures/questionnaires.png" />
			<a href="#" onclick="show_facileajouez('q');"><div class="zone" style="left: 27px; width: 41px; height: 41px; top: 28px;"></div></a>
			<a href="#" onclick="show_facileajouez('n');"><div class="zone" style="height: 31px; left: 218px; width: 26px; top: 37px;"></div></a>
			<div class="inside-text">
			
				<? if(!$login){ ?>
				
				<span style="text-align: center">Connectez-vous pour accéder aux questionnaires.</span>
				
				<? }else{ ?>
			
				<div id="text1" style="position:relative;margin-left:102px;margin-bottom:30px;width:353px;text-align:justify;">
					Pour accéder au questionnaire relatif à une énigme, entrez ici <span id="several">un mot unique</span> trouvé grâce à cette énigme (lieu ou mot de passe), <span id="min">en minuscule</span> et <span id="accent">sans accent</span>.<br/>
					Exemple : si vous avez trouvé "opéra de Sydney", vous pouvez essayer "opera" et "sydney" et un seul des deux marchera.<br/><span id="vide"></span><br/>
					<b>Vos questionnaires déjà débloqués sont disponibles sur votre page perso.</b>
				</div>
				
				
				<div id="input1" style="position:static;">
					<form id ="input1" name="input1">
						<img alt="" src="pictures/input.png" style="position:relative;z-index:10;left:100px;"/>
						
						<a href="#" onclick="controle1(document.input1.quest.value);">
							<img alt="" src="pictures/input_button.png" style="position:relative;z-index:10;top:-7px;left:-128px;"/>
						</a>
						
						<input type="text" name="quest" size="42" maxlength="40" tabindex="1" style="position:relative;z-index:11;top:-40px;left:117px;"
								onKeyPress="if (event.keyCode == 13) {controle1(document.input1.quest.value);return false;}"/>
					</form>					
				</div>
				
				<div id="text2" style="margin-left:102px;margin-bottom:30px;width:353px;text-align:justify;display:none;">
					Maintenant, entrez le numéro de l'énigme grâce à laquelle vous avez trouvé ce mot de passe. Notez que vous n'avez le droit qu'à un essai toutes les 4 heures pour un mot de passe donné, donc faites attention à entrer le bon numéro !
					<span id="msgNum"></span>
					<form id ="input2" name="input2">
						<img alt="" src="pictures/input2.png" style="position:relative;z-index:10;top:30px;left:122px;"/>
						
						<a href="#" onclick="controle2(document.input2.quest.value);">
							<img alt="" src="pictures/input_button.png" style="position:relative;z-index:12;top:23px;left:63px;"/>
						</a>
						
						<input type="text" name="quest" size="2" maxlength="2" tabindex="2" style="position:relative;z-index:11;top:11px;left:-15px;"
								onKeyPress="if(event.keyCode == 13){controle2(document.input2.quest.value);return false;}"/>
						
						<div style="position:relative;z-index:11;top:50px;left:0px;padding-bottom:30px;"><input type="checkbox"  name="diner"> Cochez cette case s'il s'agit d'une "énigme diner".</div>
						
					</form>
				</div>
				
				<div id="text3" style="margin-top:20px;margin-left:102px;width:353px;text-align:justify;display:none;"></div>
				
				<? } ?>
			
			</div>
		</div>
		
		<div id="contacts" class="<? if($page == "contacts"){ ?>article_actif<? } ?>">
			<img alt="" src="pictures/contacts.png" />
			<a href="#" onclick="show_facileajouez('t');"><div class="zone" style="height: 41px; top: 29px; width: 18px; left: 200px;"></div></a>
			<a href="#" onclick="show_facileajouez('o');"><div class="zone" style="left: 64px; top: 36px; height: 33px; width: 30px;"></div></a>
			<div class="inside-text" style="text-align:left;">
				<div style="width:250px;">
				Pour toute question ou demande d'indices pour les énigmes écrivez à : <a href="mailto:rallyedhiver2012@gmail.com"><font color="#76a7f2">rallyedhiver2012@gmail.com</font></a><br/>
				<br/>
				<br/>
				En cas d'urgence, appelez ou textez : Marc au 06 07 74 86 38 ou Christophe au 06 13 01 70 67
				</div>
				<img alt="" src="pictures/photo_equipe.jpg" style="position:absolute;top:100px;left:310px;" />
				
				<br/>
				<br/>
				Les dossiers complets seront à envoyer avant le 20/03/2012 par mail à <a href="mailto:rallyedhiver2012@gmail.com"><font color="#76a7f2">rallyedhiver2012@gmail.com</font></a>, ou par courrier à :<br/><br/>
				<div style="text-align:center;"><i>Christophe Dumas, 45 boulevard Gouvion St-Cyr, 75017</i></div>
			
			</div>
		</div>
	
	</div>
	
	<div style="width:750px;text-align:center;margin-top:5px;"><a href="mailto:simon@rallyedhiver2012.fr"><font color=#333333 size=3>Pour contacter le webmaster du site, cliquez ici.</font></a></div>
	
	<a href="#" onclick="show_facileajouez('e');"><div class="zone" style="height: 30px; top: 22px; width: 23px; left: 316px;"></div></a>
	<a href="#" onclick="show_facileajouez('p');"><div class="zone" style="height: 50px; top: 15px; width: 25px; left: 353px;"></div></a>
	<a href="#" onclick="show_facileajouez('r');"><div class="zone" style="width: 15px; left: 475px; height: 30px; top: 22px;"></div></a>
	
</div>

</body>
</html>
