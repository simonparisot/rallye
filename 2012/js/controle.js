/* --------------------------------

	controle1 est lancée lorsque l'utilisateur a entré un mot de passe dans la page questionnaires. 
	La fonction vérifie si c'est un mot de passe valide (pas d'accent, pas d'espaces, ...) puis 
	envoie une requète ajax au serveur pour savoir si le mot de passe a été testé il y a moins
	de 4 heures. Si ce n'est pas le cas, on affiche la deuxième page (input pour le numéro d'énigme.
	
	argument :	t -> mot de passe entré par l'utilisateur

-------------------------------- */

function controle1(t){	

	// RAZ de la page avant de réafficher un résultat
	$("#min").html('en minuscule');
	$("#accent").html('sans accent');
	$("#several").html('un mot unique');
	$("#vide").html('');
	$('#msgNum').html('');
	$("input[name='diner']:checked").attr('checked', false);
	document.input2.quest.value = "";
	test_mdp = '';

	var check = true;
	
	// test des consignes. Le mot de passe doit ...
	// ... être en minuscule
	if(t.toLowerCase()!=t){
		$("#min").html('<font color=red><b><u>en minuscule</u></b></font>');
		check = false;
	}
	// ... être sans accent
	if(no_accent(t)!=t){
		$("#accent").html('<font color=red><b><u>sans accent</u></b></font>');
		check = false;
	}
	// ... ne pas être vide ou seulement des espaces
	if(t == "" || t == " " || t == "  " || t == "   "){
		$("#vide").html('<font color=red><b><u>Entrez au moins un mot !</u></b></font><br/>');
		check = false;
	}
	// ... être un seul mot
	else if(t.lastIndexOf(" ") > 0 && t.lastIndexOf(" ") != t.length-1){
		$("#several").html('<font color=red><b><u>un mot unique</u></b></font>');
		check = false;
	}
	// ... ne pas commencer par un espace
	else if(t.indexOf(" ") == 0){
		$("#vide").html('<font color=red><b><u>Sans espace au début ;)</u></b></font><br/>');
		check = false;
	}
	// ... ne pas se terminer par un espace
	else if(t.lastIndexOf(" ") == t.length-1){
		$("#vide").html('<font color=red><b><u>Sans espace à la fin ;)</u></b></font><br/>');
		check = false;
	}
	
	// si les consignes ne sont pas respectées
	if(!check){
	
		// retour à la case départ ! on affiche la première page
		$("#text2").hide();
		$("#text3").hide();
		$("#text1").show();
	
	// si les consignes sont respectées	
	}else{
	
		// on cache tout
		$("#text1").hide();
		$("#text2").hide();
		// on affiche temporairement une image de chargement
		$("#text3").html('<div style="margin-top:50px;margin-left:170px;"><img src="pictures/load.gif" /></div>').show();

		// on envoie le mot de passe au serveur en ajax
		var ok = acceder("controle.php?mdp="+t);
		
		// on analyse la réponse
		if(ok == 'loginfail'){
		
			// l'utilisateur n'est pas loggé, retour à la page de connexion
			document.location.href="index.php?page=connexion&message=loginfail";
			
		}else if(ok){
		
			// le mot de passe n'a pas été testé il y a moins de 4 heures
			// on le stocke dans la variable globale "test_mdp"
			test_mdp = t;
			// on cache l'image de chargement
			$("#text3").hide();
			// on la deuxième page 
			$('#text1').fadeOut('1', function(){ $("#text2").show(); });
			
		}else{
		
			// le mot de passe a déjà été testé il y a moins de 4 heures
			$("#text3").html("<i>Désolé, vous avez déjà essayé ce mot de passe. Il y a un délai de 4 heures entre deux essais successifs pour un même mot de passe.<br><br></i>");
		
		}	
	}
}



/* --------------------------------

	controle2 est lancée lorsque l'utilisateur a entré un numéro d'énigme correspondant
	au mot de passe testé. La fonction vérifie si c'est un numéro valide puis envoie une
	requète ajax au serveur pour savoir si le couple mot de passe/numéro d'énigme est valide.
	Dans ce cas, on affiche une page de résultat, avec un message perso et le lien vers 
	le questionnaire. Dans le cas contraire, on affiche un message "de mauvais mot de passe".
	
	argument :	y -> numéro d'énigme entré par l'utilisateur

-------------------------------- */
	
function controle2(y){	

	// petite RAZ avant affichage
	$('#msgNum').html('');
	
	//on transforme 2A en 21 et diner en 22
	var num = (y=="2A" || y=="2a")?21:y;
	var num = (num=="diner")?22:num;
	
	//on vérifie l'input (que ce soit un nombre et qu'il ne soit pas vide)
	if(isNaN(num) || num == ''){
		$('#msgNum').html('<br/><br/><font color=red><b>Ce numéro d\'énigme n\'est pas valide</b></font>');
	}else{
	
		// on parse l'input en integer
		num = parseInt(num);
		
		// on cache tout
		$("#text1").hide();
		$("#text2").hide();
		// on affiche temporairement une image de chargement
		$("#text3").html('<div style="margin-top:50px;margin-left:170px;"><img src="pictures/load.gif" /></div>').show();
		
		// on envoie le mot de passe et le numéro d'énigme au serveur en ajax
		var ok = acceder("controle.php?t="+test_mdp+"&y="+num+"&new="+test_mdp);
		
		// on analyse la réponse du serveur
		if(ok == 'loginfail'){
		
			// l'utilisateur n'est pas loggé, retour à la page de connexion
			document.location.href="index.php?page=connexion&message=loginfail";
			
		}else{
		
			// on parse la réponse du serveur
			var result = ok.split('~');
			
			if(result[0] == 'true'){
			
				// si le mot de passe est bon et le numéro d'énigme correspond, on construit puis on affiche la page de réponse
				// 		result[0] => boolean pour savoir si le mot de passe est bon et correspond au numéro d'énigme
				// 		result[1] => nom du fichier pdf
				// 		result[2] => Lieu du questionnaire débloqué
				// 		result[3] => Lieu du questionnaire débloqué (sous une autre forme)
				// 		result[4] => Court paragraphe/phrase de félicitation
				if(num != 22){
					var html = result[4]+' Le questionnaire correspondant vous emmènera <b><font color="#76a7f2">'+result[2]+'</font></b>. Ce questionnaire apparaitra maintenant sur votre page perso.<br><br><table cellspacing=0 cellpadding=4 style="margin-left:30px;">';
					html = html + '<tr><td><a href="quest_tosee/'+result[1]+'.pdf" target="_blank"><img src="pictures/eye.png" style="margin-right:15px;margin-left:8px;"/></a></td><td><a href="quest_tosee/'+result[1]+'.pdf" target="_blank"><font size=4><i>Voir le questionnaire</i></font></td></a></tr>';
					html = html + '<tr><td><a href="quest_todl/'+result[1]+'.pdf"><img src="pictures/dl.png" style="margin-right:15px;"/></a></td><td><a href="quest_todl/'+result[1]+'.pdf"><font size=4><i>Télécharger le questionnaire</i></font></td></a></tr></table><br>';
					html = html + 'N\'hésitez pas à nous donner votre avis sur cette énigme <a class="lien onglet" rel="#perso" onglet="#board_c" img="#bouton_2" href="#"><font color="#76a7f2"><b>en cliquant ici</b></font></a>. Merci !';
				
					// si on est pas admin
					if(!admin){
						// si l'énigme n'est pas déjà dans "quest_deblo" (questionnaire déjà débloqués), on envoie l'énigme au serveur (pour l'enregitrer comme débloqué)
						if(quest_deblo[num-1][0] != result[1]){
							acceder("controle.php?store="+result[1]+"&lieu="+result[3]+"&y="+num);
						}
						// on stocke les infos dans "quest_deblo" et "lieu_deblo", pour l'affichage dans la page perso
						quest_deblo[num-1] = result[1];
						lieu_deblo[num-1] = result[3];
						
						// on affiche les questionnaires débloqués sur la page perso
						show_quest_deblo();
					}
				}else{
					var html = '<img src="pictures/denier.jpg" /><br/><br/>Bravo ! Nous vous donnons donc rendez-vous <font color="#76a7f2"><b>au restaurant '+result[2]+'</b></font>, '+result[3]+'. Vous trouverez plus d\'information sur <a href="'+result[1]+'"><font color="#76a7f2"><b>leur site internet</b></font></a>.';
				}
				
				// on efface la page précédente et on affiche la page de résultat
				$("#input1").hide();
				$("#text3").html(html);
			
			}else{
			
				// si le mot de passe ou le numéro d'énigme n'est pas valide on affiche ce qui a été testé et le message renvoyé par le serveur
				// 		result[0] => boolean pour savoir si le mot de passe est bon et correspond au numéro d'énigme
				// 		result[1] => message de "mauvais mot de passe"
				$("#text3").html('Vous avez testé <b>'+test_mdp+'</b> pour l\'énigme <b>'+y+'</b>.<br/><br/><i>'+result[1]+'</i>');
				
			}
			
			// on enlève ce qui est stocké dans la variable globale "test_mdp"
			test_mdp = '';
		}
	}
}