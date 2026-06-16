<?php
declare(strict_types=1);

/**
 * MySQLi connection for save.php (same credentials as includes/config.php).
 */
$configPath = __DIR__ . '/includes/config.php';
if (!is_readable($configPath)) {
    throw new RuntimeException('Missing includes/config.php');
}

/** @var array{db: array{host:string,name:string,user:string,pass:string,charset?:string}} $cfg */
$cfg = require $configPath;
$db = $cfg['db'];

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$conn = new mysqli($db['host'], $db['user'], $db['pass'], $db['name']);
$charset = $db['charset'] ?? 'utf8mb4';
$conn->set_charset($charset);
