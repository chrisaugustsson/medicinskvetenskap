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
        <h2>Weather, last 30 days, for <?= $res["city"] ?>, <?= $res["country"] ?></h2>
        <hr>
        <?php foreach ($res["history"] as $i => $value) :?>
        <h3><?= $res["history"][$i]["date"]  ?></h3>
        <div class="section">
            <div class="columns">
                <div class="column is-one-fifth">
                    <span class="icon">
                        <i class="fa fa-4x fa-<?= $res["history"][$i]["currentIcon"] ?>"></i>
                    </span>
                </div>
                <div class="column">
                    <h3><?= $res["history"][$i]["currentTemp"] ?>C˚</h3>
                </div>
            </div>
            <h3 class="is-marginless"><?= $res["history"][$i]["currentSum"] ?></h3>
        </div>
        <hr>
    <?php endforeach; ?>
    </div>
</div>

<iframe width="700" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.openstreetmap.org/export/embed.html?bbox=<?= $res["long"]-0.0052730279611239 ?>%2C<?= $res["lat"]-0.0052730279611239 ?>%2C<?= $res["long"]+0.0052730279611239 ?>%2C<?= $res["lat"]+0.0052730279611239 ?>&amp;layer=mapnik" style="border: 1px solid black"></iframe>
<br/>
<small>
    <a href="https://www.openstreetmap.org/#map=16/<?= $res["lat"] ?>/<?= $res["long"] ?>">Visa större karta</a>
</small>
