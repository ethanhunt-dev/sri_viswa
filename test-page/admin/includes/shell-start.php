<?php
declare(strict_types=1);

/** @var string $adminPageTitle */
/** @var string $adminNavActive dashboard|submissions|guide */

$navActive = $adminNavActive ?? '';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= htmlspecialchars($adminPageTitle) ?> — SRI VASAVI Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/css/site.css" />
</head>
<body class="admin-body admin-body--app">
    <div class="admin-app">
        <aside class="admin-sidebar" aria-label="Admin navigation">
            <a class="admin-sidebar-logo" href="./index.php">
                <span class="admin-sidebar-logo-text">SRI VASAVI</span>
                <span class="admin-sidebar-logo-sub">Admin</span>
            </a>
            <nav class="admin-nav" aria-label="Primary">
                <a class="admin-nav-link<?= $navActive === 'dashboard' ? ' is-active' : '' ?>" href="./index.php">
                    <span class="admin-nav-ico" aria-hidden="true"><i class="fa-solid fa-gauge-high"></i></span>
                    Dashboard
                </a>
                <a class="admin-nav-link<?= $navActive === 'submissions' ? ' is-active' : '' ?>" href="./submissions.php">
                    <span class="admin-nav-ico" aria-hidden="true"><i class="fa-solid fa-inbox"></i></span>
                    All leads
                </a>
                <a class="admin-nav-link<?= $navActive === 'guide' ? ' is-active' : '' ?>" href="./guide.php">
                    <span class="admin-nav-ico" aria-hidden="true"><i class="fa-solid fa-circle-question"></i></span>
                    Guide
                </a>
            </nav>
            <div class="admin-sidebar-foot">
                <a class="admin-sidebar-site" href="../index.php" target="_blank" rel="noopener noreferrer">
                    <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i> View website
                </a>
            </div>
        </aside>

        <div class="admin-app-main">
            <header class="admin-topbar">
                <div class="admin-topbar-text">
                    <p class="admin-topbar-kicker">Contact enquiries</p>
                    <h1 class="admin-topbar-title"><?= htmlspecialchars($adminPageTitle) ?></h1>
                </div>
                <div class="admin-topbar-actions">
                    <a class="admin-btn admin-btn--ghost" href="../contact.php" target="_blank" rel="noopener noreferrer">Contact form</a>
                    <a class="admin-btn admin-btn--ghost" href="./logout.php">Log out</a>
                </div>
            </header>

            <main class="admin-page" id="main">
