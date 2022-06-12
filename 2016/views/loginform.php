<form id="authform" action="?" method="post">

	<div>Pas d'équipe inscrite ?</div><br>

	<input name="login" type="hidden" value="anonymous"/>
	<input name="pwd" type="hidden" value="anonymous"/>
	<input name="submit" type="submit" value="Accéder en anonyme !" class="btn font2" />
	
</form>

<br><br>

<form id="authform" action="?" method="post">

	<div>Déjà inscrit ?</div><br>

	<? if(isset($loginfailed)) echo "<div id=\"loginfailed\">$loginfailed</div>"; ?>
	<input name="login" size="25" type="text" class="textbox font2" autocapitalize="off" autocomplete="off" autocorrect="off" placeholder="Identifiant de l'équipe" /><br><br>
	<input name="pwd" size="25" type="password" class="textbox font2" placeholder="Mot de passe" /><br><br>
	<input type="hidden" name="persistent" id="persistent" value="true">
	<input name="submit" type="submit" value="se connecter" class="btn font2" />

</form>