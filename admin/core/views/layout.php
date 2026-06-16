<?php
global $slugFields, $hideInAdd, $hideInEdit;
if (isset($slugFields)) {
    $hideInAdd = array_merge($hideInAdd ?? [], array_keys($slugFields));
    $hideInEdit = array_merge($hideInEdit ?? [], array_keys($slugFields));
}

require __DIR__ . '/../../../includes/admin/shell-start.php';
?>

<div class="admin-inner">
    <section class="admin-section">
        <div class="admin-section-head" style="margin-bottom: 20px; display:flex; justify-content:space-between; align-items:center;">
            <h2 class="admin-section-title"><?= htmlspecialchars($adminPageTitle ?? 'Manage Records') ?></h2>
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
