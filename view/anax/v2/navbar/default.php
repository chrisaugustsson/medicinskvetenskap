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

$session = $this->di->get("session");
$user = $session->get("user") !== null ? $session->get("user") : null;


?>
<!-- <div class="navbar-start search-field">
    <input type="text" class="input" placeholder="Search..." width="400">
</div> -->
<div class="navbar-menu">
    <nav class="navbar-end has-text-white">
        <?php if ($user) : ?>
            <a class="navbar-item login button is-success" href="<?=url("user/new-thread")?>">Skapa tråd</a>
            <a class="navbar-item login" href="<?=url("user/logout")?>">Logga ut</a>
            <a href="<?=url("user/profil/" . $user)?>">
                <span class="icon is-large has-text-success">
                    <i class="fas fa-lg fa-user"></i>
                </span>
            </a>
        <?php else : ?>
            <a class="navbar-item login" href="<?=url("user/login")?>">Login</a>
            <a class="navbar-item button is-success sign-up" href="<?=url("user/registrera")?>">Registrera</a>
        <?php endif; ?>
    </nav>
</div>