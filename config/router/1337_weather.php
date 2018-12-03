<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Weather from IP-address",
            "mount" => "weather",
            "handler" => "\Anax\WeatherService\WeatherController",
        ]
    ]
];
