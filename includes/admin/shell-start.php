<?php
declare(strict_types=1);

/** @var string $adminPageTitle */
/** @var string $adminNavActive */

$adminPageTitle = $adminPageTitle ?? 'Admin Panel';
$adminNavActive = $adminNavActive ?? '';
$navActive = $adminNavActive;

$mainMenus = [];
try {
    require_once __DIR__ . '/../db.php';
    $sidebarPdo = db();
    
    // Auto-create/seed tables if missing
    // Create main_menu table
    $sidebarPdo->exec("CREATE TABLE IF NOT EXISTS `main_menu` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `title` VARCHAR(100) NOT NULL,
        `file_path` VARCHAR(255) DEFAULT NULL,
        `icon` VARCHAR(50) DEFAULT 'fa-circle-question',
        `sort_order` INT DEFAULT 0,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    // Create sub_menu table
    $sidebarPdo->exec("CREATE TABLE IF NOT EXISTS `sub_menu` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `main_menu_id` INT NOT NULL,
        `title` VARCHAR(100) NOT NULL,
        `file_path` VARCHAR(255) DEFAULT NULL,
        `icon` VARCHAR(50) DEFAULT 'fa-circle-question',
        `sort_order` INT DEFAULT 0,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (`main_menu_id`) REFERENCES `main_menu`(`id`) ON DELETE CASCADE
    )");
    // Seed default entries if tables are empty
    $mainCount = $sidebarPdo->query("SELECT COUNT(*) FROM `main_menu`")->fetchColumn();
    if ($mainCount == 0) {
        $sidebarPdo->exec("INSERT INTO `main_menu` (`title`, `file_path`, `icon`, `sort_order`) VALUES
            ('Dashboard', 'index.php', 'fa-gauge-high', 1),
            ('All leads', 'submissions.php', 'fa-inbox', 2),
            ('Guide', 'guide.php', 'fa-circle-question', 3),
            ('About Us', 'about_us.php', 'fa-address-card', 4),
            ('Main Menu', 'main_menu.php', 'fa-list', 5),
            ('Sub Menu', 'sub_menu.php', 'fa-indent', 6)");
    }

    // Fetch menus for sidebar
    $stmt = $sidebarPdo->query("SELECT * FROM `main_menu` ORDER BY `sort_order` ASC, `id` ASC");
    $mainMenus = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Ensure file_path key exists
    foreach ($mainMenus as &$mm) {
        if (!array_key_exists('file_path', $mm)) {
            $mm['file_path'] = '';
        }
    }
    unset($mm);

    $childrenStmt = $sidebarPdo->query("SELECT * FROM `sub_menu` ORDER BY `sort_order` ASC, `id` ASC");
    $childrenMenus = $childrenStmt->fetchAll(PDO::FETCH_ASSOC);
    // Ensure file_path key exists for sub menus
    foreach ($childrenMenus as &$cm) {
        if (!array_key_exists('file_path', $cm)) {
            $cm['file_path'] = '';
        }
    }
    unset($cm);
    // Attach children to their main menu
    foreach ($childrenMenus as $child) {
        $pId = $child['main_menu_id'];
        foreach ($mainMenus as &$mm) {
            if ($mm['id'] == $pId) {
                $mm['children'][] = $child;
                break;
            }
        }
        unset($mm);
    }
    // Ensure every main menu has a children array
    foreach ($mainMenus as &$mm) {
        if (!isset($mm['children'])) $mm['children'] = [];
    }
    unset($mm);

} catch (Throwable $e) {
    // Fail-safe default fallback
    $mainMenus = [
        ['id' => 1, 'title' => 'Dashboard', 'file_path' => 'index.php', 'icon' => 'fa-gauge-high', 'children' => []],
        ['id' => 2, 'title' => 'All leads', 'file_path' => 'submissions.php', 'icon' => 'fa-inbox', 'children' => []],
        ['id' => 3, 'title' => 'Guide', 'file_path' => 'guide.php', 'icon' => 'fa-circle-question', 'children' => []]
    ];
}


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= htmlspecialchars($adminPageTitle) ?> — SRI VASAVI Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/css/site.css" />
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.admin-nav-toggle-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const subNav = this.nextElementSibling;
                    const chevron = this.querySelector('.nav-grp-chevron');
                    if (subNav.style.display === 'none' || !subNav.style.display) {
                        subNav.style.display = 'flex';
                        chevron.style.transform = 'rotate(180deg)';
                    } else {
                        subNav.style.display = 'none';
                        chevron.style.transform = 'rotate(0deg)';
                    }
                });
            });
        });
    </script>
</head>
<body class="admin-body admin-body--app">
    <div class="admin-app">
        <aside class="admin-sidebar" aria-label="Admin navigation">
            <a class="admin-sidebar-logo" href="./index.php">
                <span class="admin-sidebar-logo-text">SRI VASAVI</span>
                <span class="admin-sidebar-logo-sub">Admin</span>
            </a>
            <nav class="admin-nav" aria-label="Primary">
                <?php foreach ($mainMenus as $menu): ?>
                    <?php
                        $hasChildren = !empty($menu['children']);
                        $isActive = ($navActive === str_replace('.php', '', (string)$menu['file_path']));
                        
                        $childActive = false;
                        if ($hasChildren) {
                            foreach ($menu['children'] as $child) {
                                if ($navActive === str_replace('.php', '', (string)$child['file_path'])) {
                                    $childActive = true;
                                    break;
                                }
                            }
                        }
                    ?>
                    <?php if (!$hasChildren): ?>
                        <?php $menuHref = !empty($menu['file_path']) ? './' . htmlspecialchars($menu['file_path']) : '#'; ?>
                        <a class="admin-nav-link<?= $isActive ? ' is-active' : '' ?>" href="<?= $menuHref ?>">
                            <span class="admin-nav-ico" aria-hidden="true"><i class="fa-solid <?= htmlspecialchars($menu['icon'] ?? 'fa-circle-question') ?>"></i></span>
                            <?= htmlspecialchars($menu['title']) ?>
                        </a>
                    <?php else: ?>
                        <div class="admin-nav-group" style="width: 100%;">
                            <button class="admin-nav-link admin-nav-toggle-btn<?= $isActive || $childActive ? ' is-active' : '' ?>" style="background: none; border: none; width: 100%; text-align: left; cursor: pointer; display: flex; justify-content: space-between; align-items: center;" type="button">
                                <span style="display: flex; align-items: center; gap: 12px;">
                                    <span class="admin-nav-ico" aria-hidden="true"><i class="fa-solid <?= htmlspecialchars($menu['icon'] ?? 'fa-bars') ?>"></i></span>
                                    <?= htmlspecialchars($menu['title']) ?>
                                </span>
                                <i class="fa-solid fa-chevron-down nav-grp-chevron" style="font-size: 10px; transition: transform 0.2s; <?= $childActive || $isActive ? 'transform: rotate(180deg);' : '' ?>"></i>
                            </button>
                            <div class="admin-sub-nav" style="display: <?= $childActive || $isActive ? 'flex' : 'none' ?>; padding-left: 20px; flex-direction: column; gap: 2px; margin-top: 2px; width: 100%;">
                                <?php foreach ($menu['children'] as $child): ?>
                                    <?php $isChildActive = ($navActive === str_replace('.php', '', (string)$child['file_path'])); ?>
                                    <?php $childHref = !empty($child['file_path']) ? './' . htmlspecialchars($child['file_path']) : '#'; ?>
                                    <a class="admin-nav-link<?= $isChildActive ? ' is-active' : '' ?>" href="<?= $childHref ?>" style="padding: 8px 14px; font-size: 13px;">
                                        <span class="admin-nav-ico" aria-hidden="true"><i class="fa-solid <?= htmlspecialchars($child['icon'] ?? 'fa-circle-question') ?>"></i></span>
                                        <?= htmlspecialchars($child['title']) ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </nav>
            <div class="admin-sidebar-foot">
                <a class="admin-sidebar-site" href="../index.php" target="_blank" rel="noopener noreferrer">
                    <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i> View website
                </a>
            </div>
        </aside>

        <div class="admin-app-main">
            <header class="admin-topbar">
                <div class="admin-topbar-text">
                    <p class="admin-topbar-kicker">Contact enquiries</p>
                    <h1 class="admin-topbar-title"><?= htmlspecialchars($adminPageTitle) ?></h1>
                </div>
                <div class="admin-topbar-actions">
                    <a class="admin-btn admin-btn--ghost" href="../contact.php" target="_blank" rel="noopener noreferrer">Contact form</a>
                    <a class="admin-btn admin-btn--ghost" href="./logout.php">Log out</a>
                </div>
            </header>

            <main class="admin-page" id="main">
