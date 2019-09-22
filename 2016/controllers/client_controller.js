//
// Bienvenue sur le controleur javascript du site du Rallye
// Il sera difficile de trouver des réponses aux énigmes ici, mais sait-on jamais !
// Vous remarquerez que j'ai bien commenté pour vous faciliter la tâche
// ... au fait, vous vous étiez bien déconnectés avant de regarder ça non ? Sinon je connais votre équipe maintenant, et vous pouvez être sûr que ça ressortira au diner ;)
//

$(document).ready(function() {
	
    $('body').on('click', '.reduced', function(e){ expand(this) });
    $('.col-gauche', '.white').on('click', 'li:not(.deactivated)', function(e){ chargerEnigme(this) });
    $('.col-gauche', '.grey' ).on('click', 'li:not(.deactivated)', function(e){ chargerQuest(this) });
    $('textarea').autogrow();
    $('.enigme-header form').on('submit', function(e) { e.preventDefault(); tester(); });
    $('.commentaires form').on('submit', function(e) { e.preventDefault(); donnerAvis(); });
    $('body').on('click', '.diego', function(e){ diego(this); });
    $('.enigme-discussion form').on('submit', function(e) { e.preventDefault(); poster(); });
    $('.enigme-discussion').on('click', '.postdelete', function () {
        var nom = $(this).attr('nom');
        $.post("controllers/discussion.php?delete", { nom: $(this).attr('nom'), date: $(this).attr('date') }, function() { updateDiscussion () });
    });
    //majStats();

    // hack pour la gestion des placeholder sous IE9
    if ( document.createElement('input').placeholder == undefined ) {
        $('[placeholder]')
            .on('focus', function() { if ( $(this).val() == $(this).attr('placeholder') ) { $(this).val(''); } })
            .on('blur', function() { if ( $(this).val() == '' ) { $(this).val( $(this).attr('placeholder') ); } })
            .blur()
            .parents('form').on('submit', function() {
                $(this).find('[placeholder]').each(function() { if ( $(this).val() == $(this).attr('placeholder') ) { $(this).val(''); } });
            });
    }

});


// ------------------------------------------
// Ouvrir un onglet
function expand (target) {
        if ( $(target).hasClass('fixed') ) { 
            $('.curtain').removeClass('reduced').removeClass('expanded');
        }else{
            $('.curtain').not(target).removeClass('expanded').addClass('reduced');
            $(target).removeClass('reduced').addClass('expanded');
        }
}

// ------------------------------------------
// Afficher une enigme
function chargerEnigme (link) { 
    expand('.white');
    $(link).siblings('.selected').not(link).removeClass('selected');
    $(link).addClass('selected');

    // on change le mailto pour la demande d'indice pour inclure le numéro de l'énigme
    $('.indiceMailto').attr("href", "mailto:terpsichore@rallyehiver.fr?subject=Demande d'indice - énigme "+active()+" pour "+$('.teamName').text()+"&body=Expliquez-nous en détail votre avancement pour obtenir un indice vraiment utile ;)")

    var url = 'enigmes/temp2/Enigme '+active()+' - '+$(link).text()+'.jpg';
    $('.panel-enigme').html('<img src="'+url+'">');
    $('.enigme-content').show();
    $('.enigme-header').show();
    $('a', '.enigme-header').show();

    switch(active()){
        case 15:
            $('.panel-enigme').append('<audio controls><source src="enigmes/Enigme 15 - L\'or du Rhin.mp3" type="audio/mpeg">Impossible d\'afficher cette énigme. Contactez-nous svp.</audio>'); break;
        case 13:
            $('.panel-enigme').append('<iframe src="https://www.youtube.com/embed/Uq5obfYvvqQ?rel=0" frameborder="0" allowfullscreen></iframe>'); break;
        case 19:
            $('.panel-enigme').load('enigmes/'+encodeURIComponent('Enigme 19 - A definir.php')); break;
        case 21:
            $('.enigme-content').hide();
            $('a', '.enigme-header').hide();
            break;
    }

    // on vérifie si l'énigme est déjà résolue
    if ($('.solved[rel='+active()+']').length != 0) {
        solvedText = 'Vous avez déjà résolu cette énigme (la première fois le '+$('.solved[rel='+active()+']').attr('date')+').';
        $('.enigme-response', '.expanded').html(solvedText).css('background-color', '#bbffc2').show();
    }else{
        $('.enigme-response', '.expanded').hide();
    };
    
    // on reset les différents panels
    $('#e_password', '.expanded').val('').blur();
    updateDiscussion();
}

// ------------------------------------------
// Afficher un questionnaire
function chargerQuest (link) {
    expand('.grey');
    $(link).siblings('.selected').not(link).removeClass('selected');
    $(link).addClass('selected');

    var url = 'quest/img/'+$(link).attr('code')+' - '+$(link).text()+'.jpg';
    $('.panel-quest').html('<img src="'+url+'">');
    $('.quest-header').show();
}

// ------------------------------------------
// Tester un mot de passe
function tester () {
    var pwd = $('#e_password').val();
    if(pwd === '') {
    	$('#e_password').fadeOut(80).fadeIn(80).fadeOut(80).fadeIn(80);
	} else {
    	var verify = $.get("controllers/verify.php", {enigme: active(), mdp: pwd}, function(reponse){
    		reponse.ok ? color = '#bbffc2' : color = '#e85938' 
    		$( ".enigme-response" ).html(reponse.texte).css('background-color', color).slideDown();
            if (reponse.ok) { 
                $('.grey').removeClass('fixed').find('.col-gauche').load('views/quest-list.php');
                $('.main-content', '.purple').load('views/team-content.php');
            };
    	}, "json");

	}
}

// ------------------------------------------
// Donner son avis dans le champ de la page perso
function donnerAvis () {
    var msg = $('textarea', '.commentaires').val();
    if(msg === '') {
        $('textarea', '.commentaires').fadeOut(80).fadeIn(80).fadeOut(80).fadeIn(80);
    } else {
        $.post("controllers/donnerAvis.php", { msg: msg }, function() {
            $('.commentaires').html("C'est envoyé, merci !");
            $('textarea', '.commentaires').val('')
        });

    }
}

// ------------------------------------------
// Mettre à jour les stats del'équipe
function majStats () {
    $('.stats-img').html('');
    var nbEni = $('span', '.statEni').text();
    var nbQuest = $('span', '.statQuest').text();
    if (nbEni!=0 || nbQuest!=0) {
        $('.bienvenue').hide();
        $('.stats').show();
        moustache = '<span class="tooltip"><img src="ressources/img/moustache.png"><span><img class="callout" src="ressources/img/callout.gif"><b>Enigme #1 - #2</b><br>débloquée le #3</span></span>';
        for (e in solved) $('.stats-img', '.statEni').append( moustache.replace('#1', e).replace('#2', $('li', '#enigmes-list').eq(e-1).text()).replace('#3', solved[e]) );        
        for (var i = 0; i < nbQuest; i++) $('.stats-img', '.statQuest').append('<img src="ressources/img/shoe.png">');
    }
}

// ------------------------------------------
// Publier un nouveau post dans le planel de  discussion
function poster () {
    var nom = $(".enigme-discussion input[type='text']").val();
    var newpost = $(".enigme-discussion textarea").val();
    if(nom == ''){
        $(".enigme-discussion input[type='text']").fadeOut(80).fadeIn(80).fadeOut(80).fadeIn(80);
    }else if (newpost == '') {
        $(".enigme-discussion textarea").fadeOut(80).fadeIn(80).fadeOut(80).fadeIn(80);
    }else{
        $.post("controllers/discussion.php", { nom: nom, newpost: newpost, enigme: active() }, function() { updateDiscussion () });
        $('.enigme-discussion form')[0].reset();
        $('.allposts', '.expanded').prepend('<div class="loading"><img src="ressources/img/loading.gif"></div>');
    }
}

// ------------------------------------------
// Afficher/masquer le panel de discussion
function discussion () {
    if($('.enigme-discussion', '.expanded').hasClass('slided')) { 
        $('.enigme-discussion', '.expanded').removeClass('slided'); 
    }else{
        updateDiscussion();
        $('.enigme-discussion', '.expanded').addClass('slided');
    }
}

// ------------------------------------------
// Mettre à jour les posts dans le panel de discussion
function updateDiscussion () {
    $.getJSON( "controllers/discussion.php", {enigme: active()}, function(reponse) {
        $('.allposts').html('');
        if (reponse[0] == 'nothing') {
            $('.allposts', '.expanded') .append('<div class="post font2 examplepost">Aucune discussion n\'a été entamée pour cette énigme, à vous de jouer ;)</div>');
            $('#comCount').hide();
        }else if(reponse[0] == 'error') {
            $('.allposts', '.expanded') .append('<div class="post font2 examplepost">Désolé, impossible d\'effectuer cette opération :(</div>');
        }else if(reponse[0] == 'loginerror') {
            window.location = '?';
        }else{
            $.each( reponse, function(key, val) {
                $('.allposts', '.expanded') .append('<div class="post font2">' + val['texte'] + '</div>')
                                            .children().last()  .prepend('<div class="postdelete" date="' + val['date'] + '" nom="' + val['nom'] + '"></div>')
                                                                .prepend('<span class="font2 postdate">' + val['nicedate'] + '</span><br/>')
                                                                .prepend('<span class="font2 posttitle">' + val['nom'] + '</span>');
            });
            $('#comCount').html(reponse.length).show();
        };
    });
}

// ------------------------------------------
// Gestion des diego
function diego (link) {
    if ($('.diego_display').length == 0) { $('#container').prepend('<div class="diego_display" ref=""></div>') };
    
    $('.diego_display') .off()
                        .append('<img src="ressources/img/'+$(link).attr('ref')+'-min.png">')
                        .attr('ref', $('.diego_display').attr('ref') + $(link).attr('ref').charAt(0))
                        .on('click', 'img:last-of-type', function() {
                            $(this).remove();
                            $('.diego_display').attr('ref', $('.diego_display').attr('ref').slice(0, -1) );
                        });
    $.get( "controllers/verify.php", { diego: $('.diego_display').attr('ref') }, function( data ) {
        if (data) { eval(data) };
    }); 
}

// ------------------------------------------
// Afficher l'aide du site (accessible depuis les énigmes)
function help () {
    if ($('.help_bg').length > 0) {
        $('.help_bg').remove();
    }else{
        $('body').prepend('<div class="help_bg"></div>');
        $('.help_bg').append('<img src="ressources/img/help1.png" class="helpimg1">');
        $('.help_bg').append('<img src="ressources/img/help2.png" class="helpimg2">');
        $('.help_bg').append('<img src="ressources/img/help3.png" class="helpimg3">');
        $('.help_bg').append('<img src="ressources/img/quit.png" class="helpquit" onclick="help();">');
        $('.help_bg').append('<img src="ressources/img/tuxedo.png" class="tuxedo diego" ref="tuxedo">');
    }
}

// ------------------------------------------
// donne le numéro de l'énigme ou du questionnaire actuellement affiché sur le site
function active () { return ($('.expanded').find('.selected').index() + 1); }

// ------------------------------------------
// donne le code du questionnaire actuellement affiché sur le site
function questcode () { return $('li:nth-child('+active()+')', '#quest-list').attr('code'); }

// ------------------------------------------
// Auto-growing textareas; technique ripped from Facebook
// http://github.com/jaz303/jquery-grab-bag/tree/master/javascripts/jquery.autogrow-textarea.js
(function($) {

    $.fn.autogrow = function(options)
    {
        return this.filter('textarea').each(function()
        {
            var self         = this;
            var $self        = $(self);
            var minHeight    = $self.height();
            var noFlickerPad = $self.hasClass('autogrow-short') ? 0 : parseInt($self.css('lineHeight')) || 0;
            var settings = $.extend({
                preGrowCallback: null,
                postGrowCallback: null
              }, options );

            var shadow = $('<div></div>').css({
                position:    'absolute',
                top:         -10000,
                left:        -10000,
                width:       $self.width(),
                fontSize:    $self.css('fontSize'),
                fontFamily:  $self.css('fontFamily'),
                fontWeight:  $self.css('fontWeight'),
                lineHeight:  $self.css('lineHeight'),
                resize:      'none',
                'word-wrap': 'break-word'
            }).appendTo(document.body);

            var update = function(event)
            {
                var times = function(string, number)
                {
                    for (var i=0, r=''; i<number; i++) r += string;
                    return r;
                };

                var val = self.value.replace(/&/g, '&amp;')
                                    .replace(/</g, '&lt;')
                                    .replace(/>/g, '&gt;')
                                    .replace(/\n$/, '<br/>&nbsp;')
                                    .replace(/\n/g, '<br/>')
                                    .replace(/ {2,}/g, function(space){ return times('&nbsp;', space.length - 1) + ' ' });

                // Did enter get pressed?  Resize in this keydown event so that the flicker doesn't occur.
                if (event && event.data && event.data.event === 'keydown' && event.keyCode === 13) {
                    val += '<br />';
                }

                shadow.css('width', $self.width());
                shadow.html(val + (noFlickerPad === 0 ? '...' : '')); // Append '...' to resize pre-emptively.
                
                var newHeight=Math.max(shadow.height() + noFlickerPad, minHeight);
                if(settings.preGrowCallback!=null){
                  newHeight=settings.preGrowCallback($self,shadow,newHeight,minHeight);
                }
                
                $self.height(newHeight);
                
                if(settings.postGrowCallback!=null){
                  settings.postGrowCallback($self);
                }
            }

            $self.change(update).keyup(update).keydown({event:'keydown'},update);
            $(window).resize(update);

            update();
        });
    };
})(jQuery);