<?php

namespace Anax\View;

/**
 * Style chooser.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?>
<div class="">
    <div class="content">
        <h2>Trådar med taggen <?= $tag ?>:</h2>
        <?php foreach ($threads as $thread) : ?>
            <div class="columns is-vcentered">
                <div class="column is-1 has-text-centered">
                    <p class="is-marginless">2</p>
                    <p>Betyg</p>
                    <p class="is-marginless"><?= $thread->answer ?></p>
                    <p>Svar</p>
                </div>
                <div class="column container thread">
                    <div class="box is-size-7">
                        <a href="thread/<?= $thread->thisID ?>"><h3><?= $thread->title ?></h3></a>
                        <p>Skapad av
                            <a class="is-size-5" href="<?= url("user/profil/" . $thread->owner) ?>">
                                <?= $thread->owner ?>
                            </a> <?= $thread->published ?>
                        </p>
                            <?php foreach ($allTags[$thread->thisID] as $tag) : ?>
                                <a href="<?= url("tag/" . $tag->name) ?>"><span class="is-mobile is-link tag"><?= $tag->name ?></span></a>
                            <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <hr>
        <?php endforeach; ?>
    </div>
</div>
