<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Rallye d'hiver 2012</title>
	<link rel="stylesheet" media="screen" type="text/css" title="style" href="style.css" />
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="rsh/json2007.js"></script>
	<script type="text/javascript" src="rsh/rsh.compressed.js"></script>
	<script type="text/javascript">
		var rawIndex = 1;
		
		window.dhtmlHistory.create();
		window.onload = function(){
				dhtmlHistory.initialize();
				dhtmlHistory.addListener(historyChange);
		};
		
		var historyChange = function(index, page) {
			if(page!=null){
				// alert(index+page);
				var a = page + '_b';
				changer_page($(a));
				rawIndex--;
			}
		}
		
		function addHistory(index, page){
				// alert(index+page);
				dhtmlHistory.add(index,page);
				rawIndex++;
		}
	</script>
	<script type="text/javascript" src="js/fade.js"></script>
	<script type="text/javascript" src="js/trucs.js"></script>
	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-27051659-1']);
	  _gaq.push(['_trackPageview']);

	  (function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>
	<script type="text/javascript">
		
		var bulle = 0;
		
		//récupération des questionnaires débloqués
		var quest_deblo = new Array();
		var lieu_deblo = new Array();
		
		<? 
			if(isset($data)){
				foreach($data as $cle => $valeur){
					if($valeur){
						$bob = explode('~', $valeur);
						echo 'quest_deblo['.$cle.'] = "'.$bob[0].'";';
						echo 'lieu_deblo['.$cle.'] = "'.$bob[1].'";';
						$quest_debloques = true;
					}else{
						echo 'quest_deblo['.$cle.'] = false;';
						echo 'lieu_deblo['.$cle.'] = false;';
					}
				}
			}
		?>
		
		$(document).ready(function(){		
			var bg = Math.floor(1+2*Math.random());
			document.getElementById("content").style.backgroundImage = 'url("pictures/background'+bg+'.jpg")';
			show_quest_deblo();
		});
	</script>
	
</head>

<body>

<img id="paper" src="pictures/paper.png" style="position:absolute;top:-50px;left:0;" onClick="zone();" />
<div id="paper_text" style="position:absolute;top:3px;left:3px;width:20px;"></div>

<div id="page">

	<script type="text/javascript">
		if(nav()<7){
			document.write('<div id="iewarning"><b>La version de votre navigateur (Internet Explorer '+nav()+') n\'est plus à jour et n\'est pas capable d\'afficher ce site correctement.<br/>Nous vous invitons à installer un navigateur récent comme <a href="http://www.mozilla-europe.org/fr/">Firefox</a>.<b></div>')
		}
	</script>
	
	<div id="logo"></div>
	
	<div id="menu">
		<? if(!$login){ ?>
			<a id="connexion_b" class="lien" rel="#connexion" href="#">				<img id="bouton_0" class="bouton" src="pictures/connexion.png" />		</a>
		<? }else{ ?>
			<a id="perso_b" class="lien" rel="#perso" href="#">						<img id="bouton_0" class="bouton" src="pictures/groupe.png" />			</a>
		<? } ?>
			<a id="calendrier_b" class="lien" rel="#calendrier" href="#">			<img id="bouton_1" class="bouton" src="pictures/calendrier.png" />		</a>
			<a id="reglement_b" class="lien" rel="#reglement" href="#">				<img id="bouton_2" class="bouton" src="pictures/reglement.png" />		</a>
			<a id="enigmes_b" class="lien" rel="#enigmes" href="#">					<img id="bouton_3" class="bouton" src="pictures/enigmes.png" />			</a>
			<a id="questionnaires_b" class="lien" rel="#questionnaires" href="#">	<img id="bouton_4" class="bouton" src="pictures/questionnaires.png" />	</a>
			<a id="contacts_b" class="lien" rel="#contacts" href="#">				<img id="bouton_5" class="bouton" src="pictures/contacts.png" />		</a>
			<a id="accueil_b" rel="#accueil"></a>
	</div>
	
	<div id="news"><b>News</b> : 26 novembre 2011 : Pas mal de modifs et mises à jour ;)</div>
	
	<div id="content">
	
		<div id="bulle" style="position:relative;z-index:20;"></div>
		
		
		<div id="accueil" class="<? if($page == "accueil"){ ?>article_actif<? } ?>">
			<img src="pictures/accueil.png"/>
			<div id="inside-text">
					Bienvenu <? if(isset($_COOKIE['id'])) echo $_COOKIE['nom'].' '; ?>! Que souhaitez-vous faire ?<br/><br/>
					
					<table style="margin:0px auto 0px auto;font-size:14px;" cellpadding="<? if($login){ ?>10<? }else{ ?>20<? } ?>">
						<tr>
						<td valign=top style="width:142px;text-align:justify;">
							<a class="lien" rel="#<? if(!$login){ ?>connexion<? }else{ ?>perso<? } ?>" href="#" img="#bouton_0"><? if(!$login){ ?><img src="pictures/option_connexion.png" style="margin-left:10px;" /><br>Vous connecter, pour ainsi accéder à la partie questionnaire et à votre espace perso.<? }else{ ?><img src="pictures/option_perso.png" style="margin-left:10px;" /><br><? if($login!=1){ ?>Vous rendre sur votre page personnelle, pour voir vos questionnaires débloqués et visualiser votre avancement.<? }else{ ?>Vous rendre sur la zone admin pour avoir un aperçu de l'avancement des équipes.<? }} ?></a>
						</td><td valign=top style="width:155px;text-align:justify;">
							<a class="lien" rel="#enigmes" href="#" img="#bouton_3"><img src="pictures/option_enigme.png" style="margin-left:10px;" /><br>Visualiser ou télécharger les énigmes (et le dossier complet).</a>
					<? if($login){ ?>
						</td><td valign=top style="width:143px;text-align:justify;">
							<a class="lien" rel="#questionnaires" href="#" img="#bouton_4"><img src="pictures/option_questionnaire.png" style="margin-left:10px;" /><br>Tester un mot de passe, et peut être débloquer un questionnaire !</div></a>
					<? } ?>
						</td><td valign=top style="width:143px;text-align:justify;">
							<a class="lien" rel="#calendrier" href="#" img="#bouton_1"><img src="pictures/option_calendrier.png" style="margin-left:10px;"/><br>Consulter le calendrier du Rallye pour avoir un aperçu de toutes dates importantes.</a>
						</td>
						</tr>
					</table>
			</div>
		</div>
		
	
		<div id="connexion" class="<? if($page == "connexion"){ ?>article_actif<? } ?>">
			<img src="pictures/connexion.png"/>
			<div id="inside-text">
			
				<table cellpadding="5"><form name="log" action="index.php" method="post">
					<tr>
						<td>Nom d'utilisateur : </td><td><input type="text" name="login" /></td>
					</tr><tr>
						<td>Mot de passe : </td><td><input type="password" name="pwd" /></td>
						<td><input type="submit" value="Envoyer" /></td>
					</tr>
				</form></table>
				
				<p><? if(isset($message)) echo $message; ?></p>
				<p><i>Pour l'instant, utilisez le login "admin" avec le mot de passe "123" !</i></p>
				
			</div>
		</div>
		
		
		<div id="perso" class="<? if($page == "perso"){ ?>article_actif<? } ?>">
			<img src="pictures/groupe<? echo $login; ?>.png"/>
			<img src="pictures/option_perso.png" style="position:absolute;top:6px;left:520px;"/>
			<div id="inside-text">
			
				<table cellpadding=5>
					<tr>
						<? if($login!=1){ ?><td><input id="button_chang_pwd" type="submit" value="Changer de mot de passe" onClick="change_pwd(true, this);"/></td><? } ?>
						<td><input type="submit" value="Déconnexion" onClick="acceder('index.php?deco=1');document.location.href='index.php?page=connexion';" /></td>
					</tr>
				</table>
				<? if($login==1){ ?><div style="display:none;"><? } ?>
				<? if(isset($mdp_ok)){ ?> <font color="#76a7f2">Votre mot de passe a été changé avec succès.</font><br> <? } ?>
				
				<div id="change_pwd">
				<form id="new_pwd" action="index.php" method="post">
					<table cellpadding="3" style="border-collapse:collapse;border-style:solid;border-width:1px;border-color:white;">
						<tr><td>Nouveau mot de passe : </td><td></td><td>
							<input id="pwd1" type="password" name="change_pwd1" onKeyUp="check_pwd(this.value, document.getElementById('pwd2').value);" />
						</td><td><img id="img_pwd1" src="pictures/ko.png" /></td><td colspan="2"></td></tr>
						<tr><td>Confirmez votre nouveau mot de passe : </td><td></td><td>
							<input id="pwd2" type="password" name="change_pwd2" onKeyUp="check_pwd(document.getElementById('pwd1').value, this.value);" />
						</td><td><img id="img_pwd2" src="pictures/ko.png" /></td><td></td><td id="button_pwd"></td></tr>
					</table>
				</form>
				</div>
				<br>
				<div id="count"></div>
				<br>
				
				<? if(isset($quest_debloques)){ ?>
				<div style="height: 250px;overflow: auto;">
					Vos questionnaires débloqués :<br>
				<? }else{ ?>
					<div>
					<i>Vos questionnaires débloqués s'afficheront ici !</i><br>
				<? } ?>
					<ul id="ul"></ul>
				</div>
				
			<? if($login==1){ ?>
				</div>
				<br>
				Synthèse de l'avancement des équipes :<br><br>
				<div style="height:300px;overflow:auto;">
					<table cellspacing=2>
						<tr><td style="width:230px;"><b>Equipe</b></td><td colspan=20><b>Avancement</b></td></tr>
						<?	
						foreach($avancement as $cle => $valeur){
							$bob = explode('~', $valeur);
							echo '<tr><td style="border-top: 1px solid white;">'.$bob[1].'</td>';
							for ($i=2; $i < 22; $i++){
								if($bob[$i] == 'true'){
									echo '<td style="width:4px;border: 1px solid #231924;background-color:#62afff;"></td>';
								}else{
									echo '<td style="width:4px;border: 1px solid #231924;">&nbsp;</td>';
								}
							}
							echo '</tr>';
						} 
						?>
					</table>
				</div>
	
			<? } ?>
								
			</div>
		</div>
		
		<div id="calendrier" class="<? if($page == "calendrier"){ ?>article_actif<? } ?>">
			<img src="pictures/calendrier.png"/>
			<a href="#" onClick="zone('a');"><div class="zone" style="height: 31px; top: 37px; left: 63px; width: 27px;"></div></a>
			<a href="#" onClick="zone('d');"><div class="zone" style="left: 164px; height: 43px; top: 27px; width: 30px;"></div></a>
			<div id="inside-text">
				<ul>
					<li><b>Jeudi 15 décembre 2011</b> : Lancement du Rallye ! Ouverture du site.</li><br/>
					<li><b>Vendredi 21 mars 2012</b> : Fin du rallye, date limite pour l'envoi des dossiers de réponse.</li><br/>
					<li><b>Mi-avril 2012 (avant les vacances de Pâques)</b> : Diner de cloture et annonce des résultats.</li><br/>
				</ul>
			</div>
		</div>
		
		<div id="reglement" class="<? if($page == "reglement"){ ?>article_actif<? } ?>">
			<img src="pictures/reglement.png" />
			<div id="inside-text" style="overflow : auto;height:400px;padding-right:15px;">
				<!--
				En attendant de placer ici le réglement du rallye d'hiver 2012, vous pouvez accéder aux documents relatifs à la de préparation du rallye (compte rendu des réunions, logo, etc.)<br/>
				<ul>
					<li><a href="http://www.rallyedhiver2012.fr/invitation/">Invitation (22.10.2011)</a></li>
					<li><a href="doc/reglement_6.11.doc">Règlement du rallye - à modifier (06.11.2011)</a></li>
					<li><a href="doc/plan_travail_8.11.doc">Plan de travail (08.11.2011)</a></li>
					<li><a href="doc/logo.jpg">Logo <i>Terpsichore</i></a></li>
				</ul-->
				Pour télécharger le réglement du Rallye d'hiver 2012, <a href="doc/reglement_26.11.doc"><font color="#76a7f2">cliquez ici</font></a>.
				<br>
				<br>
				<b>Article 1 Objet du règlement</b><br>
				Ce règlement a pour objet de mettre les concurrents du rallye d’hiver 2012 au courant de ce qu’il y a à faire pour participer aux épreuves du rallye.
				<br>
				<br>
				<b>Article 2 Les énigmes </b><br>
				Les énigmes qui vous sont proposées pourront être traitées dans n’importe quel ordre. Elles sont au nombre de 20 et permettent de découvrir, pour
				chacune, des lieux différents. Seuls dix lieux sont à découvrir, ainsi plusieurs énigmes peuvent amener aux mêmes lieux (où un seul questionnaire
				est à remplir). Chaque résolution d'énigme apporte 100 points.<br>
				Les énigmes sont disponibles sur le site <a href="www.rallyedhiver2012.fr"><font color="#76a7f2">www.rallyedhiver2012.fr</font></a> où elles peuvent
				être téléchargées ou bien lues directement sur le site.<br>
				Elles présenteront un niveau de difficulté non homogène, les premières énigmes étant les plus simples. Les énigmes nécessiteront de votre part la
				plus grande précision possible dans le dossier de réponse quant aux détails qui vous ont mis sur la voie. <br>
				Chaque énigme résolue fournie un mot de passe en rapport avec le thème du rallye (qui peut être le nom d’un lieu ou pas du tout !). Dans tous les cas,
				chacun des mots de passe correspond à un lieu à visiter <i>(voir Article 5 – Questionnaires)</i><br>
				Des indices pour la résolution de chaque énigme sont disponibles auprès de l'équipe d'organisation Terpsichore. La résolution d'une énigme rapporte 100 points, chaque indice coûte 20 points. On comprend aisément qu'il vaut mieux demander un voire deux indices plutôt que de ne pas résoudre l'énigme, et donc ne pas avoir accès au lieu ni au questionnaire correspondant.
				<br>
				<br>
				<b>Article 3 Les lieux à visiter</b><br>
				Tous les lieux à visiter sont situés dans Paris intra-muros, et présentent en majorité un rapport certain avec le thème du rallye. 
				<br>
				<br>
				<b>Article 4 Le site - </b><a href="www.rallyedhiver2012.fr"><font color="#76a7f2">www.rallyedhiver2012.fr</font></a><br>
				Cette année, grande nouveauté ! Le Rallye dispose d’un site internet, accessible à l’adresse www.rallyedhiver2012.fr. Ce site vous permet : <br>
				<ul>
				<li>De consulter ou télécharger les énigmes et les documents officiels du Rallye (comme le présent règlement) ainsi qu’un planning.</li>
				<li>De débloquer l’accès à un questionnaire lorsque vous avez trouvé le mot de passe correspondant. Ces questionnaires seront à remplir sur les lieux
				à visiter <i>(voir Article 5 – Questionnaires)</i>.</li>
				<li>D’accéder à l’espace personnalisé pour chaque équipe, où vous trouverez votre avancement en termes d'énigmes résolues et de questionnaires
				débloqués.</li></ul>
				Le site est en accès libre, mais l'espace personnalisé pour voir son avancement et débloquer les questionnaires nécessite une identification initiale
				avec le nom de l'équipe et un mot de passe. Notez qu’il est indispensable à toutes les équipes de pouvoir accéder au site pour récupérer les
				questionnaires.
				<br>
				<br>
				<b>Article 5 Questionnaires</b><br>
				« Un esprit sain dans un corps sain » disait-il. Pour arriver au bout de ce Rallye, il ne vous suffira donc pas de faire marcher votre intellect,
				mais également vos jambes ! Pour chaque énigme résolue, le mot de passe vous permettra de débloquer un questionnaire que vous devrez remplir en
				visitant le lieu indiqué. Il y aura en tout dix questionnaires (donc pour ceux qui suivent, il y aura bien plusieurs énigmes associées au même
				questionnaire !). Ces dix questionnaires sont accessibles sur le site internet. <br>
				Pour avoir accès aux questionnaires, vous devez : vous connecter à l’espace perso de votre groupe, puis aller dans l’onglet <i>« Questionnaires »</i>.
				Là vous proposez le mot de passe issu de la résolution de l'énigme. Il faut entrer un mot unique et en minuscule. Par exemple, si vous avez trouvé
				"opéra de Sydney" comme mot de passe, vous pouvez essayer "opera" et "sydney" et un seul des deux marchera.<br>
				Après avoir proposé un mot de passe, pour éviter que les équipes propose des mots de passe au hasard, le site vous demandera de préciser à quelle
				énigme correspond ce mot de passe proposé, et n'autorisera qu'une erreur par tranche de quatre heures. Ce qui signifie que si vous vous trompez de
				numéro d’énigme, vous devrez attendre quatre heures avant d’en proposer un nouveau. Attention donc aux erreurs d’inattention !<br>
				Chaque questionnaire est noté sur 200 points.<br>
				Comme d’habitude, la première question ne devrait pas prendre en défaut votre sagacité légendaire.
				<br>
				<br>
				<b>Article 6 Décisions Du Jury</b><br>
				Chaque année, des contestations quant à l’interprétation des énigmes ou les réponses aux questionnaires sont enregistrées. Malgré tous les soins 
				apportés à la clarification des énigmes et à l’élaboration des questionnaires, les organisateurs ne pourront échapper aux revendications. <br>
				Sachez que les corrections seront réalisées sans préjugé et dans la plus grande objectivité. En conséquence, les décisions du jury seront, bien sûr,
				sans appel.
				<br>
				<br>
				<b>Article 7 Déontologie</b><br>
				L’attention des participants est appelée sur le fait qu’ils doivent témoigner de la plus grande discrétion. Si cette année, aucun lieu privé n’est
				à trouver, certains endroits requièrent une attitude particulière.<br>
				Comme les organisateurs n’ont pas les moyens de mettre un contrôleur derrière chaque concurrent, ils font confiance aux équipes pour qu’il n’y ait
				pas de fraude ou de tricherie.
				<br>
				<br>
				<b>Article 8 Envoi des dossiers de réponse</b><br>
				Les dossiers de réponse, uniquement sous forme papier, devront parvenir à l’adresse ci-dessous pour le vendredi 15 avril au plus tard, le cachet de
				la Poste faisant foi.<br>
				Chaque dossier devra comporter :
				<ul>
				<li>le nom de l’équipe</li>
				<li>les noms et prénoms des membres de l’équipe</li></ul>
				Enfin, le respect de l’ordre des énigmes et des questions est indispensable.<br>
				La présentation sera appréciée par le jury qui délivrera un prix spécial à cet effet.<br>
				Adresse d’envoi du dossier :<br>
				Christophe Dumas<br>
				45 boulevard Gouvion St-Cyr<br>
				75017 PARIS
				<br>
				<br>
				<b>Article 9 Aide</b><br>
				Vous aurez peut-être besoin d’aide pour résoudre une énigme. Sachez qu’il vous sera possible de contacter les organisateurs en laissant un courriel
				à <a href=mailto:"rallyedhiver2012@gmail.com"><font color="#76a7f2">rallyedhiver2012@gmail.com</font></a> ou
				<a href=mailto:"darmon.marc@numericable.fr"><font color="#76a7f2">darmon.marc@numericable.fr</font></a> ou en téléphonant ou en envoyant un SMS à
				Marc au 06 07 74 86 38 ou Christophe au 06 13 01 70 67.<br>
				Une décote de 25 points sera appliquée. Rappelons qu’une énigme non résolue sera naturellement plus coûteuse qu’une aide, même importante, qui aura
				été sollicitée.
				<br>
				<br>
				<b>Article 10 Diner de clôture</b><br>
				Un dîner de clôture sera organisé en avril pour réunir toutes les équipes et présenter les réponses et résultats. Comme le veut la tradition,
				ce dîner sera très vivant, émaillé d'anecdotes…
				<br>
				<br>
				<b>Article 11 Conclusion</b><br>
				Ce rallye qui  est un rallye par correspondance (précision utile pour les nouveaux venus) porte le millésime 2012. C’est une évidence, il y en aura
				un autre en 2013. Les organisateurs se feront un plaisir de passer le flambeau à l’équipe qui aura remporté la présente édition. Si ce passage de
				témoin s’avère difficile, sinon impossible, les équipes classées deuxième ou troisième seront sollicitées. Non, la flamme ne s’éteindra pas !
				
			</div>
		</div>
		
		<div id="enigmes" class="<? if($page == "enigmes"){ ?>article_actif<? } ?>">
			<img src="pictures/enigmes.png" />
			<a href="#" onClick="zone('s');"><div class="zone" style="height: 30px; width: 23px; top: 208px; left: 230px;"></div></a>
			<a href="#" onClick="zone('i');"><div class="zone" style="width: 10px; top: 197px; height: 44px; left: 111px;"></div></a>
			<div id="inside-text" style="text-align:left;margin-top:15px;">
			
				<table cellspacing=0 cellpadding=0 style="margin: 0px auto 0px auto;border-collapse:collapse;">
				<tr>
				
				<td></td>
				<td class="case">	<a href="#" onClick="showEnigme(1,1, 133, 30);"><font color="#76a7f2">Opus 1 :</font><br/><font size=3><i>La Visite Amusée</i></font></a>	</td>
				<td></td>
				<td class="case">	<a href="#" onClick="showEnigme(8,1, 133, 247);"><font color="#76a7f2">Opus 8 :</font><br/><font size=3><i>Broken Tape</i></font></a>		</td>
				<td class="case_diese"><img src="pictures/diese.png"></td>
				<td class="case">	<a href="#" onClick="showEnigme(15,1, 133, 463);"><font color="#76a7f2">Opus 15 :</font><br/><font size=3><i>Cycles</i></font></a>			</td>
				
				</tr>
				<tr>
				
				<td></td>
				<td class="case">	<a href="#" onClick="showEnigme(2,1, 195, 30);"><font color="#76a7f2">Opus 2 :</font><br/><font size=3><i>Les Bottes de Chef-Lieu</i></font></a>	</td>
				<td></td>
				<td class="case">	<a href="#" onClick="showEnigme(9,1, 195, 247);"><font color="#76a7f2">Opus 9 :</font><br/><font size=3><i>Dans un Tridacne</i></font></a>			</td>
				<td class="case_diese"><img src="pictures/diese.png"></td>
				<td class="case">	<a href="#" onClick="showEnigme(16,1, 195, 463);"><font color="#76a7f2">Opus 16 :</font><br/><font size=3><i>La Cigale et la Fourmi</i></font></a>	</td>
				
				</tr>
				<tr>
				
				<td></td>
				<td class="case">	<a href="#" onClick="showEnigme(3,1, 258, 30);"><font color="#76a7f2">Opus 3 :</font><br/><font size=3><i>Strasbourg, 1792</i></font></a>	</td>
				<td></td>
				<td class="case">	<a href="bof.php"							   ><font color="#76a7f2">Opus 10 :</font><br/><font size=3><i>BOF !</i></font></a>				</td>
				<td class="case_diese"><img src="pictures/diese.png"></td>
				<td class="case">	<a href="#" onClick="showEnigme(17,1, 258, 463);"><font color="#76a7f2">Opus 17 :</font><br/><font size=3><i>Orchestre</i></font></a>		</td>
				
				</tr>
				<tr>
				
				<td></td>
				<td class="case">	<a href="#" onClick="showEnigme(4,1, 322, 30);"><font color="#76a7f2">Opus 4 :</font><br/><font size=3><i>Une Mélodie Internationale</i></font></a>						</td>
				<td class="case_diese"><img src="pictures/diese.png"></td>
				<td class="case">	<a href="#" onClick="showEnigme(11,1, 322, 247);"><font color="#76a7f2">Opus 11 :</font><br/><font size=3><i>Tout ce dont tu as<br>besoin c'est d'amour</i></font></a>	</td>
				<td class="case_diese"><img src="pictures/diese.png"></td>
				<td class="case">	<a href="#" onClick="showEnigme(18,1, 322, 463);"><font color="#76a7f2">Opus 18 :</font><br/><font size=3><i>Ca gaze pour <br>le grand capitaine !</i></font></a>			</td>
				
				</tr>
				<tr>
				
				<td></td>
				<td class="case">	<a href="#" onClick="showEnigme(5,1, 384, 30);"><font color="#76a7f2">Opus 5 :</font><br/><font size=3><i>Les Arts Florissants</i></font></a>	</td>
				<td class="case_diese"><img src="pictures/diese.png"></td>
				<td class="case">	<a href="#" onClick="showEnigme(12,1, 384, 247);"><font color="#76a7f2">Opus 12 :</font><br/><font size=3><i>Mode</i></font></a>				</td>
				<td class="case_diese"><img src="pictures/diese.png"></td>
				<td class="case">	<a href="#" onClick="showEnigme(19,1, 384, 463);"><font color="#76a7f2">Opus 19 :</font><br/><font size=3><i>Armide</i></font></a>				</td>
				
				</tr>
				<tr>
				
				<td></td>
				<td class="case">	<a href="#" onClick="showEnigme(6,1, 448, 30);"><font color="#76a7f2">Opus 6 :</font><br/><font size=3><i>La légende de Joseph</i></font></a>	</td>
				<td class="case_diese"><img src="pictures/diese.png"></td>
				<td class="case">	<a href="#" onClick="showEnigme(13,1, 448, 247);"><font color="#76a7f2">Opus 13 :</font><br/><font size=3><i>Facile à Jouez</i></font></a>		</td>
				<td class="case_diese"><img src="pictures/diese.png"></td>
				<td class="case">	<a href="#" onClick="showEnigme(20,1, 448, 463);"><font color="#76a7f2">Opus 20 :</font><br/><font size=3><i>La Tournée du patron</i></font></a></td>
				
				</tr>
				<tr>
				
				<td></td>
				<td class="case">	<a href="#" onClick="showEnigme(7,1, 375, 30);"><font color="#76a7f2">Opus 7 :</font><br/><font size=3><i>Les Enfants de Michael</i></font></a>					</td>
				<td class="case_diese"><img src="pictures/diese.png"></td>
				<td class="case">	<a href="#" onClick="showEnigme(14,1, 375, 247);"><font color="#76a7f2">Opus 14 :</font><br/><font size=3><i>La Saga des 9</i></font></a>						</td>
				<td></td>
				<td class="case">	<a href="enigmes_todl/integrale_des_opus.pdf"		 ><font color="#76a7f2">Intégrale des opus :</font><br/><font size=3><i>Toutes les énigmes !</i></font></a>	</td>
					
				</tr>
				</table>
				
			
			</div>
		</div>
		
		<div id="questionnaires" class="<? if($page == "questionnaires"){ ?>article_actif<? } ?>">
			<img src="pictures/questionnaires.png" />
			<a href="#" onClick="zone('q');"><div class="zone" style="left: 27px; width: 41px; height: 41px; top: 28px;"></div></a>
			<a href="#" onClick="zone('n');"><div class="zone" style="height: 31px; left: 218px; width: 26px; top: 37px;"></div></a>
			<div id="inside-text">
			
				<? if(!$login){ ?>
				
				<span style="text-align: center">Connectez-vous pour accéder aux questionnaires.</span>
				
				<? }else{ ?>
			
				<div id="text1" style="position:relative;margin-left:102px;margin-bottom:30px;width:353px;text-align:justify;">
					Pour accéder au questionnaire relatif à une énigme, entrez ici un mot unique trouvé grâce à cette énigme (lieu ou mot de passe), <span id="min">en minuscule</span> et <span id="accent">sans accent</span>.<br/>
					Exemple : si vous avez trouvé "opéra de Sydney", vous pouvez essayer "opera" et "sydney" et un seul des deux marchera.<br><br>
					<b>Vos questionnaires déjà débloqués sont disponibles sur votre page perso.</b>
				</div>
				
				
				<div style="position:static;">
					<form id ="input1" name="input1">
						<img src="pictures/input.png" style="position:relative;z-index:10;left:100px;"/>
						
						<a href="#" onClick="controle1(document.input1.quest.value);">
							<img src="pictures/input_button.png" style="position:relative;z-index:10;top:-7px;left:-128px;"/>
						</a>
						
						<input type="text" name="quest" size="42" maxlength="40" tabindex="1" style="position:relative;z-index:11;top:-38px;left:117px;"
								onKeyPress="if (event.keyCode == 13) {controle1(document.input1.quest.value);return false;}"/>
					</form>					
				</div>
				
				<div id="text2" style="margin-left:102px;margin-bottom:30px;width:353px;text-align:justify;display:none;">
					Maintenant, entrez le numéro de l'énigme grâce à laquelle vous avez trouvé ce mot de passe. Notez que vous n'avez le droit qu'à un essai par jour pour un mot de passe donné, donc faites attention à entrer le bon numéro !
	
					<form id ="input2" name="input2">
						<img src="pictures/input2.png" style="position:relative;z-index:10;top:30px;left:122px;"/>
						
						<a href="#" onClick="controle2(document.input1.quest.value, document.input2.quest.value);">
							<img src="pictures/input_button.png" style="position:relative;z-index:12;top:23px;left:63px;"/>
						</a>
						
						<input type="text" name="quest" size="2" maxlength="2" tabindex="2" style="position:relative;z-index:11;top:11px;left:-15px;"
								onKeyPress="if(event.keyCode == 13){controle2(document.input1.quest.value, document.input2.quest.value);return false;}"/>
					</form>
				</div>
				
				<div id="text3" style="margin-top:20px;margin-left:102px;margin-bottom:30px;width:353px;text-align:justify;display:none;"></div>
				
				<? } ?>
			
			</div>
		</div>
		
		<div id="contacts" class="<? if($page == "contacts"){ ?>article_actif<? } ?>">
			<img src="pictures/contacts.png" />
			<a href="#" onClick="zone('t');"><div class="zone" style="height: 41px; top: 29px; width: 18px; left: 200px;"></div></a>
			<a href="#" onClick="zone('o');"><div class="zone" style="left: 64px; top: 36px; height: 33px; width: 30px;"></div></a>
			<div id="inside-text">
			
				Pour toute question ou demande d'indices pour les énigmes écrivez à : <a href="mailto:rallyedhiver2012@gmail.com"><font color="#76a7f2">rallyedhiver2012@gmail.com</font></a><br>
				<br>
				En cas d'urgence, appelez ou textez : Marc au 06 07 74 86 38 ou Christophe au 06 13 01 70 67<br>
				<br>
				<br>
				Les dossiers complets seront à envoyer avant le 30/03/2012 par mail à <a href="mailto:rallyedhiver2012@gmail.com"><font color="#76a7f2">rallyedhiver2012@gmail.com</font></a>, ou par courrier à <i>Christophe Dumas, 45 boulevard Gouvion St-Cyr, 75017</i><br>

			
			</div>
		</div>
	
	</div>
	
	<a href="#" onClick="zone('e');"><div class="zone" style="height: 30px; top: 22px; width: 23px; left: 316px;"></div></a>
	<a href="#" onClick="zone('p');"><div class="zone" style="height: 50px; top: 15px; width: 25px; left: 353px;"></div></a>
	<a href="#" onClick="zone('r');"><div class="zone" style="width: 15px; left: 475px; height: 30px; top: 22px;"></div></a>
	
</div>

</body>
</html>
