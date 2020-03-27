// admin JS Controller RH 2019
// parisot.simon @ gmail.com

$(document).ready(function() {
    
    $('.john-content').load('views/avancement.php');
    $('.menu-btn').on('click', function() { toggleMenu(); });
    $('body').on('click', '.onglet', function(e) { displaypage($(this)); });
    $('body').on('click touchend', '.disc-detail', function(e) { displaydisc($(this)); });

    $('.john-content').on('keyup',  '.logs-input', function(){ loadLogs(); });
    $('.john-content').on('change', '.logs-input', function(){ loadLogs(); });
    //refreshIntervalId = setInterval(function(){ loadLogs(); }, 5000);

});

// ------------------------------------------
// Afficher une page
function displaypage (target) {
    toggleMenu();
    $('.john-content').html('<div class="lds-css ng-scope"><div style="width:100%;height:100%" class="lds-pacman"><div><div></div><div></div><div></div></div><div><div></div><div></div></div></div></div>');
    $('.john-content').load('views/' + $(target).attr('rel') + '.php');
    
    /*if ($(target).attr('rel') == "logs") {
        refreshIntervalId = setInterval(function(){ 
            $('.john-content').load('views/logs.php');
        }, 5000);
    }else{
        console.log("clearinterval"+refreshIntervalId);
        clearInterval(refreshIntervalId);
    }*/
}

function toggleMenu() {
    if ($('.menu').css('margin-left') == '0px') {
        $('.menu').css('margin-left', '-250px');
        $('.menu-btn').html('<i class="fas fa-bars"></i>');
    } else {
        $('.menu').css('margin-left', '0');
        $('.menu-btn').html('<i class="fas fa-times"></i>');
    }
}

function displaydisc(disc) {
    var en = $(disc).attr('en');
    var eq = $(disc).attr('eq');
    disc.children(".disc-container").load('views/disc-detail.php?enigme='+en+'&team='+eq);
}

function loadLogs (all) {
    if(typeof all === "undefined") all='';
    Fteam = $( "input[name='team']" ).val();
    Fenigme = $( "input[name='enigme']" ).val();
    Fmdp = $( "input[name='mdp']" ).val();
    $('#log-table').load('views/logs.php?'+all+'justdata&team='+Fteam+'&enigme='+Fenigme+'&mdp='+Fmdp);
}