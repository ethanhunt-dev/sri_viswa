<?php
require_once __DIR__ . '/includes/db.php';

try {
    $pdo = db();
    
    // Check if the sub_menu item already exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM `sub_menu` WHERE `file_path` = ?");
    $stmt->execute(['additive_masterbatches.php']);
    $exists = (int)$stmt->fetchColumn() > 0;
    
    if (!$exists) {
        // Insert into sub_menu
        $stmt = $pdo->prepare("INSERT INTO `sub_menu` (`main_menu_id`, `title`, `file_path`, `icon`, `sort_order`, `created_at`) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->execute([9, 'Additive Range', 'additive_masterbatches.php', 'fa-solid fa-list-check', 4]);
        $subId = $pdo->lastInsertId();
        echo "Inserted sub_menu item 'Additive Range' with ID $subId.\n";
        
        // Explicitly insert into menu_privileges
        $stmt = $pdo->prepare("INSERT INTO `menu_privileges` (`menu_type`, `menu_item_id`, `can_view`, `can_add`, `can_update`, `can_delete`) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute(['sub', $subId, 1, 1, 1, 1]);
        echo "Inserted menu privileges for the sub_menu item.\n";
    } else {
        echo "Sub_menu item 'Additive Range' already exists.\n";
    }
} catch (Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
