<?php
namespace Anax\View;

?>

<div class="section has-background-white">
    <!-- PROFILE -->
    <div class="container columns">
        <div class="column is-2">
            <img src="<?= $user->gravatar . 400 ?>" alt="">
        </div>
        <div class="column content">
            <h2><?= $user->firstName ?> <?= $user->lastName ?></h2>
            <p>Gick med <?= $user->created ?></p>
            <p>E-post: <?= $user->email ?></p>
            <p>Alias: <?= $user->acronym ?></p>
            <?php if ($loggedIn) : ?>
            <a class="button" href="<?= url("user/edit/") ?>">Ändra uppgifter</a>
            <?php endif; ?>
        </div>
    </div>
    <!-- TABS -->
    <div class="tabs">
        <ul id="tab">
            <li class="is-active"><a id="thread">Trådar</a></li>
            <li><a id="answer">Svar</a></li>
            <li><a id="comment">Kommentarer</a></li>
        </ul>
    </div>

    <div id="threadContainer">
        <?php foreach ($threads as $thread) : ?>
            <div class="columns is-vcentered">
                <div class="column is-1 has-text-centered">
                    <p class="is-marginless"><?= $thread->score ?></p>
                    <p>Betyg</p>
                    <p class="is-marginless"><?= $thread->answer ?></p>
                    <p>Svar</p>
                </div>
                <div class="column container thread">
                    <div class="box is-size-6">
                        <a href="thread/<?= $thread->thisID ?>"><h3><?= $thread->title ?></h3></a>
                        <p>Skapad <?= $thread->published ?> </p>
                        <?php foreach ($tags[$thread->thisID] as $tag) : ?>
                            <a href="<?= url("tag/" . $tag->name) ?>"><span class="is-mobile is-link tag"><?= $tag->name ?></span></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <hr>
        <?php endforeach; ?>
    </div>
    <div id="answerContainer" class="hide">
        <?php foreach ($answers as $answer) : ?>
        <div class="columns is-vcentered">
            <div class="column is-1 has-text-centered">
                <p>Betyg <?= $answer->score ?></p>
            </div>
            <div class="column container thread">
                <div class="box is-size-6">
                    <?= substr($answer->content, 0, 100) ?> <p>...</p>
                    <a href="<?= url("thread/" . $answer->threadID) ?>">Gå till tråden</a>
                </div>
            </div>
            </div>
            <hr>
        <?php endforeach; ?>
    </div>
    <div id="commentContainer" class="hide">
        <?php foreach ($comments as $comment) : ?>
        <div class="columns is-vcentered">
            <div class="column is-1 has-text-centered">
                <p>Betyg <?= $comment->score ?></p>
            </div>
            <div class="column container thread">
                <div class="box is-size-6">
                    <?= $comment->content ?>
                    <?php $url = is_null($comment->threadID) ? $comment->origin : $comment->threadID ?>
                    <a href="<?= url("thread/" . $url . "#" . $comment->answerID) ?>">Gå till tråden</a>
                    <p><?= $comment->published ?></p>
                </div>
            </div>
            </div>
            <hr>
        <?php endforeach; ?>
    </div>


    <script>

    </script>