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
        <h2>Senaste inläggen:</h2>
        <?php foreach ($latestThreads as $thread) : ?>
            <div class="columns is-vcentered">
                <div class="column is-1 has-text-centered">
                    <p class="is-marginless"><?= $thread->score ?></p>
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
                        <?php foreach ($tags[$thread->thisID] as $tag) : ?>
                            <a href="<?= url("tag/" . $tag->name) ?>"><span class="is-mobile is-link tag"><?= $tag->name ?></span></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <hr>
        <?php endforeach; ?>
        <hr>
        <h2>Populäraste taggarna:</h2>
        <div class="content columns is-multiline">
            <?php foreach ($popularTags as $tag) : ?>
                <div class="column content is-one-quarter">
                    <a href="<?= url("tag/" . $tag->name) ?>"><span class="is-mobile is-link tag"><?= $tag->name ?></span> </a>x <?= $tag->numberOfThreads ?>
                    <p class="is-size-7 has-text-grey"><?= $tag->description ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <hr>
        <h2>Aktivaste användarna:</h2>
        <?php foreach ($users as $user) : ?>
            <div class="columns">
                <div class="column is-1">
                    <img src="<?= $user->gravatar . 100 ?>" alt="">
                </div>
                <div class="column">
                <a href="<?= url("user/profil/" . $user->acronym) ?>"><p class="is-size-4"><?= $user->acronym ?></p></a>
                <p>Trådar skapade: <?= $user->nrOfThreads ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
