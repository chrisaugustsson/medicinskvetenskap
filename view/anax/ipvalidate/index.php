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
    <h1>Validate a IP-address</h1>
        <form action="ip/validate" method="post">
            <div class="field">
                <label class="label">Enter IP-address to validate</label>
                <input type="text" class="input" name="ipAddress">
            </div>
            <button class="button">Validate</button>
        </form>
    </div>
</div>
