<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Rallye d'hiver 2012 | Souvenirs, souvenirs ...</title>
	<link rel="stylesheet" media="screen" type="text/css" title="style" href="../stylesheet.css" />
	<link type="text/css" href="../skin/jplayer.blue.monday.css" rel="stylesheet" />
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/jquery.jplayer.min.js"></script>
	<script type="text/javascript">
    $(document).ready(function(){

			$("#jquery_jplayer").jPlayer({
				ready: function () {
					$(this).jPlayer("setMedia", {
						m4a:"judith.m4a",
						oga: "judith.ogg"
					});
				},
				swfPath: "./js",
				supplied: "m4a, oga",
				cssSelectorAncestor: "#jp_container",
				wmode: "window"
			});
	
    });
  </script>
	
	<script src="flowplayer.js"></script>
</head>

<body>
	<div id="page_bof">
	
		<a href="../index.php"><div id="logo" style="margin-bottom:32px;"></div></a>
		
		<div style="position:relative;z-index:10;margin-left:78px;"><a href="../index.php?page=perso"><img class="bouton" src="retour.png" /></a></div>
		
		<div id="content_bof">
			<div id="bof_header"></div>
			<div id="bof">
			
				<img src="souvenirs.png" />
				
				<div id="online_view" style="margin-top:50px;">
					
					<table id="indice">
						<td width="530">
					
							<div id="jquery_jplayer" class="jp-jplayer"></div>
							<div id="jp_container" class="jp-audio">
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
											
						</td>
						
						<td><a href="souvenirs.mp3"><img src="dl.png" /></a></td>
						<td><a href="souvenirs.mp3">Télécharger</a></td>

					</table><br/><br/>
						
				</div>
					
			</div>
			<div id="bof_footer"></div>
		</div>
		
	</div>

</body>
</html>
