<?php
/**
 * Configuration file for DI container.
 */
return [

    // Services to add to the container.
    "services" => [
        "weather" => [
            "shared" => true,
            "callback" => function () {
                $curl = $this->get("curl");
                $cfg = $this->get("configuration");
                $locationProvider = $this->get("location");
                $weather = new \Anax\Weather\DarkSky($locationProvider, $curl, $cfg);

                return $weather;
            }
        ],
    ],
];
