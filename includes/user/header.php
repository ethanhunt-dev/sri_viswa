<?php
declare(strict_types=1);

require_once __DIR__ . '/../db.php';

/** @var array{brand:string,tagline:string} $site */
/** @var array<int,array{label:string,href:string}> $nav */
/** @var ?array<int,array{label:string,href:string}> $productSubmenu */
/** @var ?string $pageTitle */
/** @var ?string $metaDescription */
/** @var ?string $metaKeywords */
/** @var ?string $canonical */
/** @var ?string $robots */

$isHomePage = basename((string) ($_SERVER['SCRIPT_NAME'] ?? ''), '.php') === 'index';
$brandHref = $isHomePage ? '#home' : base_url('index.php#home');

$siteSettings = get_row("SELECT * FROM `site_settings` LIMIT 1");
$logoUrl = !empty($siteSettings['logo']) ? base_url($siteSettings['logo']) : base_url('assets/images/logo.png');

if (!isset($productSubmenu)) {
    $productSubmenu = [];
    try {
        $dbProds = get_result("SELECT `product_name`, `slug` FROM `products` ORDER BY `id` ASC");
        foreach ($dbProds as $dp) {
            $slug = $dp['slug'];
            $href = 'product/' . $slug;
            if ($slug === 'colour-masterbatches' || $slug === 'colour-masterbatch') {
                $href = 'colour-masterbatch';
            } elseif ($slug === 'white-masterbatches' || $slug === 'white-masterbatch') {
                $href = 'white-masterbatch';
            } elseif ($slug === 'additive-masterbatches') {
                $href = 'additive-masterbatches';
            } elseif ($slug === 'filler-masterbatches') {
                $href = 'filler-masterbatches';
            }
            $productSubmenu[] = [
                'label' => $dp['product_name'],
                'href' => $href
            ];
        }
    } catch (Throwable $e) {
        $productSubmenu = [
            ['label' => 'Colour Masterbatches', 'href' => 'colour-masterbatch'],
            ['label' => 'White Masterbatches', 'href' => 'white-masterbatch'],
            ['label' => 'Additive Masterbatches', 'href' => 'additive-masterbatches'],
            ['label' => 'Filler Masterbatches', 'href' => 'filler-masterbatches'],
        ];
    }
}

$metaDescription = isset($metaDescription) ? trim((string) $metaDescription) : '';
$metaKeywords = isset($metaKeywords) ? trim((string) $metaKeywords) : '';
$robots = isset($robots) ? trim((string) $robots) : 'index,follow';
$canonical = isset($canonical) ? trim((string) $canonical) : '';

if ($canonical === '') {
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = (string) ($_SERVER['HTTP_HOST'] ?? '');
    $uri = (string) ($_SERVER['REQUEST_URI'] ?? '');
    $path = preg_replace('/\?.*$/', '', $uri) ?? $uri;
    if ($host !== '') {
        $canonical = $scheme . '://' . $host . $path;
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= htmlspecialchars($pageTitle ?? $site['brand']) ?></title>
    <meta name="description" content="<?= htmlspecialchars($metaDescription !== '' ? $metaDescription : 'Masterbatch manufacturing: colour, additive, white and filler masterbatches.') ?>" />
    <?php if ($metaKeywords !== ''): ?>
        <meta name="keywords" content="<?= htmlspecialchars($metaKeywords) ?>" />
    <?php endif; ?>
    <?php if ($canonical !== ''): ?>
        <link rel="canonical" href="<?= htmlspecialchars($canonical) ?>" />
    <?php endif; ?>
    <meta name="robots" content="<?= htmlspecialchars($robots !== '' ? $robots : 'index,follow') ?>" />

    <link rel="icon" type="image/png" href="<?= base_url('assets/images/fev.png') ?>" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Outfit:wght@500;600;700;800;900&display=swap" rel="stylesheet" />

    <link rel="preconnect" href="https://cdnjs.cloudflare.com" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= base_url('assets/css/site.css?v=' . filemtime(__DIR__ . '/../../assets/css/site.css')) ?>" />
    <?php if (isset($pageSchema) && $pageSchema !== ''): ?>
        <?= $pageSchema ?>
    <?php endif; ?>
</head>
<body>
    <a class="skip" href="#main">Skip to content</a>

    <header id="home" class="site-header">
        <div class="container-fluid header-inner">
            <a class="brand" href="<?= htmlspecialchars($brandHref) ?>" aria-label="<?= htmlspecialchars($site['brand']) ?>">
                <img class="brand-logo" src="<?= htmlspecialchars($logoUrl) ?>" alt="<?= htmlspecialchars($site['brand']) ?>" />
            </a>

            <button class="nav-toggle" type="button" aria-controls="site-nav" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <i class="fa-solid fa-bars"></i>
            </button>

            <nav id="site-nav" class="site-nav" aria-label="Primary">
                <?php foreach ($nav as $item): ?>
                    <?php if ($item['label'] === 'Products'): ?>
                        <div class="nav-dropdown" data-nav-dropdown>
                            <button
                                type="button"
                                class="nav-link nav-link--products nav-dropdown__toggle"
                                id="nav-products-toggle"
                                aria-expanded="false"
                                aria-controls="products-submenu"
                                aria-haspopup="true"
                            style="padding: 14px 14px ;">
                                <?= htmlspecialchars($item['label']) ?>
                                <i class="fa-solid fa-chevron-down nav-chevron" aria-hidden="true"></i>
                            </button>
                            <div class="nav-dropdown-drop" id="products-submenu" role="region" aria-label="Product categories">
                                <ul class="nav-dropdown-panel" role="list">
                                    <?php foreach ($productSubmenu as $sub): ?>
                                        <li>
                                            <a class="nav-dropdown-link" href="<?= htmlspecialchars(base_url(ltrim($sub['href'], './'))) ?>"><?= htmlspecialchars($sub['label']) ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php else: ?>
                        <a class="nav-link" href="<?= htmlspecialchars(base_url(ltrim($item['href'], './'))) ?>"><?= htmlspecialchars($item['label']) ?></a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </nav>
        </div>
    </header>
    <div id="nav-backdrop" class="nav-backdrop" hidden aria-hidden="true"></div>
