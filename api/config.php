<?php
$dbHost = 'localhost';
$dbName = 'apidevelopers';
$dbUser = 'root';
$dbPass = '';

$pdo = new \PDO("mysql:dbname={$dbName};host={$dbHost}", $dbUser, $dbPass);

$array = [
    'error' => '',
    'result' => []
];