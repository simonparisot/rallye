function light(team, total) {

	$('body').append('<div id="jquery-overlay" style="position:absolute;top:0px;left:0px;"></div> <div id="plot-container" style="text-align:center;background-color:white;display:none;position:absolute;width:900px;height:430px;border:1px solid black;"><font size=2>Nombre d\'&eacute;nigmes r&eacute;solues au cours du temps. Chaque point repr&eacute;sente un test de mot de passe dans la partie questionnaire.</font><div id="plotarea" style="width:800px;height:400px;margin-left:50px;"></div> <div style="position:absolute;top:360px;right:65px;font-size:26px;text-align: right;">'+team+'</div></div>');
	
	$('#jquery-overlay').css({
		backgroundColor:	'#000',
		opacity:			0.8,
		width:				'100%',
		height:				'100%'
	}).fadeIn();
	
	var cLeft = ($(window).width()-900)/2;
	var cTop = ($(window).height()-430)/2;
	
	$('#plot-container').css({
		top:				cTop+'px',
		left:				cLeft+'px'
	}).show();
	
	$('#jquery-overlay,#plot-container,#plotarea').click(function() { unlight(); });
	
	// Récupération des données
	var dataString = acceder("draw.php?e="+team+"&t="+total);
	eval(dataString);


	var options = {
		xaxis: { mode: "time", minTickSize: [1, "day"] },
		yaxis: { tickSize: yinter, min: ymin, max: ymax, tickDecimals: 0 }
	}
	
	$.plot(	
		$("#plotarea"), 
		[ { 
			data: d, 
			lines: { show: true, steps: true, fill: true },
			points: { show: true },
			shadowSize: 0 
		} ], 
		options
	);
}


function unlight() {
	$('#plot-container').remove();
	$('#jquery-overlay').fadeOut(function() { $('#jquery-overlay').remove(); });
}