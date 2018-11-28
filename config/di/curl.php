<?php
/**
 * Configuration file for DI container.
 */
return [

    // Services to add to the container.
    "services" => [
        "curl" => [
            "shared" => true,
            "callback" => function () {
                $cache = $this->get("cache");
                $curl = new \Anax\Curl\Curl($cache);

                return $curl;
            }
        ],
    ],
];
