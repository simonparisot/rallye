<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Rallye d'hiver 2012 | B.O.F</title>
	<link rel="stylesheet" media="screen" type="text/css" title="style" href="stylesheet.css" />
	<link type="text/css" href="skin/jplayer.blue.monday.css" rel="stylesheet" />
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery.jplayer.min.js"></script>
	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-27051659-1']);
	  _gaq.push(['_trackPageview']);

	  (function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>
	<script type="text/javascript">
    $(document).ready(function(){
		<?
		for($j=1;$j<17;$j++){
			if($j!=3 && $j!=5 && $j!=9 && $j!=11 && $j!=16){
		?>
			$("#jquery_jplayer_<? echo $j; ?>").jPlayer({
				ready: function () {
					$(this).jPlayer("setMedia", {
						m4a:"enigmes_todl/indices/<? echo $j; ?>.m4a",
						oga: "enigmes_todl/indices/<? echo $j; ?>.ogg"
					});
				},
				play: function() { // To avoid all jPlayers playing together.
					$(this).jPlayer("pauseOthers");
				},
				swfPath: "/js",
				supplied: "m4a, oga",
				cssSelectorAncestor: "#jp_container_<? echo $j; ?>",
				wmode: "window"
			});
	<? 	}
		if($j==9 || $j==11 || $j==16){
	?>
			$("#jquery_jplayer_<? echo $j; ?>").jPlayer({
				ready: function () {
				  $(this).jPlayer("setMedia", {
					// flv: "http://www.rallyedhiver2012.fr/enigmes_todl/indices/<? echo $j; ?>.flv",
					// poster: "http://www.rallyedhiver2012.fr/enigmes_todl/indices/<? echo $j; ?>.jpg"
					// flv: "enigmes_todl/indices/<? echo $j; ?>.flv",
					m4v: "enigmes_todl/indices/<? echo $j; ?>.m4v",
					ogv: "enigmes_todl/indices/<? echo $j; ?>.ogv",
					// ogv: "http://www.jplayer.org/video/ogv/Big_Buck_Bunny_Trailer.ogv",
					poster: "enigmes_todl/indices/<? echo $j; ?>.jpg"
					// m4v: "http://www.jplayer.org/video/m4v/Big_Buck_Bunny_Trailer.m4v",
					// ogv: "http://www.jplayer.org/video/ogv/Big_Buck_Bunny_Trailer.ogv",
					// webmv: "http://www.jplayer.org/video/webm/Big_Buck_Bunny_Trailer.webm",
					// poster: "http://www.jplayer.org/video/poster/Big_Buck_Bunny_Trailer_480x270.png"
				  });
				},
				play: function() { // To avoid all jPlayers playing together.
					$(this).jPlayer("pauseOthers");
				},
				swfPath: "/js",
				// supplied: "m4v",
				supplied: "m4v, ogv",
				cssSelectorAncestor: "#jp_container_<? echo $j; ?>"
			  });
	<?
		}
	} 
	?>
    });
  </script>
	
	<script src="flowplayer.js"></script>
</head>

<body>
	<div id="page_bof">
	
		<a href="index.php"><div id="logo" style="margin-bottom:32px;"></div></a>
		
		<div style="position:relative;z-index:10;margin-left:78px;"><a href="index.php?page=enigmes"><img class="bouton" src="pictures/retour.png" /></a></div>
		
		<div id="content_bof">
			<div id="bof_header"></div>
			<div id="bof">
				<img src="pictures/bof.png" />
				<br><br>
				<p style="text-align:justify;">
				Cette énigme est composée de 16 indices et une grille de réponse vous permettant de trouver le mot de passe. Vous pouvez écouter et visualiser les indices sur cette page 
				<u>(notez que certains navigateurs ne sont pas compatibles avec cette option)</u>. Vous pouvez télécharger un fichier contenant tous les indices et la grille de réponse 
				<a href="enigmes_todl/indices/indices.zip"><font color="#76a7f2">en cliquant ici</font></a>. Vous pouvez également télécharger indépendamment chaque indice sur cette page grâce aux liens "Télécharger".
				</p><br>
				
				<div id="online_view" style="">
				
					<? // affichage des indices
					
					for($i=1;$i<17;$i++){
						$type = 'mp3';
						echo '<font size=5 color="#b0b0b0">INDICE '.$i.'</font>';
					?>
					
					<table id="indice">
						<td width="530">
					
					<?
						if($i!=3 && $i!=5 && $i!=9 && $i!=11 && $i!=16){
							echo	'<div id="jquery_jplayer_'.$i.'" class="jp-jplayer"></div>';
							echo	'<div id="jp_container_'.$i.'" class="jp-audio">';
					?>
							<div class="jp-type-single">
							  <div class="jp-gui jp-interface">
								<ul class="jp-controls">
								  <li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
								  <li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
								  <li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
								  <li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
								  <li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
								  <li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
								</ul>
								<div class="jp-progress">
								  <div class="jp-seek-bar">
									<div class="jp-play-bar"></div>
								  </div>
								</div>
								<div class="jp-volume-bar">
								  <div class="jp-volume-bar-value"></div>
								</div>
								<div class="jp-time-holder">
								  <div class="jp-current-time"></div>
								  <div class="jp-duration"></div>
								  <ul class="jp-toggles">
									<li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
									<li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
								  </ul>
								</div>
							  </div>
			
							  <div class="jp-no-solution">
								<span>Update Required</span>
								To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
							  </div>
							</div>
						</div>
						
					<?
						}
						if($i==3 || $i==5){
							echo '<img src="enigmes_todl/indices/'.$i.'_1.jpg"></img>';
							$type = 'jpg';
						}
						if($i==9 || $i==11 || $i==16){
						
							$type = "m4v";
							echo	'<div id="jquery_jplayer_'.$i.'" class="jp-jplayer"></div>';
							echo	'<div id="jp_container_'.$i.'" class="jp-video">';
					?>
								<div class="jp-type-single">
								  <div id="jquery_jplayer_1" class="jp-jplayer"></div>
								  <div class="jp-gui">
									<div class="jp-video-play">
									  <a href="javascript:;" class="jp-video-play-icon" tabindex="1">play</a>
									</div>
									<div class="jp-interface">
									  <div class="jp-progress">
										<div class="jp-seek-bar">
										  <div class="jp-play-bar"></div>
										</div>
									  </div>
									  <div class="jp-current-time"></div>
									  <div class="jp-duration"></div>
									  <div class="jp-controls-holder">
										<ul class="jp-controls">
										  <li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
										  <li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
										  <li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
										  <li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
										  <li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
										  <li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
										</ul>
										<div class="jp-volume-bar">
										  <div class="jp-volume-bar-value"></div>
										</div>
									  </div>
									  
									</div>
								  </div>
								  <div class="jp-no-solution">
									<span>Update Required</span>
									To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
								  </div>
								</div>
							  </div>
							
					<?		
						}
					?>
						
						</td>
						
					<?
						echo	'<td><a href="enigmes_todl/indices/'.$i.'.'.$type.'"><img src="pictures/dl.png" /></a></td>';
						echo	'<td><a href="enigmes_todl/indices/'.$i.'.'.$type.'">Télécharger</a></td>';
					?>	
					</table><br><br>
					
					<? } ?>
					
					<font size=5 color="#b0b0b0">Grille de réponse</font>
					<table id="indice">
						<td width="530"><img src="enigmes_todl/indices/grille2.jpg"></img></td>
						<td><a href="enigmes_todl/indices/grille.doc"><img src="pictures/dl.png" /></a></td>
						<td><a href="enigmes_todl/indices/grille.doc">Télécharger</a></td>
					</table><br><br>
						
				</div>
					
			</div>
			<div id="bof_footer"></div>
		</div>
		
	</div>

</body>
</html>
