<?php

namespace Anax\View;

/**
 * Style chooser.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());


?>
<div class="columns is-centered is-vcentered is-multiline">
    <?php foreach ($users as $user) : ?>
        <div class="column section is-narrow">
            <div class="columns has-background-white ">
                <div class="column">
                    <img src="<?= $user->gravatar . 150 ?>" alt="">
                </div>
                <div class="column content is-size-7">
                    <a href="<?= url("user/profil/" . $user->acronym) ?>"><p class="is-size-4"><?= $user->acronym ?></p></a>
                    <p><?= $user->firstName ?> <?= $user->lastName ?></p>
                    <p>Gick med <?= $user->created ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>