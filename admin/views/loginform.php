<? if(isset($loginfailed)) echo "<div id=\"loginfailed\">$loginfailed</div>"; ?>

<input required minlength="10" name="code" size="30" type="text" class="textbox font2" autocapitalize="off" autocomplete="off" autocorrect="off" placeholder="Code de connexion" /><br><br>

<input type="hidden" name="persistent" id="persistent" value="true">

<input name="submit" type="submit" value="Se connecter" class="btn font2" />