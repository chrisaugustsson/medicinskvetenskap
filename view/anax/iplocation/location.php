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
        <h2>Information: </h2>
        <hr>
        <p><i class="fas fa-check has-text-success"></i> <b>IP-address:</b> <?= $location["ip"] ?></p>
        <p><i class="fas fa-check has-text-success"></i> <b>Type:</b> <?= $location["type"] ?></p>
        <p><i class="fas fa-check has-text-success"></i> <b>City:</b> <?= $location["city"] ?></p>
        <p><i class="fas fa-check has-text-success"></i> <b>Country:</b> <?= $location["country"] ?></p>
        <p><i class="fas fa-check has-text-success"></i> <b>Latitude:</b> <?= $location["lat"] ?></p>
        <p><i class="fas fa-check has-text-success"></i> <b>Longitude:</b> <?= $location["long"] ?></p>
    </div>
</div>
