<?php
require 'd:/xampp/htdocs/sri_viswa/includes/db.php';
$pdo = db();

$defaults = [
    ['title' => 'Dashboard',      'file_path' => 'index.php',          'icon' => 'fa-gauge-high',      'sort_order' => 1],
    ['title' => 'All leads',      'file_path' => 'submissions.php',    'icon' => 'fa-inbox',           'sort_order' => 2],
    ['title' => 'Guide',          'file_path' => 'guide.php',          'icon' => 'fa-circle-question','sort_order' => 3],
    ['title' => 'About Us',       'file_path' => 'about_us.php',       'icon' => 'fa-address-card',   'sort_order' => 4],
    ['title' => 'Main Menu',      'file_path' => null,                 'icon' => 'fa-list',            'sort_order' => 5],
    ['title' => 'Sub Menu',       'file_path' => null,                 'icon' => 'fa-indent',          'sort_order' => 6],
];

foreach ($defaults as $m) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM `main_menu` WHERE `title` = :title");
    $stmt->execute([':title' => $m['title']]);
    $exists = $stmt->fetchColumn();
    if (!$exists) {
        $insert = $pdo->prepare(
            "INSERT INTO `main_menu` (`title`, `file_path`, `icon`, `sort_order`) VALUES (:title, :file_path, :icon, :sort_order)"
        );
        $insert->execute([
            ':title'      => $m['title'],
            ':file_path'  => $m['file_path'],
            ':icon'       => $m['icon'],
            ':sort_order' => $m['sort_order'],
        ]);
        echo "Inserted {$m['title']}\n";
    }
}
?>
