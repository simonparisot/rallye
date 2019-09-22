$(document).ready(function(){
	
	$('.article_actif').fadeTo('100', 0.85);								// lorsque le site est chargé, on affiche la première page
	
	if(nav()==100)addHistory(rawIndex, '#'+$('.article_actif').attr('id'));	// si on est pas sur safari ni sur IE, on enregistre la première page dans l'historique
	
	$('.lien').live('click', function(event){ 								// lors d'un clic sur une class "lien" ...
		if(nav()==100)addHistory(rawIndex, $(this).attr('rel'));				// si on est pas sur safari ni sur IE, on enregistre la page dans l'historique
		changer_page($(this), event);										// puis on change de page
    });
	
});

function changer_page(lien, evt){

	if(evt)evt.preventDefault();											// on empèche le comportement par défaut (lancement du href)

	showEnigme(bulle, 0);													// on fait disparaitre les éventuelles infobulles de énigme
	
		if(lien.attr('img')){												// si le bouton cliqué a un attribut image, on transfère à l'image la classe "lien_selected"
			$(lien.attr('img')).addClass('lien_selected');
		}else{																// sinon on transfère "lien_selected" à l'image enfant du bouton cliqué
			$('.lien_selected').removeClass('lien_selected');   
			lien.children('img').addClass('lien_selected');
		}
	
	var article_id = lien.attr('rel'); 										// on récupère l'id de la page à afficher
	
	$('.article_actif').fadeOut('100', function(){ 							// on fait disparaitre la page courante
		
		try{																// on fait une RAZ de toutes les pages avant d'afficher la nouvelle.
			document.getElementById("min").innerHTML = 'en minuscule';
			document.getElementById("accent").innerHTML = 'sans accent';
			document.input1.quest.value = "";
			document.input2.quest.value = "";
			montrer("text1");
			cacher("text2");
			cacher("text3");
			change_pwd(false, document.getElementById("button_chang_pwd"));
		}catch(err){}

		$(this).removeClass('article_actif');  								// on transfère la class "article_actif" à la nouvelle page
		$(article_id).addClass('article_actif'); 
		
		$('.article_actif').fadeTo('0', 0.85); 							// et enfin, on affiche la nouvelle page !
	});
}