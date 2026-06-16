<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$configPath = __DIR__ . '/../includes/config.php';
$config = is_readable($configPath) ? require $configPath : null;
$adminCfg = is_array($config) ? ($config['admin'] ?? null) : null;

$error = '';

if (!empty($_SESSION['admin_ok'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim((string) ($_POST['username'] ?? ''));
    $pass = (string) ($_POST['password'] ?? '');

    if (!is_array($adminCfg) || empty($adminCfg['password_hash']) || !is_string($adminCfg['password_hash'])) {
        $error = 'Admin login is not configured. Check includes/config.php.';
    } elseif ($user === '' || $pass === '') {
        $error = 'Enter username and password.';
    } elseif (!hash_equals((string) ($adminCfg['username'] ?? ''), $user)) {
        $error = 'Invalid username or password.';
    } elseif (!password_verify($pass, $adminCfg['password_hash'])) {
        $error = 'Invalid username or password.';
    } else {
        session_regenerate_id(true);
        $_SESSION['admin_ok'] = true;
        header('Location: index.php');
        exit;
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
    <link rel="stylesheet" href="../assets/css/site.css" />
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
                <p class="admin-login-sub">Use your dashboard username and password.</p>
                <?php if ($error !== ''): ?>
                    <div class="contact-error admin-login-error" role="alert"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <form class="admin-login-form" method="post" action="./login.php" autocomplete="current-password">
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
