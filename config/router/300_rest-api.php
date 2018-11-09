<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "REST API",
            "mount" => "api",
            "handler" => "\Anax\RestApi\RestApiController",
        ],
    ]
];
