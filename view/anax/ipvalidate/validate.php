<?php

namespace Anax\View;

/**
 * Style chooser.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());



?>

<div class="section">
    <div class="content has-text-centered">
        <p>Address you entered: <?= $valid[0] ?></p>
        <hr>
        <h2><?= $valid[1] ?></h2>
        <a class="button" href="../ip">Test a new IP-address</a>
    </div>
</div>
