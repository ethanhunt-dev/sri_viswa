<?php
declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../includes/db.php';

$adminPageTitle = 'Change Password';
$adminNavActive = 'change_password';

$privs = get_menu_privileges(__FILE__);
if (!$privs['view']) {
    header('Location: ' . base_url('admin/home'));
    exit;
}

$message = '';
$isError = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPass = (string)($_POST['current_password'] ?? '');
    $newPass = (string)($_POST['new_password'] ?? '');
    $confirmPass = (string)($_POST['confirm_password'] ?? '');

    if ($currentPass === '' || $newPass === '' || $confirmPass === '') {
        $message = 'Please fill in all password fields.';
        $isError = true;
    } elseif ($newPass !== $confirmPass) {
        $message = 'New password and confirmation password do not match.';
        $isError = true;
    } elseif (strlen($newPass) < 6) {
        $message = 'New password must be at least 6 characters long.';
        $isError = true;
    } else {
        try {
            $pdo = db();
            $username = $_SESSION['admin_username'] ?? '';
            
            // Fetch the admin account from the database
            $stmt = $pdo->prepare("SELECT * FROM `admins` WHERE `username` = ? LIMIT 1");
            $stmt->execute([$username]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$admin || !password_verify($currentPass, $admin['password_hash'])) {
                $message = 'Current password is incorrect.';
                $isError = true;
            } else {
                // Update with new password hash
                $newHash = password_hash($newPass, PASSWORD_DEFAULT);
                $updateStmt = $pdo->prepare("UPDATE `admins` SET `password_hash` = ? WHERE `username` = ?");
                $updateStmt->execute([$newHash, $username]);
                
                header('Location: ' . base_url('admin/change_password?msg=success'));
                exit;
            }
        } catch (Throwable $e) {
            $message = 'Database Error: ' . $e->getMessage();
            $isError = true;
        }
    }
}

if (isset($_GET['msg']) && $_GET['msg'] === 'success') {
    $message = 'Password changed successfully!';
}

require __DIR__ . '/../includes/admin/shell-start.php';
?>

<div class="admin-inner">
    <section class="admin-section" style="max-width: 600px; margin: 0 auto;">
        
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

        <div class="admin-table-card" style="background:#fff; border-radius:12px; box-shadow:0 4px 16px rgba(0,0,0,0.06); padding:32px;">
            <form method="post" action="" style="display: flex; flex-direction: column; gap: 20px;">
                <h3 style="margin-top:0; margin-bottom: 8px; font-family:'Outfit', sans-serif; font-size: 1.25rem; color: #1e293b;">Change Admin Password</h3>
                <p style="color: #64748b; font-size: 14px; margin-top: 0; margin-bottom: 16px;">Keep your credentials secure. After changing your password, you will use the new password for future sign ins.</p>
                
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label for="current_password" style="font-size: 13px; font-weight: 600; color: #475569; font-family:'Outfit', sans-serif;">Current Password</label>
                    <input type="password" name="current_password" id="current_password" required style="padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; font-family: inherit;" />
                </div>
                
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label for="new_password" style="font-size: 13px; font-weight: 600; color: #475569; font-family:'Outfit', sans-serif;">New Password</label>
                    <input type="password" name="new_password" id="new_password" required minlength="6" style="padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; font-family: inherit;" />
                </div>
                
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label for="confirm_password" style="font-size: 13px; font-weight: 600; color: #475569; font-family:'Outfit', sans-serif;">Confirm New Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" required minlength="6" style="padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; font-family: inherit;" />
                </div>
                
                <div style="margin-top: 10px; display: flex; justify-content: flex-end;">
                    <button type="submit" class="admin-btn" style="background: #2563eb; color: #fff; border: 0; padding: 12px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2); font-family:'Outfit', sans-serif; font-size: 14px; width: 100%;">
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>

<?php require __DIR__ . '/../includes/admin/shell-end.php'; ?>
