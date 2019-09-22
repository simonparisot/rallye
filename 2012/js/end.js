function theEnd(){
	$('.article_actif').fadeOut(2000, function(){
		$('#content').fadeTo(2000, 0.2, function(){
		
			$('.article_actif').removeClass('article_actif'); 
			$('#theEnd').addClass('article_actif');
		
			var text = 'L\'hiver est fini ... et ce Rallye s\'achève avec lui.';
			var text2 = 'Vous avez '+enigmes+' énigmes résolues pour '+indices+' indices demandés.';
			var text3 = 'Nous vous donnons rendez-vous le 11 avril pour faire le décompte et connaître les résultats !';
			if(nav()<=7){
				$('#theEnd').html(text+'<br/><br/>'+text2+'<br/><br/>'+text3);
				$('#theEnd').html(text+'<br/><br/>'+text2+'<br/><br/>'+text3);
				$('#signature').fadeTo(5000, 1);
			}else{
				ecrire(text, text2, text3, 0);
			}
		});
	});
}

function ecrire(bob, bob2, bob3, x){
	var end = $('#theEnd').html();
	end += bob[x];	
	$('#theEnd').html(end);
	if(x!=bob.length-1){
		if(bob[x] == '.') jitter = 600;
		if(bob[x] == '!') jitter = 2000;
		else var jitter = 50+200*Math.random();
		setTimeout('ecrire("'+bob+'", "'+bob2+'", "'+bob3+'", '+(x+1)+')', jitter);
	}else if(bob2 != 0){
		var end = $('#theEnd').html();
		end += '<br/><br/>';	
		$('#theEnd').html(end);
		setTimeout('ecrire("'+bob2+'", "'+bob3+'", 0, 0)', 1000);
	}else{
		$('#signature').fadeTo(5000, 1);
	}
}