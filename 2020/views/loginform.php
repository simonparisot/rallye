<form id="authform" action="?" method="post">

	<?php if(isset($loginfailed)) echo "<div id=\"loginfailed\">$loginfailed</div>"; ?>

	<div class="field">
		<input name="login" size="30" type="text" class="textbox" autocapitalize="off" autocomplete="off" autocorrect="off" placeholder="Login de l'équipe" />
	</div>

	<div class="field">
		<input name="pwd" size="30" type="password" class="textbox" placeholder="Mot de passe" />
	</div>

	<div class="field">
		<input name="submit" type="submit" value="Se connecter" class="btn" />
	</div>

	<p>
		Les organisateurs de ce rallye n'autorisent malheureusement pas l'accès public à son contenu.<br> 
		Si vous n'étiez pas inscrits lors de ce rallye, d'autres organisateurs diffusent publiquement et gratuitement leurs rallyes : <br>
		<a href="https://2019.rallyehiver.fr"><u>l'édition 2019</u></a>, <a href="https://2016.rallyehiver.fr"><u>2016</u></a> et <a href="https://2019.rallyehiver.fr"><u>2012</u></a>.
	</p>

</form>

