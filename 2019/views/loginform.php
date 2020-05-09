<? if(isset($loginfailed)) echo "<div id=\"loginfailed\">$loginfailed</div>"; ?>

<label for="login">Nom de votre équipe</label><br>
<input name="login" size="25" type="text" class="textbox font2" autocapitalize="off" autocomplete="off" autocorrect="off" /><br><br>

<label for="pwd">Mot de passe</label><br>
<input name="pwd" size="25" type="password" class="textbox font2" /><br><br>

<input type="checkbox" name="persistent" id="persistent"> <label for="persistent">rester connecté</label><br><br>

<input name="submit" type="submit" value="se connecter" class="btn font2" />