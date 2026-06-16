<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/db.php';

$rdRow = get_row('SELECT * FROM `rd` LIMIT 1');

$site = [
    'brand' => 'SRI VASAVI',
    'tagline' => 'Delivering Polymer Solutions since 2007',
];

$pageTitle = 'R & D - ' . $site['brand'];
$metaDescription = 'Discover our R&D and quality lab capabilities: rigorous testing, development and customised masterbatch solutions backed by modern equipment and expert teams.';
$metaKeywords = 'masterbatch R&D, polymer testing lab, quality lab, product development, customised masterbatch solutions';
$robots = 'index,follow';

$nav = [
    ['label' => 'Home', 'href' => './index.php'],
    ['label' => 'About Us', 'href' => './about.php'],
    ['label' => 'Industries', 'href' => './industries.php'],
    ['label' => 'R & D', 'href' => './rd.php'],
    ['label' => 'Products', 'href' => './index.php#products'],
    ['label' => 'Contact Us', 'href' => './contact.php'],
];

require __DIR__ . '/includes/user/header.php';
?>

<main id="main">
    <?php if ($rdRow): ?>
    <section class="rd-page" aria-label="R and D">
        <div class="container-fluid">
            <div class="rd-grid">
                <div class="rd-media" aria-hidden="true">
                    <img class="rd-img" src="<?= htmlspecialchars(base_url(ltrim((string) $rdRow['image'], './'))) ?>" alt="" />
                </div>

                <div class="rd-copy">
                    <h1 class="section-title">A Commitment to Innovation and Quality</h1>
                    <?= $rdRow['content'] ?>
                </div>
            </div>
        </div>
    </section>

    <section class="rd-lab" aria-label="Testing and development">
        <div class="container-fluid">
            <div class="rd-lab-head">
                <h2 class="section-title center">A Centre of Testing and Development</h2>
                <p class="rd-lab-sub">
                    Our R&D philosophy is built upon a foundation of unwavering quality. We employ rigorous testing methodologies throughout the development process, ensuring that our masterbatches meet the highest performance standards.
                </p>
            </div>

            <div class="rd-cards">
                <article class="rd-card">
                    <h3 class="rd-card-title">A Well-Equipped Space</h3>
                    <?= $rdRow['equiped_space'] ?>
                </article>

                <article class="rd-card">
                    <h3 class="rd-card-title">Rigorous Quality Control</h3>
                    <?= $rdRow['Quality_control'] ?>
                </article>
            </div>
        </div>
    </section>
    <?php else: ?>
        <div style="padding: 100px 0; text-align: center;">
            <p>R & D content is currently unavailable.</p>
        </div>
    <?php endif; ?>
</main>

<?php require __DIR__ . '/includes/user/footer.php'; ?>
