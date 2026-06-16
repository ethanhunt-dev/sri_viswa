<?php
declare(strict_types=1);

require __DIR__ . '/auth.php';
require_once __DIR__ . '/../includes/db.php';

$adminPageTitle = 'Overview';
$adminNavActive = 'dashboard';

$total = 0;
$weekCount = 0;
$totalProducts = 0;
$totalIndustries = 0;
$totalMilestones = 0;
$totalMainMenu = 0;
$totalSubMenu = 0;
$recent = [];
$dbError = '';

try {
    $pdo = db();
    
    // 1. Total Enquiries
    $total = (int) $pdo->query('SELECT COUNT(*) FROM contact_submissions')->fetchColumn();
    
    // 2. Last 7 Days
    $weekCount = (int) $pdo->query(
        'SELECT COUNT(*) FROM contact_submissions WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)'
    )->fetchColumn();

    // 3. Total Products
    try {
        $totalProducts = (int) $pdo->query('SELECT COUNT(*) FROM products')->fetchColumn();
    } catch (Throwable $e) {
        $totalProducts = 0;
    }

    // 4. Total Industries
    try {
        $totalIndustries = (int) $pdo->query('SELECT COUNT(*) FROM industries')->fetchColumn();
    } catch (Throwable $e) {
        $totalIndustries = 0;
    }

    // 5. Total Milestones
    try {
        $totalMilestones = (int) $pdo->query('SELECT COUNT(*) FROM year')->fetchColumn();
    } catch (Throwable $e) {
        $totalMilestones = 0;
    }

    // 6. Total Main Menu
    try {
        $totalMainMenu = (int) $pdo->query('SELECT COUNT(*) FROM main_menu')->fetchColumn();
    } catch (Throwable $e) {
        $totalMainMenu = 0;
    }

    // 7. Total Sub Menu
    try {
        $totalSubMenu = (int) $pdo->query('SELECT COUNT(*) FROM sub_menu')->fetchColumn();
    } catch (Throwable $e) {
        $totalSubMenu = 0;
    }

} catch (Throwable $e) {
    $dbError = 'Could not load dashboard data. Confirm the database is set up (sql/schema.sql).';
}

// Load developer mode configuration
$configPath = __DIR__ . '/../includes/config.php';
$config = is_readable($configPath) ? require $configPath : [];
$developerMode = (bool) ($config['developer_mode'] ?? false);

require __DIR__ . '/../includes/admin/shell-start.php';
?>

<div class="admin-inner">
    <?php if (isset($_SESSION['login_msg'])): ?>
        <div id="flash-message" class="admin-alert admin-alert--success" role="alert" style="margin-bottom: 20px; padding: 15px; border-radius: 4px; background:#def7ec; color:#03543f; transition: opacity 0.5s ease;">
            <?= htmlspecialchars($_SESSION['login_msg']) ?>
        </div>
        <script>
            setTimeout(() => {
                const flash = document.getElementById('flash-message');
                if (flash) {
                    flash.style.opacity = '0';
                    setTimeout(() => flash.style.display = 'none', 500);
                }
            }, 5000);
        </script>
        <?php unset($_SESSION['login_msg']); ?>
    <?php endif; ?>
    <?php if ($dbError !== ''): ?>
        <div class="admin-alert admin-alert--error" role="alert"><?= htmlspecialchars($dbError) ?></div>
    <?php else: ?>
        <section class="admin-section" aria-labelledby="stats-heading">
            <h2 id="stats-heading" class="admin-section-title">At a glance</h2>
            
            <div class="admin-dashboard-grid">
                <?php
                // Construct the full list of potential cards
                $cards = [
                    [
                        'title' => 'Contact Enquiries',
                        'href' => './submissions.php',
                        'ico' => 'fa-envelope',
                        'value' => $total,
                        'theme' => 'blue',
                        'file' => 'submissions.php'
                    ],
                    [
                        'title' => 'Last 7 Days',
                        'href' => './submissions.php',
                        'ico' => 'fa-calendar-week',
                        'value' => $weekCount,
                        'theme' => 'green',
                        'file' => 'submissions.php'
                    ],
                    [
                        'title' => 'Products List',
                        'href' => './products.php',
                        'ico' => 'fa-boxes-packing',
                        'value' => $totalProducts,
                        'theme' => 'purple',
                        'file' => 'products.php'
                    ],
                    [
                        'title' => 'Industries',
                        'href' => './industries.php',
                        'ico' => 'fa-industry',
                        'value' => $totalIndustries,
                        'theme' => 'orange',
                        'file' => 'industries.php'
                    ],
                    [
                        'title' => 'Milestone Years',
                        'href' => './year.php',
                        'ico' => 'fa-history',
                        'value' => $totalMilestones,
                        'theme' => 'red',
                        'file' => 'year.php'
                    ]
                ];

                if ($developerMode) {
                    $cards[] = [
                        'title' => 'Main Menu',
                        'href' => './main_menu.php',
                        'ico' => 'fa-bars',
                        'value' => $totalMainMenu,
                        'theme' => 'cyan',
                        'file' => 'main_menu.php'
                    ];
                    $cards[] = [
                        'title' => 'Sub Menu',
                        'href' => './sub_menu.php',
                        'ico' => 'fa-indent',
                        'value' => $totalSubMenu,
                        'theme' => 'pink',
                        'file' => 'sub_menu.php'
                    ];
                }

                // Filter cards by visibility privilege
                $visibleCards = [];
                foreach ($cards as $card) {
                    $privs = get_menu_privileges($card['file']);
                    if ($privs['view']) {
                        $visibleCards[] = $card;
                    }
                }

                $numCards = count($visibleCards);
                foreach ($visibleCards as $index => $card) {
                    // Calculate span class dynamically
                    if ($numCards === 1) {
                        $spanClass = 'admin-card-btn--span12';
                    } elseif ($numCards === 2) {
                        $spanClass = 'admin-card-btn--span6';
                    } elseif ($numCards === 3) {
                        $spanClass = 'admin-card-btn--span4';
                    } elseif ($numCards === 4) {
                        $spanClass = 'admin-card-btn--span3';
                    } elseif ($numCards === 5) {
                        $spanClass = ($index < 3) ? 'admin-card-btn--span4' : 'admin-card-btn--span6';
                    } elseif ($numCards === 6) {
                        $spanClass = 'admin-card-btn--span4';
                    } elseif ($numCards === 7) {
                        $spanClass = ($index < 4) ? 'admin-card-btn--span3' : 'admin-card-btn--span4';
                    } else {
                        $spanClass = 'admin-card-btn--span4';
                    }
                    ?>
                    <a class="admin-card-btn <?= htmlspecialchars($spanClass) ?> admin-card-btn--<?= htmlspecialchars($card['theme']) ?>" href="<?= htmlspecialchars($card['href']) ?>">
                        <div class="admin-card-btn-ico"><i class="fa-solid <?= htmlspecialchars($card['ico']) ?>"></i></div>
                        <span class="admin-card-btn-title"><?= htmlspecialchars($card['title']) ?></span>
                        <span class="admin-card-btn-value"><?= htmlspecialchars((string)$card['value']) ?></span>
                    </a>
                    <?php
                }
                ?>
            </div>
        </section>

    <?php endif; ?>
</div>

<?php require __DIR__ . '/../includes/admin/shell-end.php'; ?>
