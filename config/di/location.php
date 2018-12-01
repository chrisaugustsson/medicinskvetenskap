<?php
/**
 * Configuration file for DI container.
 */
return [

    // Services to add to the container.
    "services" => [
        "location" => [
            "shared" => true,
            "callback" => function () {
                $curl = $this->get("curl");
                $cfg = $this->get("configuration");

                $location = new \Anax\IpLocation\Ipstack($curl, $cfg);

                return $location;
            }
        ],
    ],
];
