<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../includes/db.php';

$error = '';

if (!empty($_SESSION['admin_ok'])) {
    header('Location: ' . base_url('admin/home'));
    exit;
}

// Check if dynamic IP (DIP) mode is activated
$isDipMode = isset($_GET['dip']) && $_GET['dip'] === '1';

if (isset($_GET['error'])) {
    if ($_GET['error'] === 'ip_changed') {
        $error = 'Your IP address has changed. Please authorize again using the Dynamic IP (DIP) URL.';
    } elseif ($_GET['error'] === 'unauthorized_ip') {
        $error = 'Access denied: Unauthorized IP address. Please authorize again using the Dynamic IP (DIP) URL.';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim((string) ($_POST['username'] ?? ''));
    $pass = (string) ($_POST['password'] ?? '');
    
    // Support POST form re-submission maintaining DIP flag
    $isDipMode = $isDipMode || (isset($_POST['dip']) && $_POST['dip'] === '1');

    if ($user === '' || $pass === '') {
        $error = 'Enter username and password.';
    } else {
        try {
            $pdo = db();
            // Fetch account from admins table
            $stmt = $pdo->prepare("SELECT * FROM `admins` WHERE `username` = ? LIMIT 1");
            $stmt->execute([$user]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$admin) {
                $error = 'Invalid username or password.';
            } elseif (!password_verify($pass, $admin['password_hash'])) {
                $error = 'Invalid username or password.';
            } else {
                $ip = $_SERVER['REMOTE_ADDR'] ?? '';
                
                if ($isDipMode) {
                    // Update IP in DB
                    $updateStmt = $pdo->prepare("UPDATE `admins` SET `allowed_ip` = ? WHERE `username` = ?");
                    $updateStmt->execute([$ip, $user]);
                    
                    // Set success message for Dashboard display
                    $_SESSION['login_msg'] = 'now u have acces to admin admin';
                } else {
                    // Check if IP matches stored IP (if set)
                    if ($admin['allowed_ip'] !== null && $admin['allowed_ip'] !== $ip) {
                        $error = 'Access denied: Unauthorized IP address. Please use the Dynamic IP (DIP) URL to authorize this IP.';
                    }
                }

                if (empty($error)) {
                    session_regenerate_id(true);
                    $_SESSION['admin_ok'] = true;
                    $_SESSION['admin_username'] = $user;
                    header('Location: ' . base_url('admin/home'));
                    exit;
                }
            }
        } catch (Throwable $e) {
            $error = 'Database Error: ' . $e->getMessage();
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin login — SRI VASAVI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url('assets/css/site.css') ?>" />
</head>
<body class="admin-body">
    <main class="admin-login-wrap">
        <div class="admin-login-brand">
            <h1 class="admin-login-brand-title">SRI VASAVI</h1>
            <p class="admin-login-brand-text">Sign in to manage contact enquiries, view leads, and use the admin guide.</p>
        </div>
        <div class="admin-login-aside">
            <div class="admin-login-card">
                <h2 class="admin-login-title">Admin sign in</h2>
                <?php if ($isDipMode): ?>
                    <p class="admin-login-sub" style="color: #45C463; font-weight: 600;">Dynamic IP (DIP) Authorization Mode Active</p>
                <?php else: ?>
                    <p class="admin-login-sub">Use your dashboard username and password.</p>
                <?php endif; ?>
                <?php if ($error !== ''): ?>
                    <div class="contact-error admin-login-error" role="alert"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <form class="admin-login-form" method="post" action="" autocomplete="current-password">
                    <?php if ($isDipMode): ?>
                        <input type="hidden" name="dip" value="1" />
                    <?php endif; ?>
                    <label class="form-field">
                        <span class="form-label">Username</span>
                        <input class="form-input" name="username" required autocomplete="username" />
                    </label>
                    <label class="form-field">
                        <span class="form-label">Password</span>
                        <input class="form-input" type="password" name="password" required autocomplete="current-password" />
                    </label>
                    <button class="form-submit" type="submit">Sign in</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
