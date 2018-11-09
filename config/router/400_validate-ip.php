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
    ]
];
