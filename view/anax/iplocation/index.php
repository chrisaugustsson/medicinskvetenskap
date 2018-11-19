<?php

namespace Anax\View;

/**
 * Style chooser.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());



?>
<div class="section">
    <div class="content">
        <h1>Find location based on IP-address</h1>
        <hr>
        <form action="location/locate">
            <div class="field">
                <label>Enter IP-address:</label>
                <input class="input" type="text" name="ip" value="<?= $ip ?>">
            </div>
            <button class="button">Send</button>
        </form>
    </div>
</div>
