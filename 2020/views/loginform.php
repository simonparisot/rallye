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

</form>