<div class="enigme-header">
	
	<a class="tooltip" href="#" onclick="window.location = 'controllers/download.php?enigme=' + active();return false;">
		<img class="headerbutton" src="ressources/img/headerbutton1.png">
		<span><img class="callout" src="ressources/img/callout.gif">Télécharger cette énigme</span>
	</a>

	<a class="tooltip discussButton" href="#" onclick="discussion(this);return false;">
		<img class="headerbutton" src="ressources/img/headerbutton4.png">
		<span><img class="callout" src="ressources/img/callout.gif">Discuter de cette énigme avec votre équipe</span>
		<div id="comCount"></div>
	</a>

	<a class="tooltip indiceMailto" href="">
		<img class="headerbutton" src="ressources/img/headerbutton3.png" class="help_item">
		<span><img class="callout" src="ressources/img/callout.gif">Demander un indice aux organisateurs</span>
	</a>

	<a class="tooltip" href="#" onclick="help();return false;">
		<img class="headerbutton" src="ressources/img/headerbutton5.png">
		<span><img class="callout" src="ressources/img/callout.gif">Aide : comment utiliser cette page</span>
	</a>

	<form autocomplete="off">
		<input type="submit" value="Proposer" class="btn font2">
		<input type="text" name="reponse" placeholder="Votre réponse ..." id="e_password" class="textbox font2" autocapitalize="off" autocomplete="off" autocorrect="off">
	</form>

</div>

<div class="enigme-response"></div>

<div class="enigme-content">

	<div class="enigme-discussion">
		<div class="post">
			<form>
				<input type="text" maxlength="20" placeholder="Votre nom" class="font2 textbox" tabindex="1" id="d_name"/><input type="submit" value="Poster" class="btn font2" tabindex="3">
				<br/><textarea maxlength="400" placeholder="Saisissez votre message" class="font2 textbox" tabindex="2"></textarea>
			</form>
		</div>
		<div class="allposts"></div>
	</div>

	<div class="panel-enigme"><div class="emptytext">Sélectionnez une énigme...</div></div>

</div>



