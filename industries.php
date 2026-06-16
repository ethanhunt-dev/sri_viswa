<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/db.php';

$industries = get_result('SELECT * FROM `industries` ORDER BY id ASC');

$site = [
    'brand' => 'Masterbatch Solutions for Multiple Industries | Sri Vasavi Pigments',
    'tagline' => 'Delivering Polymer Solutions since 2007',
];

$pageTitle = 'Industries - ' . $site['brand'];
$metaDescription = 'Explore industry-specific masterbatch solutions by Sri Vasavi Pigments, delivering consistency, quality, and performance across applications.';
$metaKeywords = 'masterbatch industries, flexible packaging masterbatch, rigid packaging, water management, appliances plastics, automotive plastics, agriculture films, electrical plastics';
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
    <section class="ind-page" aria-label="Industries">
        <div class="container-fluid">
            <div class="ind-head">
                <h1 class="section-title center">We understand the unique needs of various industries. Hence, we don't just supply masterbatches, we partner with your innovation. We offer customised solutions that empower you to create high-quality end products across a wide range of applications.</h1>
            </div>

            <?php foreach ($industries as $index => $ind): ?>
                <?php
                $isReverse = ($index % 2 === 1);
                $imgHtml = '<div class="ind-media" aria-hidden="true"><img class="ind-img" src="' . htmlspecialchars(base_url(ltrim((string) $ind['image'], './'))) . '" alt="' . htmlspecialchars((string) $ind['title']) . ' applications" loading="lazy" /></div>';
                $copyHtml = '<div class="ind-copy"><h2 class="ind-title">' . htmlspecialchars((string) $ind['title']) . '</h2><p class="ind-text">' . htmlspecialchars((string) $ind['description']) . '</p></div>';
                ?>
                <section class="ind-row<?= $isReverse ? ' ind-row--reverse' : '' ?>" aria-label="<?= htmlspecialchars((string) $ind['title']) ?>">
                    <?php if ($isReverse): ?>
                        <?= $imgHtml ?>
                        <?= $copyHtml ?>
                    <?php else: ?>
                        <?= $copyHtml ?>
                        <?= $imgHtml ?>
                    <?php endif; ?>
                </section>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="ind-page" aria-label="More industries">
        <div class="container-fluid">
            <div class="ind-head">
                <h3 class="section-title center">Mastering Formulations Beyond the Ordinary</h3>
                <p class="section-text">
                    Beyond these core industries, we also have experience developing custom masterbatches for various other applications. Our team is dedicated to understanding your specific needs and formulating solutions that exceed your expectations.
                </p>
            </div>
        </div>
    </section>
</main>

<?php require __DIR__ . '/includes/user/footer.php'; ?>
