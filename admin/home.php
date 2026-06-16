<?php
declare(strict_types=1);

require __DIR__ . '/auth.php';
require_once __DIR__ . '/../includes/db.php';

$adminPageTitle = 'Overview';
$adminNavActive = 'dashboard';

$total = 0;
$weekCount = 0;
$recent = [];
$dbError = '';

try {
    $pdo = db();
    $total = (int) $pdo->query('SELECT COUNT(*) FROM contact_submissions')->fetchColumn();
    $weekCount = (int) $pdo->query(
        'SELECT COUNT(*) FROM contact_submissions WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)'
    )->fetchColumn();
    $stmt = $pdo->query(
        'SELECT id, name, company, email, product, quantity, created_at
         FROM contact_submissions
         ORDER BY created_at DESC, id DESC
         LIMIT 5'
    );
    $recent = $stmt->fetchAll();
} catch (Throwable) {
    $dbError = 'Could not load dashboard data. Confirm the database is set up (sql/schema.sql).';
}

require __DIR__ . '/../includes/admin/shell-start.php';
?>

<div class="admin-inner">
    <?php if ($dbError !== ''): ?>
        <div class="admin-alert admin-alert--error" role="alert"><?= htmlspecialchars($dbError) ?></div>
    <?php else: ?>
        <section class="admin-section" aria-labelledby="stats-heading">
            <h2 id="stats-heading" class="admin-section-title">At a glance</h2>
            <div class="admin-stat-grid">
                <article class="admin-stat-card">
                    <div class="admin-stat-card-ico" aria-hidden="true"><i class="fa-solid fa-paper-plane"></i></div>
                    <div class="admin-stat-card-body">
                        <p class="admin-stat-label">Total enquiries</p>
                        <p class="admin-stat-value"><?= $total ?></p>
                    </div>
                </article>
                <article class="admin-stat-card admin-stat-card--accent">
                    <div class="admin-stat-card-ico" aria-hidden="true"><i class="fa-solid fa-calendar-week"></i></div>
                    <div class="admin-stat-card-body">
                        <p class="admin-stat-label">Last 7 days</p>
                        <p class="admin-stat-value"><?= $weekCount ?></p>
                    </div>
                </article>
                <a class="admin-stat-card admin-stat-card--link" href="./submissions.php">
                    <div class="admin-stat-card-ico" aria-hidden="true"><i class="fa-solid fa-table-list"></i></div>
                    <div class="admin-stat-card-body">
                        <p class="admin-stat-label">Browse all</p>
                        <p class="admin-stat-action">Open full list <i class="fa-solid fa-chevron-right" aria-hidden="true"></i></p>
                    </div>
                </a>
            </div>
        </section>

        <section class="admin-section" aria-labelledby="recent-heading">
            <div class="admin-section-head">
                <h2 id="recent-heading" class="admin-section-title">Recent enquiries</h2>
                <a class="admin-link-more" href="./submissions.php">View all</a>
            </div>

            <?php if ($recent === []): ?>
                <div class="admin-panel admin-panel--empty">
                    <p class="admin-empty">No submissions yet. They will appear here when visitors use the <a href="../contact.php">contact form</a>.</p>
                </div>
            <?php else: ?>
                <ul class="admin-recent-list" role="list">
                    <?php foreach ($recent as $r): ?>
                        <li class="admin-recent-item">
                            <div class="admin-recent-main">
                                <span class="admin-recent-name"><?= htmlspecialchars((string) $r['name']) ?></span>
                                <span class="admin-recent-co"><?= htmlspecialchars((string) $r['company']) ?></span>
                            </div>
                            <div class="admin-recent-meta">
                                <span class="admin-recent-product"><?= htmlspecialchars((string) $r['product']) ?></span>
                                <span class="admin-recent-date"><?= htmlspecialchars((string) $r['created_at']) ?></span>
                            </div>
                            <a class="admin-recent-mail" href="mailto:<?= htmlspecialchars((string) $r['email']) ?>">Email</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../includes/admin/shell-end.php'; ?>
