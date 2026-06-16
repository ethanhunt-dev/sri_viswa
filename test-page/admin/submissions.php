<?php
declare(strict_types=1);

require __DIR__ . '/auth.php';
require_once __DIR__ . '/../includes/db.php';

$adminPageTitle = 'All leads';
$adminNavActive = 'submissions';

$rows = [];
$dbError = '';

try {
    $pdo = db();
    $stmt = $pdo->query(
        'SELECT id, name, designation, company, country, email, mobile, product, quantity, remarks, created_at
         FROM contact_submissions
         ORDER BY created_at DESC, id DESC'
    );
    $rows = $stmt->fetchAll();
} catch (Throwable) {
    $dbError = 'Could not load submissions. Check the database connection and that sql/schema.sql was imported.';
}

require __DIR__ . '/includes/shell-start.php';
?>

<div class="admin-inner">
    <section class="admin-section">
        <p class="admin-lead"><?= count($rows) ?> submission<?= count($rows) === 1 ? '' : 's' ?> in the database.</p>

        <?php if ($dbError !== ''): ?>
            <div class="admin-alert admin-alert--error" role="alert"><?= htmlspecialchars($dbError) ?></div>
        <?php elseif ($rows === []): ?>
            <div class="admin-panel admin-panel--empty">
                <p class="admin-empty">No rows yet. New entries will show up here automatically.</p>
            </div>
        <?php else: ?>
            <div class="admin-table-card">
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Company</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>More</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $r): ?>
                                <tr>
                                    <td class="admin-td-nowrap"><?= htmlspecialchars((string) $r['created_at']) ?></td>
                                    <td><?= htmlspecialchars((string) $r['name']) ?></td>
                                    <td><a href="mailto:<?= htmlspecialchars((string) $r['email']) ?>"><?= htmlspecialchars((string) $r['email']) ?></a></td>
                                    <td><?= htmlspecialchars((string) $r['company']) ?></td>
                                    <td><?= htmlspecialchars((string) $r['product']) ?></td>
                                    <td><?= htmlspecialchars((string) $r['quantity']) ?></td>
                                    <td>
                                        <details class="admin-details">
                                            <summary>Details</summary>
                                            <dl class="admin-dl">
                                                <dt>Designation</dt>
                                                <dd><?= htmlspecialchars((string) $r['designation']) ?></dd>
                                                <dt>Country</dt>
                                                <dd><?= htmlspecialchars((string) ($r['country'] ?? '')) ?></dd>
                                                <dt>Mobile</dt>
                                                <dd><?= htmlspecialchars((string) ($r['mobile'] ?? '')) ?></dd>
                                                <dt>Remarks</dt>
                                                <dd><?= nl2br(htmlspecialchars((string) ($r['remarks'] ?? ''))) ?></dd>
                                            </dl>
                                        </details>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </section>
</div>

<?php require __DIR__ . '/includes/shell-end.php'; ?>
