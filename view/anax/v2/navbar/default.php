<?php

namespace Anax\View;

/**
 * Template file to render a view.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

$items = $navbarConfig["items"] ?? [];

$classes = "navbar " . ($navbarConfig["class"] ?? null);
$path = isset($_SERVER["PATH_INFO"]) ? $_SERVER["PATH_INFO"] : "/";


?><nav class="navbar-end has-text-white">
<?php foreach ($items as $item) : ?>
    <a class="navbar-item <?=$path == "/" . $item["url"] ? "is-active" : ""?>" href="<?=url($item["url"])?>" title="<?=$item["title"]?>"><?=$item["text"]?></a>
<?php endforeach; ?>
</nav>
