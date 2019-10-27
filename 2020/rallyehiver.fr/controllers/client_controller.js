$(document).ready(function() {
	
    // Gestion des animations et de la navigation sur le site
    $('body').on('click touchend', '.reduced', function(e){ expand(this) });
    $('.col-gauche', '.white').on('click', 'li:not(.deactivated)', function(e){ chargerEnigme(this) });
    $('.col-gauche', '.grey' ).on('click', 'li:not(.deactivated)', function(e){ chargerQuest(this) });
    $('textarea').autogrow();
    $('.mail-orga').on('click', function() { $(this).html('<i class="fas fa-envelope"></i> theb2.rallye@gmail.com').css('background-color', '#eee').css('font-weight', 'bold'); })
    $('#popin').on('click', function() { $('#popin').toggle(); })
    $('.downloadButton').on('click', function() { window.location = 'controllers/download.php?enigme=' + active(); })
    $('.downloadParcours').on('click', function() { window.location = 'controllers/download.php?code=' + questcode(); })
    $('.clueButton').on('click', function() {     
        $('#popin section').load('views/indice.php', function(){ $('#popin').toggle() });
    })

    // Gestion des formulaires
    $('.content-header form').on('submit', function(e) { e.preventDefault(); tester(); });
    $('.commentaires form').on('submit', function(e) { e.preventDefault(); donnerAvis(); });
    $('.enigme-discussion form').on('submit', function(e) { e.preventDefault(); poster(); });
    
    // Gestion du panel de discussion
    $('.discussButton').on('click', function() { discussion(); })
    //refreshIntervalId = setInterval(updateDiscussion(), 1000);
    $('.enigme-discussion').on('click', '.postdelete', function () {
        var nom = $(this).attr('nom');
        $.post("controllers/discussion.php?delete", { 
            nom: $(this).attr('nom'), 
            date: $(this).attr('date'),
            enigme: active()
        }, function() { updateDiscussion () });
    });

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

    /*
    //  Routine pour afficher un message à la fin du rallye !
    function verifyTheEnd () {
        var now = new Date().getTime();
        var end = new Date("Mar 20, 2019 22:58:00").getTime();
        if (now > end && !noend) $('.theend').show();
    }
    noend = false;
    $('.theend').on('click', function() { $('.theend').hide(); noend = true });
    var x = setInterval(function() {verifyTheEnd();}, 1000);
    */

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

    if ( (active()==19 || active()==20) && $(link).attr('rel') ) {
        var url = 'enigmes/img/Enigme '+active()+' - '+$(link).text()+$(link).attr('rel')+'.jpg';
        $('.downloadButton').hide();
    } else {
        var url = 'enigmes/img/Enigme '+active()+' - '+$(link).text()+'.jpg';
        $('.downloadButton').show();
    }
    $('.panel-enigme').html('<img src="'+url+'">');
    

    switch(active()){
        case 2:
            $('.panel-enigme').append('<audio controls><source src="enigmes/Enigme 2 - Les 7 familles en or.mp3" type="audio/mpeg">Impossible d\'afficher cette énigme. Contactez-nous svp.</audio>'); break;
        case 20:
            $('.panel-enigme').html('<p style="text-align:center;">Cette énigme de rapidité était accessible et résoluble uniquement le 22 février lors de son lancement.<br>Merci de vous être connectés si nombreux ce soir là :)</p>');
            $('.discussButton').hide();
            $('.downloadButton').hide();
            break;
        case 21:
            $('.panel-enigme').html('<p style="text-align:center;">Cette énigme n\'a pas d\'énoncé.</p>');
            $('.downloadButton').hide();
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

    /* afficher sous forme d'image
    var url = 'quest/img/'+$(link).attr('code')+' - '+$(link).text()+'.jpg';
    $('.panel-quest').html('<img src="'+url+'">'); */
    
    /* afficher sous forme de PDF */
    var url = 'quest/'+$(link).attr('code')+' - '+$(link).text()+'.pdf';
    $('.panel-quest').html('<embed src="'+url+'" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html">');
    
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
// Mettre à jour les stats de l'équipe
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
// donne le numéro de l'énigme ou du questionnaire actuellement affiché sur le site
function active () { return ($('.expanded').find('.selected').index() + 1); }

// ------------------------------------------
// donne le code du questionnaire actuellement affiché sur le site
function questcode () { return $('li:nth-child('+active()+')', '#quest-list').attr('code'); }


// ------------------------------------------
// Auto-growing textareas; ripped from Facebook
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