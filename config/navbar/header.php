<?php
/**
 * Supply the basis for the navbar as an array.
 */
return [
    // Use for styling the menu
    "wrapper" => null,
    "class" => "my-navbar rm-default rm-desktop",

    // Here comes the menu items
    "items" => [
        [
            "text" => "Hem",
            "url" => "",
            "title" => "Första sidan, börja här.",
        ],
        [
            "text" => "Redovisning",
            "url" => "redovisning",
            "title" => "Redovisningstexter från kursmomenten.",
            "submenu" => [
                "items" => [
                    [
                        "text" => "Kmom01",
                        "url" => "redovisning/kmom01",
                        "title" => "Redovisning för kmom01.",
                    ],
                    [
                        "text" => "Kmom02",
                        "url" => "redovisning/kmom02",
                        "title" => "Redovisning för kmom02.",
                    ],
                ],
            ],
        ],
        [
            "text" => "Om",
            "url" => "om",
            "title" => "Om denna webbplats.",
        ],
        [
            "text" => "Validera IP",
            "url" => "ip",
            "title" => "Validera",
        ],
        [
            "text" => "IP-Plats",
            "url" => "location",
            "title" => "IP-location",
        ],
        [
            "text" => "Väder",
            "url" => "weather",
            "title" => "Weather",
        ],
        [
            "text" => "Böcker",
            "url" => "book",
            "title" => "Böcker",
        ],
        [
            "text" => "API",
            "url" => "api",
            "title" => "API",
        ],
    ],
];
