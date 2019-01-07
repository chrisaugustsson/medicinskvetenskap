<?php

namespace Anax\View;

/**
 * Style chooser.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());



?>
<div class="">
    <p>Sortera efter:</p>
    <div class="tabs">
    <ul>
        <li class="<?= $order === "score" ? "is-active" : "" ?>">
            <a href="<?= url("tradar?order=score") ?>">Beryg</a>
        </li>
        <li class="<?= $order === "answer" ? "is-active" : "" ?>">
            <a href="<?= url("tradar?order=answer") ?>">Svar</a>
        </li>
        <li class="<?= $order === "published" ? "is-active" : "" ?>">
            <a href="<?= url("tradar?order=published") ?>">Publicerad</a>
        </li>
    </ul>
    </div>
    <div class="content">
    <?php foreach ($threads as $thread) : ?>
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
    </div>
</div>

<!-- Pagination -->
<nav class="pagination" role="navigation" aria-label="pagination">
  <ul class="pagination-list">
    <?php if ($currentPage < 5) : ?>
        <?php for ($i=1; $i <= $pages; $i++) : ?>
            <li>
            <a href="<?= url("tradar?&page=" . $i . "&order=" . $order) ?>" class="pagination-link <?= $i === $currentPage ? "is-current" : "" ?>">
                <?= $i ?>
            </a>
            </li>
            <?php if ($i >= 5) : ?>
                <li>
                    <span class="pagination-ellipsis">&hellip;</span>
                </li>
                <a href="<?= url("tradar?page=" . $pages . "&order=" . $order) ?>" class="pagination-link">
                    <?= $pages ?>
                </a>
                <?php break ?>
            <?php endif; ?>
        <?php endfor; ?>
    <?php elseif ($currentPage + 3 >= $pages) : ?>
        <a href="<?= url("tradar?page=1" . "&order=" . $order) ?>" class="pagination-link <?= 1 === $currentPage ? "is-current" : "" ?>">
            1
        </a>
        <span class="pagination-ellipsis">&hellip;</span>
        <?php for ($i=(int)$pages - 4; $i <= $pages; $i++) : ?>
            <li>
            <a href="<?= url("tradar?page=" . $i . "&order=" . $order) ?>" class="pagination-link <?= $i === $currentPage ? "is-current" : "" ?>">
                <?= $i ?>
            </a>
            </li>
        <?php endfor; ?>
    <?php else : ?>
        <a href="<?= url("tradar?page=1" . "&order=" . $order) ?>" class="pagination-link <?= 1 === $currentPage ? "is-current" : "" ?>">
            1
        </a>
        <span class="pagination-ellipsis">&hellip;</span>
        <?php for ($i=$currentPage - 2; $i <= $currentPage + 2; $i++) : ?>
            <li>
            <a href="<?= url("tradar?page=" . $i . "&order=" . $order) ?>" class="pagination-link <?= $i === $currentPage ? "is-current" : "" ?>">
                <?= $i ?>
            </a>
            </li>
            <?php if ($i >= $currentPage + 2) : ?>
                <li>
                    <span class="pagination-ellipsis">&hellip;</span>
                </li>
                <a href="<?= url("tradar?page=" . $pages . "&order=" . $order) ?>" class="pagination-link">
                    <?= $pages ?>
                </a>
                <?php break ?>
            <?php endif; ?>
        <?php endfor; ?>
    <?php endif; ?>
  </ul>
</nav>
