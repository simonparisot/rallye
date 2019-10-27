<?php

echo '<ol id="enigmes-list" style="list-style-type:upper-roman;">';

foreach ($enigmeList as $value) echo "<li class=\"deactivated\">$value[0]</li>";

echo '</ol>';

?>