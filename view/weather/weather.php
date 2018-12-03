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
        <h2>Weather for <?= $res["city"] ?>, <?= $res["country"] ?></h2>
        <hr>
        <h3>Today:</h3>
        <div class="section">
            <div class="columns">
                <div class="column is-one-fifth">
                    <span class="icon">
                        <i class="fa fa-4x fa-<?= $res["currentIcon"] ?>"></i>
                    </span>
                </div>
                <div class="column">
                    <h3><?= $res["currentTemp"] ?>C˚</h3>
                </div>
            </div>
            <h3 class="is-marginless"><?= $res["currentSum"] ?></h3>
        </div>
        <h3>Tomorrow:</h3>
        <div class="section">
            <div class="columns">
                <div class="column is-one-fifth">
                    <span class="icon">
                        <i class="fa fa-4x fa-<?= $res["dailyIcon"][0] ?>"></i>
                    </span>
                </div>
                <div class="column">
                    <h3>High: <?= $res["dailyTempHigh"][0] ?>C˚</h3>
                    <h3>Low: <?= $res["dailyTempLow"][0] ?>C˚</h3>
                </div>
            </div>
            <h3 class="is-marginless"><?= $res["currentSum"] ?></h3>
        </div>
    </div>
</div>

<iframe width="700" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.openstreetmap.org/export/embed.html?bbox=<?= $res["long"]-0.0052730279611239 ?>%2C<?= $res["lat"]-0.0052730279611239 ?>%2C<?= $res["long"]+0.0052730279611239 ?>%2C<?= $res["lat"]+0.0052730279611239 ?>&amp;layer=mapnik" style="border: 1px solid black"></iframe>
<br/>
<small>
    <a href="https://www.openstreetmap.org/#map=16/<?= $res["lat"] ?>/<?= $res["long"] ?>">Visa större karta</a>
</small>