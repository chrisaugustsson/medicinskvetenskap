<?php

namespace Anax\View;

/**
 * A layout rendering views in defined regions.
 */

// Show incoming variables and view helper functions
// echo showEnvironment(get_defined_vars(), get_defined_functions());

$pageTitle = $title;
$path = isset($_SERVER["PATH_INFO"]) ? $_SERVER["PATH_INFO"] : "/";

?><!doctype html>
<html class="has-background-white-bis">
<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css">
    <script src='http://cloud.tinymce.com/5-testing/tinymce.min.js'></script>
    <link rel="icon" href="<?= url("img/favicon.png") ?>">

    <?php if (isset($stylesheets)) : ?>
        <?php foreach ($stylesheets as $stylesheet) : ?>
            <link rel="stylesheet" type="text/css" href="<?= asset($stylesheet) ?>">
        <?php endforeach; ?>
    <?php endif; ?>

</head>
<body>

<!-- navbar -->
<?php if (regionHasContent("navbar")) : ?>

    <div id="navbar" class="navbar is-spaced is-grey">
        <div id="brand" class="navbar-brand">
            <a class="brand" href=<?= url("index") ?>>
            </a>
        </div>
        <div id="test"></div>
            <?php renderRegion("navbar") ?>

    </div>
<?php endif; ?>

<!-- main -->
<div class="has-background-white-ter">
    <div class="">
        <div class="has-background-white-bis special-content">
        <!-- <?php
        $sidebarLeft  = regionHasContent("sidebar-left");
        $sidebarRight = regionHasContent("sidebar-right");
        $class = "";
        $class .= $sidebarLeft  ? "has-sidebar-left "  : "";
        $class .= $sidebarRight ? "has-sidebar-right " : "";
        $class .= empty($class) ? "" : "has-sidebar";
        ?> -->
            <?php if (regionHasContent("main")) : ?>
            <main class="section columns is-centered <?= $class ?>" role="main">
                <div class="column is-2 side-bar has-background-white">
                    <ul class="menu-list">
                        <li><a class="<?=$path == "/tradar" ? "is-active" : ""?>" href=<?= url("tradar") ?>>Trådar</a></li>
                        <li><a class="<?=$path == "/taggar" ? "is-active" : ""?>" href=<?= url("taggar") ?>>Taggar</a></li>
                        <li><a class="<?=$path == "/user/users" ? "is-active" : ""?>" href=<?= url("user/users") ?>>Användare</a></li>
                        <hr>
                        <li><a class="<?=$path == "/om" ? "is-active" : ""?>" href=<?= url("om") ?> >Om Medisink Vetenskap</a></li>
                    </ul>
                </div>
                <div class="section column is-8 has-text-dark">
                    <?php renderRegion("main") ?>
                </div>
            </main>
            <?php endif; ?>
        </div>

    </div>
</div>

<!-- footer -->
<?php if (regionHasContent("footer")) : ?>
<div class="footer has-shadow has-background-dark">
    <div class="content has-text-centered">
        <?php renderRegion("footer")?>
    </div>
</div>
<?php endif;?>

<?php if (isset($javascripts)) : ?>
    <?php foreach ($javascripts as $javascript) : ?>
    <script async src="<?= asset($javascript) ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>

</body>
</html>
