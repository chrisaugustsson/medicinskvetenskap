<?php

namespace Anax\View;

/**
 * A layout rendering views in defined regions.
 */

// Show incoming variables and view helper functions
// echo showEnvironment(get_defined_vars(), get_defined_functions());

$pageTitle = $title;
$title = ($title ?? "No title") . ($baseTitle ?? " | No base title defined");


?><!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css">

    <?php if (isset($stylesheets)) : ?>
        <?php foreach ($stylesheets as $stylesheet) : ?>
            <link rel="stylesheet" type="text/css" href="<?= asset($stylesheet) ?>">
        <?php endforeach; ?>
    <?php endif; ?>

<?php if (isset($favicon)) : ?>
    <link rel="icon" href="<?= $favicon ?>">
<?php endif; ?>

</head>
<body>

<!-- navbar -->
<?php if (regionHasContent("navbar")) : ?>
<section class="hero is-primary is-medium">
  <!-- Hero head: will stick at the top -->
  <div class="parallax-overlay"></div>
  <div class="hero-head">
    <div class="navbar is-spaced is-grey">
        <div class="navbar-menu">
            <?php renderRegion("navbar") ?>
        </div>
    </div>
  </div>

  <!-- Hero content: will be in the middle -->
  <div class="hero-body">
    <div class="container has-text-centered">
      <h1 class="title is-size-1">
        <?= $pageTitle ?>
      </h1>
    </div>
  </div>

</section>
<?php endif; ?>

<!-- main -->
<div class="section has-background-white-ter">
    <div class="container">
        <div class="section has-background-white-bis special-content">
        <?php
        $sidebarLeft  = regionHasContent("sidebar-left");
        $sidebarRight = regionHasContent("sidebar-right");
        $class = "";
        $class .= $sidebarLeft  ? "has-sidebar-left "  : "";
        $class .= $sidebarRight ? "has-sidebar-right " : "";
        $class .= empty($class) ? "" : "has-sidebar";
        ?>



            <?php if (regionHasContent("main")) : ?>
            <main class="section container columns is-centered <?= $class ?>" role="main">
                <div class="column is-two-thirds has-text-dark">
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
