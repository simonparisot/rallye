$('#container').append('<div class="diego_container"></div>');
$('.diego_container').load('views/diegofun.php', function() {
	
	//on calcule le placement de l'image en fonction de la taille des onglets
	offset = ($('.white').width() + $('.grey').width() + $('.purple').width() - 920) + 'px';
	$('.diego_container').animate({left: offset}, 1000);

	$('.diego_container').one('click', function(e){
    	
    	// on réduit tous les onglets pour afficher l'image
    	expand('');

    	// on change l'icone sur l'image (elle n'est plus cliquable)
	    $('.diego_container').css('cursor', 'default');
	    
	    // on affiche un message d'alerte si l'écran est trop petit
	    $('.diegotoosmall').show();

	    // on rend les polaroids cliquables
	    $('.gigapixel').css('cursor', 'pointer').click(function () {
	    	window.open($(this).attr('href'), '_blank');
	    });

	    // on initialise les horloges à l'heure actuelle et on les affiche
		currentHour = new Date().getHours();
		currentMin = new Date().getMinutes();
		currentHour = ("0" + currentHour).slice(-2);
		currentMin = ("0" + currentMin).slice(-2);
		$('.clock').val(currentHour + ':' + currentMin);
		$('#clocktable').show(400);

		// on affiche les insectes !!
	    $.getScript( 'ressources/bug-min.js', function(){
			new BugController({ 'canDie': true, 'imageSprite':'ressources/img/fly-sprite.png' });
		    new SpiderController({ 'maxBugs':2, 'canDie': true, 'imageSprite':'ressources/img/spider-sprite.png' });
		});

		// on vérifie ce qui est tapé à chaque frappe dans les horloges
		$('.clock').keyup(function() {
			$.post( "controllers/verify.php", { clock1: $("input[name$='clock1']").val(),
												clock2: $("input[name$='clock2']").val(),
												clock3: $("input[name$='clock3']").val(),
												clock4: $("input[name$='clock4']").val(),
												clock5: $("input[name$='clock5']").val()
											 }, function( data ) {

				// si l'une des horloges est à la bonne heure, on passe en vert
		        if (data.clock1) { $("input[name$='clock1']").css('background-color', '#007000') }else{ $("input[name$='clock1']").css('background-color', '#000') };
		        if (data.clock2) { $("input[name$='clock2']").css('background-color', '#007000') }else{ $("input[name$='clock2']").css('background-color', '#000') };
		        if (data.clock3) { $("input[name$='clock3']").css('background-color', '#007000') }else{ $("input[name$='clock3']").css('background-color', '#000') };
		        if (data.clock4) { $("input[name$='clock4']").css('background-color', '#007000') }else{ $("input[name$='clock4']").css('background-color', '#000') };
		        if (data.clock5) { $("input[name$='clock5']").css('background-color', '#007000') }else{ $("input[name$='clock5']").css('background-color', '#000') };
		        if (data.clock1 && data.clock2 && data.clock3 && data.clock4 && data.clock5) { eval(data.welldone) }
		    }, "json");
		});

		// on gère le retour à l'interface normale
		$('.curtain').one('click', function (){ location.reload(); });

	});
});

