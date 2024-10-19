<?php

try {
    $config = require_once __DIR__ . "/../config/database.php";
    $db = new PDO("{$config['driver']}:host={$config['host']};dbname={$config['dbname']}", $config['username'], $config['password']);
} catch (\PDOException $exception) {
    require_once __DIR__ . '/../components/db-connect-error.php';
    die();
}