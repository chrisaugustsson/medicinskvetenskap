<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Validate IP-address",
            "mount" => "ip",
            "handler" => "\Anax\IpValidator\IpValidatorController",
        ],
        [
            "info" => "Location from IP-address",
            "mount" => "location",
            "handler" => "\Anax\IpLocation\LocationController",
        ],
    ]
];
