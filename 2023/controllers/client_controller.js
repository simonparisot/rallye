$(document).ready(function() {
	
    // Gestion des animations et de la navigation sur le site
    $('body').on('click touchend', '.reduced', function(e){ expand(this) });
    $('.col-gauche', '.white').on('click', 'li:not(.deactivated)', function(e){ loadcontent(this) });
    $('.col-gauche', '.grey' ).on('click', 'li:not(.deactivated)', function(e){ loadcontent(this) });
    $('textarea').autogrow();
    $('.mail-orga').on('click', function() { $(this).html('rallyehiver2023@gmail.com ').addClass("revealed") })
    $('#to-info1').on('click', function() { $('#info1').show(); $('#info2').hide() })
    $('#to-info2').on('click', function() { $('#info1').hide(); $('#info2').show() })
    $('#popin').on('click', function() { $('#popin').toggle(); })
    $('.downloadButton').on('click', function() { window.location = 'controllers/download.php?code=' + activeCode(); })
    $('.clueButton').on('click', function() {     
        $('#popin section').load('views/indice.php', function(){ $('#popin').toggle() });
    })

    // Gestion des formulaires
    $('.content-header form').on('submit', function(e) { e.preventDefault(); tester(this); });
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
            enigme: activeCode()
        }, function() { updateDiscussion () });
    });

    // Get team state and unfold the curtains !
    getstate();
    $('.folded').removeClass('folded');

});

// ------------------------------------------
// Ouvrir un onglet
function expand (target) {
        if ( $(target).hasClass('fixed') ) { 
            $('.curtain').removeClass('reduced').removeClass('expanded');
        }else{
            $('.curtain').removeClass('expanded').addClass('reduced');
            $(target).removeClass('reduced').addClass('expanded');
        }
        //loadcontent(activeCode());
}

// ------------------------------------------
// Récupérer l'état de l'équipe et mettre à jour les pages
function getstate() {
    $.getJSON( "controllers/state.php", function( data ) { state = data; });
    $.getJSON( "controllers/clue.php", function( data ) { clue = data; });
}

// ------------------------------------------
// Afficher une enigme ou un parcours
function loadcontent (link) { 
    
    expand( $(link).parents('.curtain') );
    $(link).siblings('.selected').not(link).removeClass('selected');
    $(link).addClass('selected');
    var code = $(link).attr('code'); 

    // on vérifie si l'énigme est déjà résolue
    if (state[code]) {
        var resDate = new Date(state[code]*1000);
        var txt = 'Déjà résolu ! Le '+resDate.toLocaleDateString("fr-fr", { dateStyle: 'long' })+'.';
        if (clue[code]) txt += "Vous aviez d'ailleurs obtenu l'indice suivant : " + clue[code];
        $('.content-solved', '.expanded').html(txt).css('background-color', 'LightGreen').show();
    }else{
        $('.content-solved', '.expanded').hide();
    }

    var current = activeCode();
    current = current.substring(0, 3)
        
    var url = 'content/'+code+'.pdf';
    $(link).parents('.curtain').find('.content-src').html('<embed src="'+url+'#view=FitH&toolbar=0&statusbar=0&navpanes=0" alt="pdf" type="application/pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html">');

    if(current=='PBO') $('.content-header form').hide();
    else $('.content-header form').show();
   
    // on reset les différents panels
    $('.reponse').val('').blur();
    updateDiscussion();
}

// ------------------------------------------
// Tester un mot de passe
function tester (form) {
    var pwd = form.reponse.value;
    if(pwd === '') {
        $(form).children('.reponse').fadeOut(80).fadeIn(80).fadeOut(80).fadeIn(80);
    } else {
        var verify = $.get("controllers/verify.php", {code: activeCode(), pwd: pwd}, function(reponse){
            if(reponse.ok == 'hum') color = 'Orange' 
            else if (reponse.ok) color = 'LightGreen'
            else color = 'Red';
            $(form).parents('.curtain').find('.content-solved').html(reponse.texte).css('background-color', color).slideDown();
            if (reponse.ok) {
                $('.col-gauche', '.white').load('views/enigmes-list.php');
                $('.col-gauche', '.grey').load('views/quest-list.php');
                $('.main-content', '.purple').load('views/team-content.php');
                getstate();
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
        $.post("controllers/discussion.php", { nom: nom, newpost: newpost, enigme: activeCode() }, function() { updateDiscussion () });
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
    $.getJSON( "controllers/discussion.php", {enigme: activeCode()}, function(reponse) {
        $('.allposts').html('');
        if (reponse[0] == 'nothing') {
            $('.allposts', '.expanded') .append('<div class="post examplepost">Aucune discussion n\'a été entamée pour cette énigme, à vous de jouer ;)</div>');
            $('#comCount').hide();
        }else if(reponse[0] == 'error') {
            $('.allposts', '.expanded') .append('<div class="post examplepost">Désolé, impossible d\'effectuer cette opération :(</div>');
        }else if(reponse[0] == 'loginerror') {
            window.location = '?';
        }else{
            $.each( reponse, function(key, val) {
                $('.allposts', '.expanded') .append('<div class="post">' + val['texte'] + '</div>')
                                            .children().last()  .prepend('<div class="postdelete" date="' + val['date'] + '" nom="' + val['nom'] + '"></div>')
                                                                .prepend('<span class="postdate">' + val['nicedate'] + '</span><br/>')
                                                                .prepend('<span class="posttitle">' + val['nom'] + '</span>');
            });
            $('#comCount').html(reponse.length).show();
        };
    });
}


// ------------------------------------------
// donne le numéro ou le code de l'énigme ou du questionnaire actuellement affiché sur le site
function activeNb () { return ($('.expanded').find('.selected').index() + 1); }
function activeCode () { return ($('.expanded').find('.selected').attr("code")); }


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

                var val = (self.value=='')? $self.attr("placeholder"):self.value; 

                val = val.replace(/&/g, '&amp;')
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