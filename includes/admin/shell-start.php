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
    // Migrate old privileges table structure if present
    try {
        $sidebarPdo->query("SELECT menu_name FROM menu_privileges LIMIT 1");
        $sidebarPdo->exec("DROP TABLE `menu_privileges`");
    } catch (Throwable $t) {}

    // Create menu_privileges table
    $sidebarPdo->exec("CREATE TABLE IF NOT EXISTS `menu_privileges` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `menu_type` VARCHAR(10) NOT NULL,
        `menu_item_id` INT NOT NULL,
        `can_view` TINYINT(1) DEFAULT 1,
        `can_add` TINYINT(1) DEFAULT 1,
        `can_update` TINYINT(1) DEFAULT 1,
        `can_delete` TINYINT(1) DEFAULT 1,
        UNIQUE KEY `uk_menu_item` (`menu_type`, `menu_item_id`)
    )");

    // Create admins table
    $sidebarPdo->exec("CREATE TABLE IF NOT EXISTS `admins` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `username` VARCHAR(50) NOT NULL UNIQUE,
        `password_hash` VARCHAR(255) NOT NULL,
        `allowed_ip` VARCHAR(45) DEFAULT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

    $adminsCount = $sidebarPdo->query("SELECT COUNT(*) FROM `admins`")->fetchColumn();
    if ($adminsCount == 0) {
        $configPath = __DIR__ . '/../config.php';
        $config = is_readable($configPath) ? require $configPath : [];
        $adminCfg = $config['admin'] ?? [
            'username' => 'admin',
            'password_hash' => '$2y$10$wYUHTlQWyxbf4JkJb44CYOjgJHwF.hp5/qQTwOJTtOOURtolBaBMC'
        ];
        $stmt = $sidebarPdo->prepare("INSERT INTO `admins` (`username`, `password_hash`) VALUES (?, ?)");
        $stmt->execute([$adminCfg['username'], $adminCfg['password_hash']]);
    }
    // Seed default entries if tables are empty
    $mainCount = $sidebarPdo->query("SELECT COUNT(*) FROM `main_menu`")->fetchColumn();
    if ($mainCount == 0) {
        $sidebarPdo->exec("INSERT INTO `main_menu` (`title`, `file_path`, `icon`, `sort_order`) VALUES
            ('Dashboard', 'index.php', 'fa-gauge-high', 1),
            ('All leads', 'submissions.php', 'fa-inbox', 2),
            ('Guide', 'guide.php', 'fa-circle-question', 3),
            ('About Us', 'about_us.php', 'fa-address-card', 4),
            ('Main Menu', 'main_menu.php', 'fa-list', 5),
            ('Sub Menu', 'sub_menu.php', 'fa-indent', 6),
            ('Change Password', 'change_password.php', 'fa-key', 7)");
    } else {
        $cpExists = $sidebarPdo->query("SELECT COUNT(*) FROM `main_menu` WHERE `file_path` = 'change_password.php'")->fetchColumn();
        if (!$cpExists) {
            $sidebarPdo->exec("INSERT INTO `main_menu` (`title`, `file_path`, `icon`, `sort_order`) VALUES ('Change Password', 'change_password.php', 'fa-key', 7)");
        }
    }

    // Clean up separate Home Page / Hero Banners main menu entries to avoid duplication
    $sidebarPdo->exec("DELETE FROM `main_menu` WHERE `file_path` IN ('home_page.php', 'home_banners.php')");

    // Self-healing: Check and restore a single Home Page parent group if missing
    $homeMenuId = $sidebarPdo->query("SELECT `id` FROM `main_menu` WHERE `title` = 'Home Page' AND `file_path` IS NULL")->fetchColumn();
    if (!$homeMenuId) {
        $stmt = $sidebarPdo->prepare("INSERT INTO `main_menu` (`title`, `file_path`, `icon`, `sort_order`) VALUES (?, ?, ?, ?)");
        $stmt->execute(['Home Page', NULL, 'fa-house', 2]);
        $homeMenuId = $sidebarPdo->lastInsertId();
        
        // Re-adjust sort order of subsequent items
        $sidebarPdo->exec("UPDATE `main_menu` SET `sort_order` = `sort_order` + 1 WHERE `sort_order` >= 2 AND `id` != " . (int)$homeMenuId);
    } else {
        $homeMenuId = (int)$homeMenuId;
    }

    if ($homeMenuId) {
        // Check & insert Home Page Settings submenu
        $pageSubExists = $sidebarPdo->prepare("SELECT COUNT(*) FROM `sub_menu` WHERE `main_menu_id` = ? AND `file_path` = 'home_page.php'");
        $pageSubExists->execute([$homeMenuId]);
        if ($pageSubExists->fetchColumn() == 0) {
            $stmt = $sidebarPdo->prepare("INSERT INTO `sub_menu` (`main_menu_id`, `title`, `file_path`, `icon`, `sort_order`) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$homeMenuId, 'Home Page Settings', 'home_page.php', 'fa-file-lines', 1]);
        }
        
        // Check & insert Hero Banners submenu
        $bannerSubExists = $sidebarPdo->prepare("SELECT COUNT(*) FROM `sub_menu` WHERE `main_menu_id` = ? AND `file_path` = 'home_banners.php'");
        $bannerSubExists->execute([$homeMenuId]);
        if ($bannerSubExists->fetchColumn() == 0) {
            $stmt = $sidebarPdo->prepare("INSERT INTO `sub_menu` (`main_menu_id`, `title`, `file_path`, `icon`, `sort_order`) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$homeMenuId, 'Hero Banners', 'home_banners.php', 'fa-images', 2]);
        }
    }

    // Self-healing: Check and restore DB Backup menu if missing
    $backupMenuExists = $sidebarPdo->query("SELECT COUNT(*) FROM `main_menu` WHERE `file_path` = 'db_backup.php'")->fetchColumn();
    if (!$backupMenuExists) {
        $maxSort = (int)$sidebarPdo->query("SELECT MAX(sort_order) FROM `main_menu`")->fetchColumn();
        $stmt = $sidebarPdo->prepare("INSERT INTO `main_menu` (`title`, `file_path`, `icon`, `sort_order`) VALUES (?, ?, ?, ?)");
        $stmt->execute(['DB Backup', 'db_backup.php', 'fa-database', $maxSort + 1]);
    }

    // Load config to check developer mode
    $configPath = __DIR__ . '/../config.php';
    $config = is_readable($configPath) ? require $configPath : [];
    $developerMode = (bool) ($config['developer_mode'] ?? false);

    // Fetch menus for sidebar (hide Main Menu and Sub Menu management pages from sidebar if not in developer mode)
    if ($developerMode) {
        $stmt = $sidebarPdo->query("SELECT * FROM `main_menu` ORDER BY `sort_order` ASC, `id` ASC");
    } else {
        $stmt = $sidebarPdo->query("SELECT * FROM `main_menu` WHERE file_path NOT IN ('main_menu.php', 'sub_menu.php') ORDER BY `sort_order` ASC, `id` ASC");
    }
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

    // Fetch privileges to filter sidebar links dynamically
    $privMap = ['main' => [], 'sub' => []];
    try {
        $privRows = $sidebarPdo->query("SELECT menu_type, menu_item_id, can_view FROM `menu_privileges`")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($privRows as $row) {
            $privMap[$row['menu_type']][$row['menu_item_id']] = (bool)$row['can_view'];
        }
    } catch (Throwable $t) {
        // Table might not exist yet
    }

    // Filter main menus: skip any where can_view is false
    $mainMenus = array_filter($mainMenus, function($mm) use ($privMap) {
        $id = (int)$mm['id'];
        if (isset($privMap['main'][$id]) && !$privMap['main'][$id]) {
            return false;
        }
        return true;
    });

    // Filter sub menus: skip any where can_view is false
    $childrenMenus = array_filter($childrenMenus, function($cm) use ($privMap) {
        $id = (int)$cm['id'];
        if (isset($privMap['sub'][$id]) && !$privMap['sub'][$id]) {
            return false;
        }
        return true;
    });

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
    <link rel="stylesheet" href="../assets/css/site.css?v=<?= filemtime(__DIR__ . '/../../assets/css/site.css') ?>" />
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Dropdown navigation group toggle logic
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

            // Sidebar toggle logic (State is persisted in localStorage)
            const adminApp = document.querySelector('.admin-app');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebarOverlay = document.getElementById('sidebar-overlay');

            // Restore state on load (for desktop sizes)
            if (window.innerWidth >= 880) {
                const isCollapsed = localStorage.getItem('admin-sidebar-collapsed') === 'true';
                if (isCollapsed) {
                    adminApp.classList.add('sidebar-collapsed');
                }
            }

            function toggleSidebar() {
                if (window.innerWidth >= 880) {
                    adminApp.classList.toggle('sidebar-collapsed');
                    const collapsed = adminApp.classList.contains('sidebar-collapsed');
                    localStorage.setItem('admin-sidebar-collapsed', collapsed);
                } else {
                    adminApp.classList.toggle('sidebar-open');
                }
            }

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    toggleSidebar();
                });
            }

            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function() {
                    adminApp.classList.remove('sidebar-open');
                });
            }
        });
    </script>
</head>
<body class="admin-body admin-body--app">
    <div class="admin-app">
        <div class="admin-sidebar-overlay" id="sidebar-overlay"></div>
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
            <header class="admin-topbar" style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                <div class="admin-topbar-left" style="display: flex; align-items: center; gap: 16px;">
                    <button id="sidebar-toggle" class="admin-topbar-toggle-btn" aria-label="Toggle Sidebar">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <div class="admin-topbar-text">
                        <h1 class="admin-topbar-title"><?= htmlspecialchars($adminPageTitle) ?></h1>
                    </div>
                </div>
                <div class="admin-topbar-actions" style="display: flex; align-items: center; gap: 12px;">
                    <span style="font-family: 'Outfit', sans-serif; font-size: 14px; color: #4a5a6e; font-weight: 600;"><i class="fa-solid fa-user" style="margin-right: 6px; color: var(--brand);"></i>Hi Admin</span>
                    <a class="admin-btn admin-btn--ghost" href="./logout.php"><i class="fa-solid fa-right-from-bracket" style="margin-right: 6px;"></i>Log out</a>
                </div>
            </header>

            <main class="admin-page" id="main">
