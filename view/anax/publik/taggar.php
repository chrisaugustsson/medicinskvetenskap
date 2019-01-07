<?php

namespace Anax\View;

/**
 * Style chooser.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?>
<div class="">
    <div class="content columns is-multiline">
        <?php foreach ($tags as $tag) : ?>
            <div class="column content is-one-quarter">
                <a href="<?= url("tag/" . $tag->name) ?>"><span class="is-mobile is-link tag"><?= $tag->name ?></span> </a>x <?= $tag->numberOfThreads ?>
                <p class="is-size-7 has-text-grey"><?= $tag->description ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>
