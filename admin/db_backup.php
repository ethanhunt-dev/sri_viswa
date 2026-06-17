<?php
declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../includes/db.php';

// Check if user has view privilege
$dbPrivs = get_menu_privileges(__FILE__);
if (!$dbPrivs['view']) {
    header("Location: home");
    exit;
}

try {
    $pdo = db();
    
    // Set headers for download
    $dbName = '';
    $configPath = __DIR__ . '/../includes/config.php';
    if (is_readable($configPath)) {
        $config = require $configPath;
        $dbName = $config['db']['name'] ?? 'database';
    } else {
        $dbName = 'database';
    }
    
    $filename = $dbName . '_backup_' . date('Y-m-d_H-i-s') . '.sql';
    
    header('Content-Type: application/sql');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Pragma: no-cache');
    header('Expires: 0');
    
    // Disable output buffering if active
    if (ob_get_level()) {
        ob_end_clean();
    }
    
    // Get all tables
    $tables = [];
    $stmt = $pdo->query("SHOW TABLES");
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        $tables[] = $row[0];
    }
    
    echo "-- SRI VASAVI Database Backup\n";
    echo "-- Generated: " . date('Y-m-d H:i:s') . "\n";
    echo "-- Database: `" . $dbName . "`\n\n";
    echo "SET FOREIGN_KEY_CHECKS=0;\n\n";
    
    foreach ($tables as $table) {
        // 1. Structure
        echo "-- Table structure for table `" . $table . "`\n";
        echo "DROP TABLE IF EXISTS `" . $table . "`;\n";
        
        $createStmt = $pdo->query("SHOW CREATE TABLE `" . $table . "`");
        $createRow = $createStmt->fetch(PDO::FETCH_ASSOC);
        echo $createRow['Create Table'] . ";\n\n";
        
        // 2. Data
        echo "-- Dumping data for table `" . $table . "`\n";
        $dataStmt = $pdo->query("SELECT * FROM `" . $table . "`");
        
        while ($rowData = $dataStmt->fetch(PDO::FETCH_ASSOC)) {
            $keys = array_map(function($key) {
                return "`" . $key . "`";
            }, array_keys($rowData));
            
            $values = array_map(function($value) use ($pdo) {
                if ($value === null) {
                    return 'NULL';
                }
                return $pdo->quote((string)$value);
            }, array_values($rowData));
            
            echo "INSERT INTO `" . $table . "` (" . implode(', ', $keys) . ") VALUES (" . implode(', ', $values) . ");\n";
        }
        echo "\n\n";
    }
    
    echo "SET FOREIGN_KEY_CHECKS=1;\n";
    exit;
    
} catch (Throwable $e) {
    if (headers_sent()) {
        echo "\n-- ERROR: " . $e->getMessage() . "\n";
    } else {
        header('Content-Type: text/html');
        header('Content-Disposition: inline');
        echo "<h3>Database Backup Error</h3>";
        echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
        echo "<a href='./home'>Return to Admin Panel</a>";
    }
    exit;
}
