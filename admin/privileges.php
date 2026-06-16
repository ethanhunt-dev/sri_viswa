<?php
declare(strict_types=1);

require __DIR__ . '/auth.php';
require_once __DIR__ . '/../includes/db.php';

$adminPageTitle = 'Menu Privileges';
$adminNavActive = '';

$message = '';
$isError = false;

try {
    $pdo = db();
    
    // Ensure table exists
    $pdo->exec("CREATE TABLE IF NOT EXISTS `menu_privileges` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `menu_type` VARCHAR(10) NOT NULL,
        `menu_item_id` INT NOT NULL,
        `can_view` TINYINT(1) DEFAULT 1,
        `can_add` TINYINT(1) DEFAULT 1,
        `can_update` TINYINT(1) DEFAULT 1,
        `can_delete` TINYINT(1) DEFAULT 1,
        UNIQUE KEY `uk_menu_item` (`menu_type`, `menu_item_id`)
    )");
    
    // Fetch all main menus & sub menus to process POST data
    $mainMenusList = $pdo->query("SELECT id, title FROM main_menu ORDER BY sort_order ASC, id ASC")->fetchAll(PDO::FETCH_ASSOC);
    $subMenusList = $pdo->query("SELECT id, main_menu_id, title FROM sub_menu ORDER BY sort_order ASC, id ASC")->fetchAll(PDO::FETCH_ASSOC);

    // Process form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $stmt = $pdo->prepare("INSERT INTO `menu_privileges` (`menu_type`, `menu_item_id`, `can_view`, `can_add`, `can_update`, `can_delete`) 
                               VALUES (?, ?, ?, ?, ?, ?)
                               ON DUPLICATE KEY UPDATE `can_view` = ?, `can_add` = ?, `can_update` = ?, `can_delete` = ?");
        
        // Save Main Menu privileges
        foreach ($mainMenusList as $mm) {
            $id = (int)$mm['id'];
            $canView = isset($_POST["main_{$id}_view"]) ? 1 : 0;
            $canAdd = isset($_POST["main_{$id}_add"]) ? 1 : 0;
            $canUpdate = isset($_POST["main_{$id}_update"]) ? 1 : 0;
            $canDelete = isset($_POST["main_{$id}_delete"]) ? 1 : 0;
            
            $stmt->execute([
                'main', $id, $canView, $canAdd, $canUpdate, $canDelete,
                $canView, $canAdd, $canUpdate, $canDelete
            ]);
        }

        // Save Sub Menu privileges
        foreach ($subMenusList as $sm) {
            $id = (int)$sm['id'];
            $canView = isset($_POST["sub_{$id}_view"]) ? 1 : 0;
            $canAdd = isset($_POST["sub_{$id}_add"]) ? 1 : 0;
            $canUpdate = isset($_POST["sub_{$id}_update"]) ? 1 : 0;
            $canDelete = isset($_POST["sub_{$id}_delete"]) ? 1 : 0;
            
            $stmt->execute([
                'sub', $id, $canView, $canAdd, $canUpdate, $canDelete,
                $canView, $canAdd, $canUpdate, $canDelete
            ]);
        }
        
        header("Location: privileges.php?msg=updated");
        exit;
    }
    
    if (isset($_GET['msg']) && $_GET['msg'] === 'updated') {
        $message = 'Privileges updated successfully!';
    }
    
    // Fetch current privileges from DB
    $stmt = $pdo->query("SELECT * FROM `menu_privileges`");
    $rawPrivs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $privileges = ['main' => [], 'sub' => []];
    foreach ($rawPrivs as $rp) {
        $privileges[$rp['menu_type']][$rp['menu_item_id']] = [
            'view' => (bool)$rp['can_view'],
            'add' => (bool)$rp['can_add'],
            'update' => (bool)$rp['can_update'],
            'delete' => (bool)$rp['can_delete']
        ];
    }
    
} catch (Throwable $e) {
    $message = 'Error: ' . $e->getMessage();
    $isError = true;
}

require __DIR__ . '/../includes/admin/shell-start.php';
?>

<div class="admin-inner">
    <section class="admin-section">
        
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

        <form method="post" action="">
            <div class="admin-table-card" style="background:#fff; border-radius:8px; box-shadow:0 1px 3px rgba(0,0,0,0.1); padding:20px;">
                <h3 style="margin-top:0; margin-bottom: 20px; font-family:'Outfit', sans-serif;">Configure Menu Permissions</h3>
                <div class="admin-table-wrap" style="overflow-x: auto;">
                    <table class="admin-table" style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
                        <thead style="background: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                            <tr>
                                <th style="padding: 12px; font-weight: 600; color:#374151;">Main Menu</th>
                                <th style="padding: 12px; font-weight: 600; color:#374151;">Sub Menu</th>
                                <th style="padding: 12px; font-weight: 600; color:#374151; text-align: center;">Menu Privilege</th>
                                <th style="padding: 12px; font-weight: 600; color:#374151; text-align: center;">Add Privilege</th>
                                <th style="padding: 12px; font-weight: 600; color:#374151; text-align: center;">Edit Privilege</th>
                                <th style="padding: 12px; font-weight: 600; color:#374151; text-align: center;">Delete Privilege</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($mainMenusList as $mm): ?>
                                <?php 
                                    $mmId = (int)$mm['id'];
                                    $mPriv = $privileges['main'][$mmId] ?? ['view' => true, 'add' => true, 'update' => true, 'delete' => true];
                                    
                                    // Fetch child sub menus for this main menu
                                    $childSubs = array_filter($subMenusList, function($sm) use ($mmId) {
                                        return (int)$sm['main_menu_id'] === $mmId;
                                    });
                                ?>
                                <!-- Main Menu Row -->
                                <tr style="border-bottom: 1px solid #e5e7eb; background: #fdfdfd;">
                                    <td style="padding: 12px; font-weight: 700; color: #1a2b3d;"><?= htmlspecialchars($mm['title']) ?></td>
                                    <td style="padding: 12px; color: #7a8a9e;">—</td>
                                    <td style="padding: 12px; text-align: center;">
                                        <input type="checkbox" name="main_<?= $mmId ?>_view" value="1" <?= $mPriv['view'] ? 'checked' : '' ?> style="transform: scale(1.2); cursor: pointer;" />
                                    </td>
                                    <td style="padding: 12px; text-align: center;">
                                        <input type="checkbox" name="main_<?= $mmId ?>_add" value="1" <?= $mPriv['add'] ? 'checked' : '' ?> style="transform: scale(1.2); cursor: pointer;" />
                                    </td>
                                    <td style="padding: 12px; text-align: center;">
                                        <input type="checkbox" name="main_<?= $mmId ?>_update" value="1" <?= $mPriv['update'] ? 'checked' : '' ?> style="transform: scale(1.2); cursor: pointer;" />
                                    </td>
                                    <td style="padding: 12px; text-align: center;">
                                        <input type="checkbox" name="main_<?= $mmId ?>_delete" value="1" <?= $mPriv['delete'] ? 'checked' : '' ?> style="transform: scale(1.2); cursor: pointer;" />
                                    </td>
                                </tr>
                                
                                <!-- Child Sub Menu Rows -->
                                <?php foreach ($childSubs as $sm): ?>
                                    <?php 
                                        $smId = (int)$sm['id'];
                                        $sPriv = $privileges['sub'][$smId] ?? ['view' => true, 'add' => true, 'update' => true, 'delete' => true];
                                    ?>
                                    <tr style="border-bottom: 1px solid #e5e7eb;">
                                        <td style="padding: 12px; color: #7a8a9e; padding-left: 30px;">└─</td>
                                        <td style="padding: 12px; color: #4b5563; font-weight: 500;"><?= htmlspecialchars($sm['title']) ?></td>
                                        <td style="padding: 12px; text-align: center;">
                                            <input type="checkbox" name="sub_<?= $smId ?>_view" value="1" <?= $sPriv['view'] ? 'checked' : '' ?> style="transform: scale(1.2); cursor: pointer;" />
                                        </td>
                                        <td style="padding: 12px; text-align: center;">
                                            <input type="checkbox" name="sub_<?= $smId ?>_add" value="1" <?= $sPriv['add'] ? 'checked' : '' ?> style="transform: scale(1.2); cursor: pointer;" />
                                        </td>
                                        <td style="padding: 12px; text-align: center;">
                                            <input type="checkbox" name="sub_<?= $smId ?>_update" value="1" <?= $sPriv['update'] ? 'checked' : '' ?> style="transform: scale(1.2); cursor: pointer;" />
                                        </td>
                                        <td style="padding: 12px; text-align: center;">
                                            <input type="checkbox" name="sub_<?= $smId ?>_delete" value="1" <?= $sPriv['delete'] ? 'checked' : '' ?> style="transform: scale(1.2); cursor: pointer;" />
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div style="margin-top: 20px; display: flex; justify-content: flex-end;">
                    <button type="submit" class="admin-btn" style="background: #2563eb; color: #fff; border: 0; padding: 10px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);">
                        Save Privileges
                    </button>
                </div>
            </div>
        </form>
    </section>
</div>

<?php require __DIR__ . '/../includes/admin/shell-end.php'; ?>
