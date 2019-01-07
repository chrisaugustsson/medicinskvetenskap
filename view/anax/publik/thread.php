<?php
namespace Anax\View;

?>
<div class="section has-background-white">
    <div class="conatiner columns is-vcentered">
        <!-- VOTE ON THREAD -->
        <div class="column is-1 has-text-centered">
            <form action="<?= url("vote/thread") ?>" method="POST">
                <input type="hidden" name="thread" value="<?= $thread->id ?>">
                <div class=" has-text-info">
                    <button style="border:none;background:none;" type="submit" name="vote-up" value="1">
                        <i type="submit" class="fas fa-3x fa-arrow-alt-circle-up has-text-link"></i>
                    </button>
                </div>
                <p class="has-text-weight-bold"><?= $thread->score ?></p>
                <div class=" has-text-info">
                    <button style="border:none;background:none;" type="submit" name="vote-down" value="1">
                        <i type="submit" class="fas fa-3x fa-arrow-alt-circle-down has-text-link"></i>
                    </button>
                </div>
            </form>
        </div>
        <div class="column">
            <div class="content">
                <h2><?= $thread->title ?></h2>
                <p>Skapad av
                    <a class="is-size-5" href="<?= url("user/profil/" . $thread->owner) ?>">
                        <?= $thread->owner ?>
                    </a> <?= $thread->published ?>
                </p>
                    <div class="">
                        <?php foreach ($tags as $tag) : ?>
                            <a href="<?= url("tag/" . $tag->name) ?>"><span class="is-mobile is-link tag"><?= $tag->name ?></span></a>
                        <?php endforeach; ?>
                    </div>
            </div>
        </div>
    </div>
    <div class="content">
        <?= $thread->content ?>
    </div>
    <hr>


    <!-- COMMENTS ON THE THREAD -->
    <div class="section">
        <?php foreach ($threadComments as $comment) : ?>
            <div class="is-size-7">
                <span class="comment-score content has-text-grey columns">
                    <p><?= $comment->score ?></p>
                    <p><?= $comment->content ?></p>
                    <a href="<?= url("user/profil/" . $comment->owner) ?>"> - <?= $comment->owner ?></a> <p><?= $comment->published ?></p>
                    <p>
                        <form action="<?= url("vote/comment") ?>" method="POST">
                            <input type="hidden" name="comment" value="<?= $comment->id ?>">
                            <input type="hidden" name="thread" value="<?= $thread->id ?>">
                            <span class=" has-text-info">
                                <button style="border:none;background:none;" type="submit" name="vote-up" value="1">
                                    <i type="submit" class="fas fa-1x fa-arrow-up has-text-primary"></i>
                                </button>
                            </span>
                            <span class=" has-text-info">
                                <button style="border:none;background:none;" type="submit" name="vote-down" value="1">
                                    <i type="submit" class="fas fa-1x fa-arrow-down has-text-primary"></i>
                                </button>
                            </span>
                        </form>
                    </p>
                </span>
            </div>
            <hr>
        <?php endforeach; ?>
        <div class="has-text-grey content is-size-7">
            <?php if ($userLoggedIn) : ?>
                <?= $commentForm ?>
            <?php else : ?>
                <p>Logga in för att lämna en kommentar</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<hr>

<!-- TAB FOR ANSWERS -->
<div class="tabs">
  <ul>
    <li class="<?= $order === "score" ? "is-active" : "" ?>"><a href="<?= url("thread/" . $thread->id . "?order=score") ?>">Bäst betyg</a></li>
    <li class="<?= $order === "published" ? "is-active" : "" ?>"><a href="<?= url("thread/" . $thread->id . "?order=published") ?>">Senaste</a></li>
  </ul>
</div>
<!-- ANSWERS -->
<div class="section is-size-6 has-background-white">
    <div class="conatiner">
        <div class="content">
            <h3><?= sizeof($answers) ?> Svar</h3>
            <hr>
            <?php foreach ($answers as $answer) : ?>
                <p class="has-text-weight-semibold">Av <?= $answer->owner ?> <?= $answer->published ?></p>
                <!-- VOTE ON ANSWER -->
                <div class="columns">
                    <div class="column is-1 has-text-centered">
                        <form action="<?= url("vote/answer") ?>" method="POST">
                            <input type="hidden" name="answer" value="<?= $answer->id ?>">
                            <input type="hidden" name="thread" value="<?= $thread->id ?>">
                            <div class=" has-text-info">
                                <button style="border:none;background:none;" type="submit" name="vote-up" value="1">
                                    <i type="submit" class="fas fa-3x fa-arrow-alt-circle-up has-text-link"></i>
                                </button>
                            </div>
                            <p class="has-text-weight-bold"><?= $answer->score ?></p>
                            <div class=" has-text-info">
                                <button style="border:none;background:none;" type="submit" name="vote-down" value="1">
                                    <i type="submit" class="fas fa-3x fa-arrow-alt-circle-down has-text-link"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="column">
                        <?= $answer->content ?>
                    </div>
                </div>
                <hr style="background-color:#c6c6c6;">

                <!-- COMMENTS -->
                <div class="section">
                    <?php $answerComments = $commentObject->findAllWhere("answerID = ?", $answer->id) ?>
                    <?php foreach ($answerComments as $comment) : ?>
                        <div class="is-size-7">
                            <span class="comment-score content has-text-grey columns">
                                <p><?= $comment->score ?></p>
                                <p><?= $comment->content ?></p>
                                <a href="<?= url("user/profil/" . $comment->owner) ?>"> - <?= $comment->owner ?></a> <p><?= $comment->published ?></p>
                                <p>
                                    <form action="<?= url("vote/comment") ?>" method="POST">
                                        <input type="hidden" name="comment" value="<?= $comment->id ?>">
                                        <input type="hidden" name="thread" value="<?= $thread->id ?>">
                                        <span class=" has-text-info">
                                            <button style="border:none;background:none;" type="submit" name="vote-up" value="1">
                                                <i type="submit" class="fas fa-1x fa-arrow-up has-text-primary"></i>
                                            </button>
                                        </span>
                                        <span class=" has-text-info">
                                            <button style="border:none;background:none;" type="submit" name="vote-down" value="1">
                                                <i type="submit" class="fas fa-1x fa-arrow-down has-text-primary"></i>
                                            </button>
                                        </span>
                                    </form>
                                </p>
                            </span>
                        </div>
                        <hr>
                    <?php endforeach; ?>
                <div class="has-text-grey content is-size-7">
                    <?php if ($userLoggedIn) : ?>
                        <form action="<?= url("comment/new") ?>" method="POST">
                            <div class="control field">
                                <input class="input is-size-7" type="text" name="content" placeholder="Kommentera">
                            </div>
                            <input type="hidden" name="answer" value="<?= $answer->id ?>">
                            <input type="hidden" name="thread" value="<?= $thread->id ?>">
                            <button type="submit" class="button is-size-7">Skicka</button>
                        </form>
                    <?php else : ?>
                        <p>Logga in för att lämna en kommentar</p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach ; ?>
        </div>
    </div>
</div>

<div class="content">
    <?php if ($userLoggedIn) : ?>
        <?= $answerForm ?>
    <?php else : ?>
        <h3>Logga in för att lämna ett svar.</h3>
    <?php endif; ?>
</div>