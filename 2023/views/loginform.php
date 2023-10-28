<form id="authform" action="?" method="post">

	<?php if(isset($loginfailed)) echo "<div id=\"loginfailed\">$loginfailed</div>"; ?>

	<div class="field">
		<input required minlength="10" name="code" size="30" type="text" class="textbox" autocapitalize="off" autocomplete="off" autocorrect="off" placeholder="Code de connexion" />
	</div>

	<div class="field">
		<input name="submit" type="submit" value="Se connecter" class="btn" />
	</div>

</form>

<div id="authinfo">

	<p id="to-info1"><a href="#">Je n'ai pas de code de connexion</a></p>

	<div id="info1" class="inside-box">

		<p>Le code de connexion vous permet d'accéder à l'espace de votre équipe. Votre chef d'équipe le connait et pourra vous le communiquer.</p>
		<p>Si vous êtes le chef d'équipe et que c'est la première fois que vous vous connectez à ce site, vous n'avez donc pas de code de connexion. Cliquez ici :</p>
		<div class="field"> <input id="to-info2" type="button" value="Récupérer mon code" class="btn" /> </div>

	</div>

	<div id="info2" class="inside-box">

		<p style="color:red;font-size: 1.6rem;">Attention</p>
		<p>En cliquant ci-dessous, vous allez créer un nouveau code de connexion. Si vous aviez déjà généré un code, il ne fonctionnera plus pour l'ensemble de l'équipe, qui sera déconnectée. Le nouveau code sera envoyé sur l'email du chef d'équipe.</p>
		<form id="authform2" action="controllers/sendmail.php" method="post">

			<div class="field">
				<input required name="email" type="email" class="textbox" autocapitalize="off" autocorrect="off" placeholder="Email du chef d'équipe" />
			</div>

			<div class="field">
				<input name="submit" type="submit" value="Créer un nouveau code" class="btn" />
			</div>

		</form>

	</div>

</div>

