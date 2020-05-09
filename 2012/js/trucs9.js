function controle1(t){	

	// RAZ de la page avant de réafficher un résultat
	document.getElementById("min").innerHTML = 'en minuscule';
	document.getElementById("accent").innerHTML = 'sans accent';
	document.getElementById("several").innerHTML = 'un mot unique';
	document.getElementById("vide").innerHTML = '';
	$('#msgNum').html('');
	document.input2.quest.value = "";
	test_mdp = '';

	var check = true;
	//test des consignes (minuscules & accents)
	if(t.toLowerCase()!=t){
		document.getElementById("min").innerHTML = '<font color=red><b><u>en minuscule</u></b></font>';
		check = false;
	}
	if(no_accent(t)!=t){
		document.getElementById("accent").innerHTML = '<font color=red><b><u>sans accent</u></b></font>';
		check = false;
	}
	if(t == "" || t == " " || t == "  " || t == "   "){
		document.getElementById("vide").innerHTML = '<font color=red><b><u>Entrez au moins un mot !</u></b></font><br/>';
		check = false;
	}
	else if(t.lastIndexOf(" ") > 0 && t.lastIndexOf(" ") != t.length-1){
		document.getElementById("several").innerHTML = '<font color=red><b><u>un mot unique</u></b></font>';
		check = false;
	}
	else if(t.indexOf(" ") == 0){
		document.getElementById("vide").innerHTML = '<font color=red><b><u>Sans espace au début ;)</u></b></font><br/>';
		check = false;
	}
	else if(t.lastIndexOf(" ") == t.length-1){
		document.getElementById("vide").innerHTML = '<font color=red><b><u>Sans espace à la fin ;)</u></b></font><br/>';
		check = false;
	}
	
	if(check){
	
		document.getElementById("text3").innerHTML = '<div style="margin-top:50px;margin-left:170px;"><img src="pictures/load.gif" /></div>';
		cacher("text1");
		cacher("text2");
		montrer("text3");

		var ok = acceder("controle.php?mdp="+t);
		if(ok == 'loginfail'){
			document.location.href="index.php?page=connexion&message=loginfail";
		}else if(ok){
			test_mdp = t;
			cacher("text3");
			$('#text1').fadeOut('1', function(){
				montrer("text2");
			});
			
		}else{
			document.getElementById("text3").innerHTML = "<i>Désolé, vous avez déjà essayé ce mot de passe. Il y a un délai de 4 heures entre deux essais successifs pour un même mot de passe.<br><br></i>";
		}
		
	}else{
	
		cacher("text2");
		cacher("text3");
		montrer("text1");
		
	}
}
	
function controle2(y){	

	$('#msgNum').html('');
	
	//on transforme 2A en 21
	var num = (y=="2A" || y=="2a")?21:y;
	
	//on vérifie l'input
	if(isNaN(num) || num == ''){
		$('#msgNum').html('<br/><br/><font color=red><b>Ce numéro d\'énigme n\'est pas valide</b></font>');
	}else{
		num = parseInt(num);
		
		$("#text3").html('<div style="margin-top:50px;margin-left:170px;"><img src="pictures/load.gif" /></div>');
		cacher("text1");
		cacher("text2");
		montrer("text3");
		
		//test si le mot de passe est valide
		var ok = acceder("controle.php?t="+test_mdp+"&y="+num+"&new="+test_mdp);
		if(ok == 'loginfail'){
			document.location.href="index.php?page=connexion&message=loginfail";
		}else{
			var result = ok.split('~');
			
			// si le mot de passe est valide on affiche les liens vers le questionnaire associé
			if(result[0] == 'true'){
				var html = result[4]+' Le questionnaire correspondant vous emmènera <b><font color="#76a7f2">'+result[2]+'</font></b>.<br>Ce questionnaire apparaitra maintenant sur votre page perso.<br><br><table cellspacing=0 cellpadding=4 style="margin-left:30px;">';
				html = html + '<tr><td><a href="quest_tosee/'+result[1]+'.pdf" target="_blank"><img src="pictures/eye.png" style="margin-right:15px;margin-left:8px;"/></a></td><td><a href="quest_tosee/'+result[1]+'.pdf" target="_blank"><font size=4><i>Voir le questionnaire</i></font></td></a></tr>';
				html = html + '<tr><td><a href="quest_todl/'+result[1]+'.pdf"><img src="pictures/dl.png" style="margin-right:15px;"/></a></td><td><a href="quest_todl/'+result[1]+'.pdf"><font size=4><i>Télécharger le questionnaire</i></font></td></a></tr></table><br>';
				html = html + 'N\'hésitez pas à nous donner votre avis sur cette énigme <a onclick="show_perso(0);changer_page($(\'#perso_b\'));" href="#"><font color="#76a7f2"><b>en cliquant ici</b></font></a>. Merci !';
				
				if(quest_deblo[num-1][0] != result[1]){
					acceder("controle.php?store="+result[1]+"&lieu="+result[3]+"&y="+num);
				}
				quest_deblo[num-1] = result[1];
				lieu_deblo[num-1] = result[3];
				
				if(!admin)show_quest_deblo();
				
				cacher("input1");
				$("#text3").html(html);
			
			// si le mot de passe n'est pas valide on affiche le message stocké dans 'ok'
			}else{
				$("#text3").html('Vous avez testé <b>'+test_mdp+'</b> pour l\'énigme <b>'+num+'</b>.<br/><br/><i>'+result[1]+'</i>');
			}
			test_mdp = '';
		}
	}
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
	/*var restant = 10-temp.length;
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
	document.getElementById("count").innerHTML = count;*/
}

function zone(x){
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

function acceder(file){
	var xhr_object = null;
	
	if(window.XMLHttpRequest){ 			// Firefox
		xhr_object = new XMLHttpRequest();
	}else if(window.ActiveXObject){		// Internet Explorer
		xhr_object = new ActiveXObject("Microsoft.XMLHTTP");
	}else{ 								// XMLHttpRequest non supporté par le navigateur
	   return "XMLHttpRequest non supportée";
	}
	
	file += '&' + (new Date()).getTime();
	xhr_object.open("GET", file, false);
	xhr_object.send(null);
	return xhr_object.responseText;
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

function bonusOn(x){
	x = parseInt(x);
	for(i=1; i<=4; i++){ bonusOff((x+i)%5);	}
	$("#bonus"+x).removeClass('bonusOn').animate(
		{ height: '100px'}, 
		500, 
		function() {
			var html = $("#bonus"+x).html();
			html += '<div class="bonusInfo">Difficulté : <font color="#76a7f2"><b>'+(x+1)+'</b></font>';
			html += '<br/>Valeur en point : <font color="#76a7f2"><b>'+(x+1)*20+' pts</b></font>';
			html += '<a href="#" class="bonusSelect" rel="'+x+'"><img src="pictures/choose.png" title="Choisir cette énigme" style="position:absolute;top:19px;left:203px;"/></a><div>';
			$("#bonus"+x).html(html);
		}
	);
}

function bonusOff(x){
	x = parseInt(x);
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
	if(confirm('Êtes-vous sûr de votre choix ? Attention, vous ne pourrez plus accéder au deux autres énigmes.')){
		//var ok = acceder("bonus.php?x="+x);
		var ok = 'true~coming-soon';
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
									var html = '<table cellspacing=0 cellpadding=4 style="margin-left:26px;text-align:left;">';
									html += '<tr><td><a href="enigmes_tosee/'+file[1]+'" target="_blank"><img src="pictures/eye.png" style="margin-right:15px;margin-left:8px;"/></a></td><td><a href="enigmes_tosee/'+file[1]+'" target="_blank"><font size=3><i>Voir l\'énigme</i></font></a></td></tr>';
									html += '<tr><td><a href="enigmes_todl/'+file[1]+'"><img src="pictures/dl.png" style="margin-right:15px;"/></a></td><td><a href="enigmes_todl/'+file[1]+'"><font size=3><i>Télécharger l\'énigme</i></font></a></td></tr></table>';
									$(".bonusInfo").html(html).css('padding', '0px').fadeTo('50', 1);
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
	
	$('#car').html(day+' jours, '+hours+' heures, '+min+' minutes et '+sec+' secondes');
	setTimeout("rebour()", 1000)
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

function isTouchDevice(){
	try{
		document.createEvent("TouchEvent");
		return true;
	}catch(e){
		return false;
	}
}
		
function touchScroll(id){
	if(isTouchDevice()){ //if touch events exist...
		var el=document.getElementById(id);
		var scrollStartPos=0;

		document.getElementById(id).addEventListener("touchstart", function(event) {
			scrollStartPos=this.scrollTop+event.touches[0].pageY;
			event.preventDefault();
		},false);

		document.getElementById(id).addEventListener("touchmove", function(event) {
			this.scrollTop=scrollStartPos-event.touches[0].pageY;
			event.preventDefault();
		},false);
	}
}

function nav(){
	var detect = navigator.userAgent.toLowerCase();
	
	if (detect.indexOf('safari')+1){
		return 200;
	}else if (detect.indexOf('msie')+1){
		var ua = navigator.userAgent;
		var version = ua.split('MSIE ');
		return version[1].charAt(0);
	}else{
		return 100;
	}
}

function montrer(quoi){
	document.getElementById(quoi).style.display = "block";
}

function cacher(quoi){
	document.getElementById(quoi).style.display = "none";
}

function no_accent (my_string) {
	var new_string = "";
	var pattern_accent = new Array("é", "è", "ê", "ë", "ç", "à", "â", "ä", "î", "ï", "ù", "ô", "ó", "ö");
	var pattern_replace_accent = new Array("e", "e", "e", "e", "c", "a", "a", "a", "i", "i", "u", "o", "o", "o");
	if (my_string && my_string!= "") {
		new_string = preg_replace (pattern_accent, pattern_replace_accent, my_string);
	}
	return new_string;
}

function preg_replace (array_pattern, array_pattern_replace, my_string)  {
	var new_string = String (my_string);
	for (i=0; i<array_pattern.length; i++) {
		var reg_exp= RegExp(array_pattern[i], "gi");
		var val_to_replace = array_pattern_replace[i];
		new_string = new_string.replace (reg_exp, val_to_replace);
	}
	return new_string;
}
