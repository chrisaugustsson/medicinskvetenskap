<?php
/**
 * Config file for Database.
 *
 * Example for MySQL.
 *  "dsn" => "mysql:host=localhost;dbname=test;",
 *  "username" => "test",
 *  "password" => "test",
 *  "driver_options"  => [\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"],
 *
 * Example for SQLite.
 *  "dsn" => "sqlite:memory::",
 *
 */
if (isset($_SERVER["SERVER_NAME"]) && $_SERVER["SERVER_NAME"] === "www.student.bth.se") {
    return [
        "dsn"             => "mysql:host=blu-ray.student.bth.se;dbname=chau17",
        "username"        => "chau17",
        "password"        => "gZwauCHDALik",
        "driver_options"  => [\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"],
        "fetch_mode"      => \PDO::FETCH_OBJ,
        "table_prefix"    => null,
        "session_key"     => "Anax\Database",

        // True to be very verbose during development
        "verbose"         => false,

        // True to be verbose on connection failed
        "debug_connect"   => false,
    ];
}

return [
    "dsn"              => "mysql:host=localhost;dbname=anaxdb;",
    "username"         => "anax",
    "password"         => "anax",
    "driver_options"   => [\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"],
    "fetch_mode"       => \PDO::FETCH_OBJ,
    "table_prefix"     => null,
    "session_key"      => "Anax\Database",
    "emulate_prepares" => false,

    // True to be very verbose during development
    "verbose"         => null,

    // True to be verbose on connection failed
    "debug_connect"   => false,
];
