<?php

namespace Anax\View;

/**
 * View to display all books.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;

// Create urls for navigation
$urlToCreate = url("book/create");
$urlToDelete = url("book/delete");



?>

<div class="content section">
<h1>View all items</h1>

<p class="has-text-centered">
    <a href="<?= $urlToCreate ?>">Create</a> |
    <a href="<?= $urlToDelete ?>">Delete</a>
</p>
</div>


<?php if (!$items) : ?>
    <p>There are no items to show.</p>
<?php
    return;
endif;
?>
<?php foreach ($items as $item) : ?>
<a href="<?= url("book/update/{$item->id}"); ?>">
    <div class="columns is-vcentered is-mobile">
        <div class="column is-one-third">
            <img src="image/<?= $item->image ?>" alt="">
        </div>
        <div class="column content has-text-black">
            <div>
            <h2><?= $item->title ?></h2>
            <p><?= $item->author ?></p>
            <p><?= $item->published ?></p>
            </div>
        </div>
    </div>
    <hr>
    </a>
<?php endforeach; ?>
