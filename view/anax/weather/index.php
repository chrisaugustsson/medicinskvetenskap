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
        <h1>Find weather forecast based on IP-address</h1>
        <hr>
        <form action="weather/ip">
            <?php if ($valid === "false"): ?>
                <p class="has-text-danger">Bad IP-address</p>
            <?php endif; ?>
            <div class="field">
                <label>Enter IP-address:</label>
                <input class="input" type="text" name="ip" value="<?= $ip ?>">
            </div>
            <button class="button">Send</button>
            <button class="button" name="history" value="true">Get History</button>
        </form>
    </div>
</div>
