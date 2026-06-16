<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/db.php';

$slug = $_GET['slug'] ?? '';
if (empty($slug)) {
    header('Location: ' . base_url('index.php'));
    exit;
}

// Fetch product details
$product = get_row('SELECT * FROM `products` WHERE `slug` = ?', [$slug]);
if (!$product) {
    header('Location: ' . base_url('index.php'));
    exit;
}

// Fetch benefits
$benefits = get_result('SELECT * FROM `benefits` WHERE `product_id` = ? ORDER BY `id` ASC', [$product['id']]);

$site = [
    'brand' => 'SRI VASAVI',
    'tagline' => 'Delivering Polymer Solutions since 2007',
];

$pageTitle = $product['product_name'] . ' — ' . $site['brand'];
$metaDescription = strip_tags((string)($product['description'] ?? ''));
$robots = 'index,follow';

$nav = [
    ['label' => 'Home', 'href' => './index.php'],
    ['label' => 'About Us', 'href' => './about.php'],
    ['label' => 'Industries', 'href' => './industries.php'],
    ['label' => 'R & D', 'href' => './rd.php'],
    ['label' => 'Products', 'href' => './index.php#products'],
    ['label' => 'Contact Us', 'href' => './contact.php'],
];

// Why choose us section content (same as static pages)
$fillerWhy = [
    ['text' => 'Uncompromising quality in all of our products.', 'icon' => 'assets/images/Uncompromising.png'],
    ['text' => 'Customized solutions to address industry specific challenges.', 'icon' => 'assets/images/Highly.png'],
    ['text' => 'Cost-effective masterbatches without compromising on functionality.', 'icon' => 'assets/images/Cost.png'],
    ['text' => 'Comprehensive technical support for seamless processing.', 'icon' => 'assets/images/Comprehensive.png'],
];

// Dynamically choose hero class based on slug/modifier
$heroClass = 'cm-hero';
if (strpos($slug, 'white') !== false) {
    $heroClass = 'cm-hero cm-hero--white';
} elseif (strpos($slug, 'additive') !== false) {
    $heroClass = 'cm-hero cm-hero--additive';
} elseif (strpos($slug, 'filler') !== false) {
    $heroClass = 'cm-hero cm-hero--filler';
}

// Fetch applications from the dedicated table
$apps = get_result('SELECT * FROM `applications` WHERE `product_id` = ? ORDER BY `id` ASC', [$product['id']]);

require __DIR__ . '/includes/user/header.php';
?>

<main id="main" class="cm-page">
    <section class="<?= htmlspecialchars($heroClass) ?>" aria-label="<?= htmlspecialchars($product['product_name']) ?>">
        <div class="cm-hero-overlay"></div>
        <div class="container-fluid cm-hero-inner">
            <h1 class="cm-hero-title"><?= htmlspecialchars($product['product_name']) ?></h1>
        </div>
    </section>

    <section class="cm-intro" aria-label="Introduction">
        <div class="container-fluid cm-intro-inner">
            <div class="cm-intro-text">
                <?= $product['description'] ?>
            </div>
        </div>
    </section>

    <?php if (count($benefits) > 0): ?>
        <section class="cm-benefits" aria-labelledby="benefits-heading">
            <div class="container-fluid">
                <h2 id="benefits-heading" class="cm-block-title">Benefits of our <?= htmlspecialchars(strtolower($product['product_name'])) ?></h2>
                <div class="cm-benefits-grid">
                    <?php foreach ($benefits as $b): ?>
                        <article class="cm-benefit-card">
                            <h3 class="cm-benefit-title"><?= htmlspecialchars(trim(strip_tags(str_replace('&nbsp;', ' ', $b['title'])))) ?></h3>
                            <div class="cm-benefit-text"><?= $b['text'] ?></div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if (count($apps) > 0): ?>
        <section class="cm-applications" aria-labelledby="apps-heading">
            <div class="container-fluid">
                <h2 id="apps-heading" class="cm-block-title">Applications</h2>
                <p class="cm-apps-lead">
                    Our <?= htmlspecialchars(strtolower($product['product_name'])) ?> are suited to a broad range of plastic applications across industries, including:
                </p>

                <div class="cm-apps-rows">
                    <div class="cm-apps-row cm-apps-row--<?= count($apps) ?>">
                        <?php foreach ($apps as $app): 
                            $appImg = !empty($app['image']) ? base_url(htmlspecialchars(ltrim($app['image'], '/'))) : '';
                        ?>
                            <article class="cm-app-card">
                                <?php if (!empty($appImg)): ?>
                                    <div class="cm-app-icon" aria-hidden="true">
                                        <img class="cm-app-svg" src="<?= $appImg ?>" alt="" />
                                    </div>
                                <?php endif; ?>
                                <h3 class="cm-app-title"><?= htmlspecialchars(trim(strip_tags(str_replace('&nbsp;', ' ', $app['title'])))) ?></h3>
                                <div class="cm-app-text"><?= $app['text'] ?></div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="fm-why" aria-labelledby="why-heading">
        <div class="container-fluid">
            <h2 id="why-heading" class="cm-block-title">Why choose us?</h2>
            <div class="fm-why-grid">
                <?php foreach ($fillerWhy as $row): ?>
                    <article class="cm-app-card fm-why-card">
                        <div class="cm-app-icon" aria-hidden="true">
                            <img class="cm-app-svg fm-why-icon" src="<?= htmlspecialchars(base_url($row['icon'])) ?>" alt="" />
                        </div>
                        <p class="fm-why-text"><?= htmlspecialchars($row['text']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="cm-best-cta">
            <a class="btn btn-primary cm-best-btn" href="<?= htmlspecialchars(base_url('contact.php')) ?>">Get a quote now</a>
        </div>
    </section>
</main>

<?php require __DIR__ . '/includes/user/footer.php'; ?>
