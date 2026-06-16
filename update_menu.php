<?php
require 'd:/xampp/htdocs/sri_viswa/includes/db.php';
$pdo = db();
try {
    // Set proper file_path for known titles if currently NULL or empty
    $map = [
        'Dashboard' => 'index.php',
        'All leads' => 'submissions.php',
        'Guide' => 'guide.php',
        'About Us' => 'about_us.php',
        'Main Menu' => null,
        'Sub Menu' => null,
    ];
    foreach ($map as $title => $path) {
        $stmt = $pdo->prepare(
            "UPDATE `main_menu` SET `file_path` = :path WHERE `title` = :title AND (`file_path` IS NULL OR `file_path` = '')"
        );
        $stmt->execute([':path' => $path, ':title' => $title]);
    }
    echo "file_path values fixed where needed";
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
