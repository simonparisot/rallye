<? if(isset($loginfailed)) echo "<div id=\"loginfailed\">$loginfailed</div>"; ?>

<input name="login" size="25" type="text" class="textbox font2" autocapitalize="off" autocomplete="off" autocorrect="off" placeholder="Identifiant" /><br><br>

<input name="pwd" size="25" type="password" class="textbox font2" placeholder="Mot de passe" /><br><br>

<input type="hidden" name="persistent" id="persistent" value="true">

<input name="submit" type="submit" value="Se connecter" class="btn font2" />