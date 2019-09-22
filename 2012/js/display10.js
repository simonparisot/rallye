function changer_page(lien){

	showEnigme(bulle, 0);													// on fait disparaitre les éventuelles infobulles de énigme
	
		if(lien.attr('img')){												// si le bouton cliqué a un attribut image, on transfère à l'image la classe "lien_selected"
			$('.lien_selected').removeClass('lien_selected');
			$(lien.attr('img')).addClass('lien_selected');
		}else{																// sinon on transfère "lien_selected" à l'image enfant du bouton cliqué
			$('.lien_selected').removeClass('lien_selected');   
			lien.children('img').addClass('lien_selected');
		}
	
	var article_id = lien.attr('rel'); 										// on récupère l'id de la page à afficher
	
	$('.article_actif').fadeOut('100', function(){ 							// on fait disparaitre la page courante
		
		try{																// on fait une RAZ de toutes les pages avant d'afficher la nouvelle.
			$("#min").html('en minuscule');
			$("#accent").html('sans accent');
			$("#several").html('un mot unique');
			$("#vide").html('');
			document.input1.quest.value = "";
			document.input2.quest.value = "";
			$("#input1").show();
			$("#text1").show();
			$("#text2").hide();
			$("#text3").hide();
			$('#msgNum').html('');
            $("input[name='diner']:checked").attr('checked', false);
			change_pwd(false, document.getElementById("button_chang_pwd"));
		}catch(err){}

		$(this).removeClass('article_actif');  								// on transfère la class "article_actif" à la nouvelle page
		$(article_id).addClass('article_actif'); 
		
		$('#content').fadeTo(500, 1);
		$('.article_actif').fadeTo('0', 0.85); 							// et enfin, on affiche la nouvelle page !
	});
}

function changer_onglet(lien){

	var article_id = lien.attr('onglet'); 		// on récupère l'id de l'onglet à afficher
	$('#synthese').hide();						// on cache tout les onglets
	$('#board_c').hide();
	$('#board_log').hide();
	$('#board_fame').hide();
	$('#board_pwd').hide();
	$('#board_upload').hide();
	$('#board_stat').hide();
	$('#board_res').hide();
	$('#msg').hide();
	$(article_id).fadeTo('50', 1);				// on affiche juste le bon
}

function showEnigme(i, sens, top, left){
	if(sens == 1) {
		if(bulle>0){showEnigme(bulle, 0);}
		
		var file = (i==8)?'opus'+i+'.mp3':'opus'+i+'.pdf';
		var html = '<div class="bulle" id="bulle'+i+'" style="top:'+top+'px;left:'+left+'px;color:white;"><table cellspacing=0 cellpadding=4>';
		html = html + '<tr><td><a href="enigmes_tosee/'+file+'" target="_blank"><img src="pictures/eye.png" style="margin-right:15px;margin-left:8px;"/></a></td><td><a href="enigmes_tosee/'+file+'" target="_blank"><font size=3><i>Voir l\'énigme</i></font></td></a></tr>';
		html = html + '<tr><td><a href="enigmes_todl/'+file+'"><img src="pictures/dl.png" style="margin-right:15px;"/></a></td><td><a href="enigmes_todl/'+file+'"><font size=3><i>Télécharger l\'énigme</i></font></td></a></tr></table>';
		html = html + '<a href="#" onclick="showEnigme('+i+',0);"><img src="pictures/close.png" style="position:absolute;top:2px;left:215px;"/></a></div>';
		document.getElementById("bulle").innerHTML = html;
		$('#bulle'+i).fadeTo('50', 0.95);
		bulle = i;				
	}else{
		$('#bulle'+i).fadeOut('20');
		bulle = 0;
	}
}

function show_quest_deblo(){
	var inner = '';
	var temp = new Array();
	for(i=0; i<quest_deblo.length; i++){
		if(quest_deblo[i]){
			var doublon = false;
			for(j=0; j<temp.length; j++){
				if(temp[j][0] == quest_deblo[i]){	//si on a trouvé un doublon
					doublon = true;
					temp[j][3] = i+1;
					break;
				}
			}
			if(!doublon){
				var l = temp.length;
				temp[l] = new Array();
				temp[l][0] = quest_deblo[i];
				temp[l][1] = lieu_deblo[i];
				temp[l][2] = i+1;
			}
		}
	}
	for(i=0; i<temp.length; i++){
		inner += '<li><a href="quest_todl/'+temp[i][0]+'.pdf">'+temp[i][1]+' <i>(énigme n°'+temp[i][2];
		if(temp[i][3]){
			inner += ' et n°'+temp[i][3];
		}
		inner += ')</i></a></li>';
	}
	
	document.getElementById("ul").innerHTML = inner;
	var restant = 10-temp.length;
	switch(restant){
		case 10:
			var count = "<br>Vos questionnaires débloqués s'afficheront ici.";
			break;
		case 0:
			var count = "Vous avez débloqué tous les questionnaires ... quoique ce n'est pas si sûr, en cherchant bien !";
			break;
		case -1:
			var count = "Bien joué ! Vous avez réellement débloqué tous les questionnaires !<br>Les avez-vous résolus ?";
			break;
		default:
			var count = "Voici vos questionnaires débloqués. Il vous en reste "+restant+" à débloquer !";
			break;
	}
	document.getElementById("count").innerHTML = count;
}

function show_facileajouez(x){
	if(!x){
		$('#paper_text').html('');
		$('#paper').fadeOut('100');
	}else{
		$('#paper').fadeTo('100', 1)
		$('#paper_text').html($('#paper_text').html()+x);
		if($('#paper_text').html() == 'piano'){
			document.location.href="piano.html";
		}
	}
}

function bonusOn(x){
	x = parseInt(x);
	switch(x){ 
		case 0: 
		var file = 'opus_diner_1_46ef5.pdf'; break; 
		case 1: 
		var file = 'opus_diner_2_ek53r.pdf'; break; 
		case 2: 
		var file = 'opus_diner_3_g75h6.pdf'; break;
		case 3: 
		var file = 'opus_diner_4_cr6i5.pdf'; break;
		case 4: 
		var file = 'opus_diner_5_k8fh7.pdf'; break;
	}
	$('#indicationDiner').hide();
	for(i=1; i<=4; i++){ bonusOff((x+i)%5);	}
	$("#bonus"+x).removeClass('bonusOn').animate(
		{ height: '100px'}, 
		500, 
		function() {
			var html = $("#bonus"+x).html();
			html += '<div class="bonusInfo" style="padding:0px;">';
			html += '<table cellspacing=0 cellpadding=4 style="margin-left:70px;text-align:left;">';
			html += '<tr><td><a href="enigmes_tosee/'+file+'" target="_blank"><img src="pictures/eye.png" style="margin-right:15px;margin-left:8px;"/></a></td><td><a href="enigmes_tosee/'+file+'" target="_blank"><font size=3><i>Voir l\'énigme</i></font></a></td></tr>';
			html += '<tr><td><a href="enigmes_todl/'+file+'"><img src="pictures/dl.png" style="margin-right:15px;"/></a></td><td><a href="enigmes_todl/'+file+'"><font size=3><i>Télécharger l\'énigme</i></font></a></td></tr></table></div>';			
			$("#bonus"+x).html(html)
		}
	);
}

function bonusOff(x){
	x = parseInt(x);
	if(nav()==7)$('.bonusInfo').hide();
	$("#bonus"+x).addClass('bonusOn').animate(
		{ height: '23px'}, 
		500, 
		function() {
			$("#bonus"+x).html('<a href="#"><img src="pictures/bonus'+(x+1)+'.png" /></a>');
		}
	);
}

function bonusSelect(x){
	x = parseInt(x);
	if(confirm('Êtes-vous sûr de votre choix ? Attention, vous ne pourrez plus accéder aux autres énigmes.')){
		var ok = acceder("bonus.php?x="+x);
		if(ok == 'loginfail'){
			document.location.href="index.php?page=connexion&message=loginfail";
		}else{
			var file = ok.split('~');
			if(file[0] == 'false'){
				
				
				
			}else if(file[0] == 'true'){
						
				var y1 = (x+1)%5, y2 = (x+2)%5, y3 = (x+3)%5, y4 = (x+4)%5;
				
				$("#bonus"+y1).removeClass('bonusOn').html('<img src="pictures/bonus'+(y1+1)+'.png" />').fadeTo('50', 0.2, function(){
				$("#bonus"+y2).removeClass('bonusOn').html('<img src="pictures/bonus'+(y2+1)+'.png" />').fadeTo('50', 0.2, function(){
				$("#bonus"+y3).removeClass('bonusOn').html('<img src="pictures/bonus'+(y3+1)+'.png" />').fadeTo('50', 0.2, function(){
				$("#bonus"+y4).removeClass('bonusOn').html('<img src="pictures/bonus'+(y4+1)+'.png" />').fadeTo('50', 0.2, function(){
				$(".bonusInfo").fadeTo('50', 0, function(){
					var html = '<table cellspacing=0 cellpadding=4 style="margin-left:70px;text-align:left;">';
					html += '<tr><td><a href="enigmes_tosee/'+file[1]+'" target="_blank"><img src="pictures/eye.png" style="margin-right:15px;margin-left:8px;"/></a></td><td><a href="enigmes_tosee/'+file[1]+'" target="_blank"><font size=3><i>Voir l\'énigme</i></font></a></td></tr>';
					html += '<tr><td><a href="enigmes_todl/'+file[1]+'"><img src="pictures/dl.png" style="margin-right:15px;"/></a></td><td><a href="enigmes_todl/'+file[1]+'"><font size=3><i>Télécharger l\'énigme</i></font></a></td></tr></table>';
					$(".bonusInfo").html(html).css('padding', '0px').css('width', '340px').fadeTo('50', 1, function(){
						html = 'Vous avez jusqu\'au <font color="#76a7f2"><b>20 Mars</b></font> pour résoudre cette énigme. A cette date, le lieu du diner sera dévoilé à toutes les équipes. ';
						html +=	'Comme pour les autres énigmes, testez vos mot de passe dans la partie <i>Questionnaires</i> du site. ';
						html +=	'Attention à bien <font color="#76a7f2"><b>tester le nom entier</b></font> du restaurant que vous trouverez !';
						$("#texteDiner").fadeTo('50', 0, function(){
							$("#texteDiner").html(html).fadeTo('1000', 1);
						});
					});
				});
				});
				});
				});
				});
				
			}else{
				
			}
		}
	}
}

function check_pwd(pwd1, pwd2){
	if(pwd1.length >= 2){
		$("#img_pwd1").attr("src", "pictures/ok.png");
		if(pwd1 == pwd2){
			$("#img_pwd2").attr("src", "pictures/ok.png");
			$("#button_pwd").fadeTo('50', 1);
		}else{
			$("#img_pwd2").attr("src", "pictures/ko.png");
			$("#button_pwd").hide();
		}
	}else{
		$("#img_pwd1").attr("src", "pictures/ko.png");
		$("#img_pwd2").attr("src", "pictures/ko.png");
		$("#button_pwd").hide();
	}
}

function rebour(){
	var nu = new Date;
	nu = nu.getTime();
	var framtid = new Date(2012, 2, 20, 23, 20);
	framtid = framtid.getTime();
	var total = Math.floor((framtid-nu)/1000);
	var day = Math.floor(total/(24*3600));
	var hours = Math.floor((total-day*24*3600)/3600);
	var min = Math.floor((total-day*24*3600-hours*3600)/60);
	var sec = Math.floor(total-day*24*3600-hours*3600-min*60);
	
	if(hours > 2){
		$('#news').html('Merci pour tous vos dossiers et vidéos, nous vous donnons rendez-vous le 11 avril !');
	}else{
	
		var html = '';
		if(hours != 0) html += hours+' heures, ';
		if(min != 0) html += min+' minutes et ';
		html += sec+' secondes'
		
		$('#car').html(html);
		$('#car_cal').html(html);
		if(hours == 0 && min == 0 && sec == 0) theEnd();
		else setTimeout("rebour()", 1000);
	}
}

function load(){
	var size = acceder("upload_size.php?bob");
	$('#dossierText').html('<b>Envoi en cours ...</b><br/>'+size+' envoyés.');
	setTimeout("load()", 3000)
}

function coupes(){
	var result = acceder('coupes.php?nimda');
	result = result.split('<br>');
	var alea = result[0].split('/');
	var oneTouch = result[1].split('/');
	var lievre = result[2].split('/');
	var assiste = result[3].split('/');
	$('#lievre').html(lievre[0]);
	$('#lievre2').html(' ('+lievre[1]+' énigmes résolues en '+lievre[2]+' jours)');
	$('#alea').html(alea[0]);
	$('#alea2').html(' ('+alea[1]+' mots de passe testés)');
	$('#oneTouch').html(oneTouch[0]);
	$('#oneTouch2').html(' ('+oneTouch[1]+' énigmes résolues pour '+oneTouch[2]+' mots de passe testés)');
	$('#assiste').html(assiste[0]);
	$('#assiste2').html(' ('+assiste[1]+' indices demandés)');
	$('#calculerCoupes').hide();
}