<?php
declare(strict_types=1);

function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $cfgPath = __DIR__ . '/config.php';
    if (!is_readable($cfgPath)) {
        throw new RuntimeException('Database config missing: includes/config.php');
    }

    /** @var array{db: array{host:string,name:string,user:string,pass:string,charset:string}} $config */
    $config = require $cfgPath;
    $db = $config['db'];
    $dsn = sprintf(
        'mysql:host=%s;dbname=%s;charset=%s',
        $db['host'],
        $db['name'],
        $db['charset']
    );
    $pdo = new PDO($dsn, $db['user'], $db['pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    return $pdo;
}

/**
 * Fetch a single row as an associative array.
 * Similar to CodeIgniter 3's $query->row_array()
 *
 * @param string $sql The SQL query to execute.
 * @param array $params Optional parameters to bind to the statement.
 * @return array|null The row as an associative array, or null if no row is found.
 */
function get_row(string $sql, array $params = []): ?array
{
    try {
        $pdo = db();
        if (empty($params)) {
            $stmt = $pdo->query($sql);
        } else {
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
        }
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    } catch (Throwable $e) {
        return null;
    }
}

/**
 * Fetch all matching rows as an array of associative arrays.
 * Similar to CodeIgniter 3's $query->result_array()
 *
 * @param string $sql The SQL query to execute.
 * @param array $params Optional parameters to bind to the statement.
 * @return array An array of matching rows, or an empty array on failure or no matches.
 */
function get_result(string $sql, array $params = []): array
{
    try {
        $pdo = db();
        if (empty($params)) {
            $stmt = $pdo->query($sql);
        } else {
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Throwable $e) {
        return [];
    }
}

/**
 * Generate a base URL for assets and links.
 *
 * @param string $path Optional path to append to the base URL.
 * @return string The absolute base URL.
 */
function base_url(string $path = ''): string
{
    static $base = null;
    if ($base === null) {
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $script = $_SERVER['SCRIPT_NAME'] ?? '';
        
        $dir = dirname($script);
        $dir = str_replace('\\', '/', $dir);
        
        // If we are calling this from within the admin folder, move up one directory
        if (basename($dir) === 'admin') {
            $dir = dirname($dir);
            $dir = str_replace('\\', '/', $dir);
        }
        
        $dir = rtrim($dir, '/');
        $base = $scheme . '://' . $host . $dir . '/';
    }
    
    $cleanPath = ltrim($path, '/');
    if ($cleanPath === 'index.php') {
        $cleanPath = '';
    } elseif (strpos($cleanPath, 'index.php#') === 0) {
        $cleanPath = str_replace('index.php#', '#', $cleanPath);
    }
    
    if (strpos($cleanPath, '.php') !== false) {
        $cleanPath = preg_replace('/\.php(?=\/|\?|#|$)/', '', $cleanPath);
    }
    
    return $base . $cleanPath;
}

/**
 * Fetch CRUD privileges for a specific page based on its filename.
 */
function get_menu_privileges(string $filePath): array
{
    $default = ['view' => true, 'add' => true, 'update' => true, 'delete' => true];
    try {
        $pdo = db();
        
        // Ensure menu_privileges table exists
        $pdo->exec("CREATE TABLE IF NOT EXISTS `menu_privileges` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `menu_type` VARCHAR(10) NOT NULL,
            `menu_item_id` INT NOT NULL,
            `can_view` TINYINT(1) DEFAULT 1,
            `can_add` TINYINT(1) DEFAULT 1,
            `can_update` TINYINT(1) DEFAULT 1,
            `can_delete` TINYINT(1) DEFAULT 1,
            UNIQUE KEY `uk_menu_item` (`menu_type`, `menu_item_id`)
        )");
        
        // Clean file path to base filename
        $filename = basename($filePath);
        
        // First check in sub_menu
        $sub = get_row("SELECT id FROM sub_menu WHERE file_path = ? LIMIT 1", [$filename]);
        if ($sub) {
            $priv = get_row("SELECT can_view, can_add, can_update, can_delete FROM menu_privileges WHERE menu_type = 'sub' AND menu_item_id = ? LIMIT 1", [(int)$sub['id']]);
            if ($priv) {
                return [
                    'view' => (bool)$priv['can_view'],
                    'add' => (bool)$priv['can_add'],
                    'update' => (bool)$priv['can_update'],
                    'delete' => (bool)$priv['can_delete']
                ];
            }
            return $default;
        }
        
        // Then check in main_menu
        $main = get_row("SELECT id FROM main_menu WHERE file_path = ? LIMIT 1", [$filename]);
        if ($main) {
            $priv = get_row("SELECT can_view, can_add, can_update, can_delete FROM menu_privileges WHERE menu_type = 'main' AND menu_item_id = ? LIMIT 1", [(int)$main['id']]);
            if ($priv) {
                return [
                    'view' => (bool)$priv['can_view'],
                    'add' => (bool)$priv['can_add'],
                    'update' => (bool)$priv['can_update'],
                    'delete' => (bool)$priv['can_delete']
                ];
            }
            return $default;
        }
        
        return $default;
    } catch (Throwable $e) {
        return $default;
    }
}


