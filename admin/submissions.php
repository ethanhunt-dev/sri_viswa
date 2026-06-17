<?php
declare(strict_types=1);

require __DIR__ . '/auth.php';
require_once __DIR__ . '/../includes/db.php';

// CSV Exporter for Leads Submissions
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    try {
        $pdo = db();
        $stmt = $pdo->query(
            'SELECT created_at, name, designation, company, country, email, mobile, product, quantity, remarks
             FROM contact_submissions
             ORDER BY created_at DESC, id DESC'
        );
        $allRows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (ob_get_level()) {
            ob_end_clean();
        }
        
        $filename = 'leads_export_' . date('Y-m-d') . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM
        
        fputcsv($output, ['Date', 'Name', 'Designation', 'Company', 'Country', 'Email', 'Mobile', 'Product', 'Quantity', 'Remarks']);
        
        foreach ($allRows as $row) {
            fputcsv($output, $row);
        }
        fclose($output);
        exit;
    } catch (Throwable $e) {
        exit("Export failed: " . $e->getMessage());
    }
}

$privs = get_menu_privileges(__FILE__);
if (!$privs['view']) {
    header("Location: home");
    exit;
}

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

require __DIR__ . '/../includes/admin/shell-start.php';
?>

<div class="admin-inner">
    <section class="admin-section">
        <div class="admin-section-head" style="margin-bottom: 20px; display:flex; justify-content:space-between; align-items:center;">
            <p class="admin-lead" style="margin:0;"><?= count($rows) ?> submission<?= count($rows) === 1 ? '' : 's' ?> in the database.</p>
            <a href="?export=csv" style="display: inline-block; background: #10b981; color: #fff; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: 600; font-family:'Outfit', sans-serif; font-size: 14px; box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);"><i class="fa-solid fa-file-excel" style="margin-right:8px;"></i>Export CSV</a>
        </div>

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

<?php require __DIR__ . '/../includes/admin/shell-end.php'; ?>
