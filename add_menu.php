<?php
require 'd:/xampp/htdocs/sri_viswa/includes/db.php';
$pdo = db();
try {
    $stmt = $pdo->prepare("INSERT INTO `main_menu` (`title`, `file_path`, `icon`, `sort_order`) VALUES (:title, :file_path, :icon, :sort_order)");
    $stmt->execute([
        ':title' => 'About Us',
        ':file_path' => 'about_us.php',
        ':icon' => 'fa-address-card',
        ':sort_order' => 4,
    ]);
    echo "About Us menu item inserted successfully.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
