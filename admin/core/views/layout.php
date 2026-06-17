<?php
global $slugFields, $hideInAdd, $hideInEdit;
if (isset($slugFields)) {
    $hideInAdd = array_merge($hideInAdd ?? [], array_keys($slugFields));
    $hideInEdit = array_merge($hideInEdit ?? [], array_keys($slugFields));
}

// Central CSV Exporter for all CRUD Tables
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    if (ob_get_level()) {
        ob_end_clean();
    }
    
    $allRows = $model->getPaginated(1, 1000000); // Fetch all records
    $filename = ($tableName ?? 'data') . '_export_' . date('Y-m-d') . '.csv';
    
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    
    $output = fopen('php://output', 'w');
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM for Excel support
    
    $headers = [];
    foreach ($schema as $col) {
        $colName = $col['Field'];
        if (isset($hideInList) && in_array($colName, $hideInList)) continue;
        $headers[] = isset($displayNames[$colName]) ? $displayNames[$colName] : ucwords(str_replace('_', ' ', $colName));
    }
    fputcsv($output, $headers);
    
    foreach ($allRows as $row) {
        $csvRow = [];
        foreach ($schema as $col) {
            $colName = $col['Field'];
            if (isset($hideInList) && in_array($colName, $hideInList)) continue;
            
            $val = (string)($row[$colName] ?? '');
            if ($val && (strtolower($colName) === 'created_at' || strtolower($colName) === 'updated_at' || strpos(strtolower($col['Type']), 'datetime') !== false || strpos(strtolower($col['Type']), 'timestamp') !== false)) {
                $val = date('Y-m-d H:i:s', strtotime($val));
            }
            if (strpos($val, '<img') !== 0) {
                $val = strip_tags($val);
            }
            $csvRow[] = $val;
        }
        fputcsv($output, $csvRow);
    }
    fclose($output);
    exit;
}

require __DIR__ . '/../../../includes/admin/shell-start.php';
?>

<div class="admin-inner">
    <section class="admin-section">
        <div class="admin-section-head" style="margin-bottom: 20px; display:flex; justify-content:flex-end; align-items:center; gap: 10px;">
            <a href="?export=csv" style="display: <?= (isset($_GET['add']) || !empty($editData)) ? 'none' : 'inline-block' ?>; background: #10b981; color: #fff; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: 600; font-family:'Outfit', sans-serif; font-size: 14px; box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);"><i class="fa-solid fa-file-excel" style="margin-right:8px;"></i>Export CSV</a>
            <?php if (!empty($privs['add'])): ?>
                <a href="?add=1" id="add-btn" style="display: <?= (isset($_GET['add']) || !empty($editData)) ? 'none' : 'inline-block' ?>; background: #2563eb; color: #fff; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: 600; font-family:'Outfit', sans-serif; font-size: 14px; box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);">+ Add <?= htmlspecialchars(str_replace('Manage ', '', $adminPageTitle ?? 'Record')) ?></a>
            <?php endif; ?>
        </div>
        
        <?php if (!empty($message)): ?>
            <div id="flash-message" class="admin-alert <?= !empty($isError) ? 'admin-alert--error' : 'admin-alert--success' ?>" role="alert" style="margin-bottom: 20px; padding: 15px; border-radius: 4px; <?= !empty($isError) ? 'background:#fde8e8;color:#c81e1e;' : 'background:#def7ec;color:#03543f;' ?>; transition: opacity 0.5s ease;">
                <?= htmlspecialchars($message) ?>
            </div>
            <script>
                setTimeout(() => {
                    const flash = document.getElementById('flash-message');
                    if (flash) {
                        flash.style.opacity = '0';
                        setTimeout(() => flash.style.display = 'none', 500);
                    }
                }, 3000);
            </script>
        <?php endif; ?>
        
        <?php if (!empty($schema)): ?>
            <!-- Render Views -->
            <?php if (!empty($editData) && !empty($privs['update'])): ?>
                <?php require __DIR__ . '/edit.php'; ?>
            <?php elseif (empty($editData) && isset($_GET['add']) && !empty($privs['add'])): ?>
                <?php require __DIR__ . '/add.php'; ?>
            <?php endif; ?>
            
            <?php require __DIR__ . '/list.php'; ?>
        <?php endif; ?>
        
    </section>
</div>

<?php require __DIR__ . '/../../../includes/admin/shell-end.php'; ?>
