<?php
declare(strict_types=1);

$site = [
    'brand' => 'SRI VASAVI',
    'tagline' => 'Delivering Polymer Solutions since 2007',
];

$pageTitle = 'Filler Masterbatches — ' . $site['brand'];
$metaDescription = 'Filler masterbatches from Sri Vasavi Pigments deliver cost efficiency, improved mechanical properties and better processing for packaging, agriculture films, cables, and structural plastics.';
$metaKeywords = 'filler masterbatch, calcium carbonate filler, cost reduction plastics, mechanical properties plastics, packaging masterbatch, agriculture films';
$robots = 'index,follow';

$nav = [
    ['label' => 'Home', 'href' => './index.php'],
    ['label' => 'About Us', 'href' => './about.php'],
    ['label' => 'Industries', 'href' => './industries.php'],
    ['label' => 'R & D', 'href' => './rd.php'],
    ['label' => 'Products', 'href' => './index.php#products'],
    ['label' => 'Contact Us', 'href' => './contact.php'],
];

$fillerBenefitsTop = [
    [
        'title' => 'Cost Efficiency',
        'text' => 'Reduces the use of base polymers, leading to significant cost savings.',
    ],
    [
        'title' => 'Enhanced Mechanical Properties',
        'text' => 'Improves the mechanical properties of plastic products.',
    ],
    [
        'title' => 'Dimensional Stability',
        'text' => 'Ensures minimal shrinkage and warping for more reliable end products.',
    ],
];

$fillerBenefitsBottom = [
    [
        'title' => 'Process Optimization',
        'text' => 'Enhances extrusion and molding processes, improving production efficiency and reducing waste.',
    ],
    [
        'title' => 'Sustainability',
        'text' => 'Decreases consumption of virgin polymers, promoting environmentally conscious manufacturing.',
    ],
];

$fillerApps = [
    [
        'title' => 'Packaging',
        'text' => 'Economical and durable solutions for films, bags, and containers.',
        'icon' => 'assets/images/Packaging.png',
        'alt' => '',
    ],
    [
        'title' => 'Fabrics & textiles',
        'text' => 'Used in the production of various fabric applications, reducing material costs without compromising quality.',
        'icon' => 'assets/images/Textiles.png',
        'fa' => 'fa-solid fa-shirt',
    ],
    [
        'title' => 'Furniture',
        'text' => 'Used in molded plastic furniture components; fillers enhance rigidity and dimensional stability.',
        'icon' => 'assets/images/Furniture.png',
        'fa' => 'fa-solid fa-couch',
    ],
    [
        'title' => 'Consumer Goods',
        'text' => 'Cost-effective manufacturing of household items and everyday products.',
        'icon' => 'assets/images/Consumer.png',
        'alt' => '',
    ],
];

$fillerWhy = [
    ['text' => 'Uncompromising quality in all of our products.', 'icon' => 'assets/images/Uncompromising.png'],
    ['text' => 'Customized solutions to address industry specific challenges.', 'icon' => 'assets/images/Highly.png'],
    ['text' => 'Cost-effective masterbatches without compromising on functionality.', 'icon' => 'assets/images/Cost.png'],
    ['text' => 'Comprehensive technical support for seamless processing.', 'icon' => 'assets/images/Comprehensive.png'],
];

require __DIR__ . '/includes/header.php';
?>

<main id="main" class="cm-page">
    <section class="cm-hero cm-hero--filler" aria-label="Filler masterbatches">
        <div class="cm-hero-overlay"></div>
        <div class="container-fluid cm-hero-inner">
            <h1 class="cm-hero-title">Filler Masterbatches</h1>
        </div>
    </section>

    <section class="cm-intro" aria-label="Introduction">
        <div class="container-fluid cm-intro-inner">
            <p class="cm-intro-text">
                Filler masterbatches are a versatile and cost-effective solution designed to optimize the properties of plastic products while reducing cost.  
            </p>
            <p class="cm-intro-text">
            By incorporating high-quality mineral fillers, these masterbatches improve mechanical strength, dimensional stability, and process efficiency. They are tailored to meet diverse industry requirements without compromising the quality or aesthetics of the final product.

</p>
            <p class="cm-intro-text">
            Our filler masterbatches offer consistent performance, ensuring that your products achieve the desired functionality and durability.

</p>
        </div>
    </section>

    <section class="cm-benefits" aria-labelledby="filler-benefits-heading">
        <div class="container-fluid">
            <h2 id="filler-benefits-heading" class="cm-block-title">Benefits of filler masterbatches</h2>
            <div class="fm-ben-rows">
                <div class="fm-ben-row fm-ben-row--3">
                    <?php foreach ($fillerBenefitsTop as $b): ?>
                        <article class="cm-benefit-card">
                            <h3 class="cm-benefit-title"><?= htmlspecialchars($b['title']) ?></h3>
                            <p class="cm-benefit-text"><?= htmlspecialchars($b['text']) ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
                <div class="fm-ben-row fm-ben-row--2">
                    <?php foreach ($fillerBenefitsBottom as $b): ?>
                        <article class="cm-benefit-card">
                            <h3 class="cm-benefit-title"><?= htmlspecialchars($b['title']) ?></h3>
                            <p class="cm-benefit-text"><?= htmlspecialchars($b['text']) ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="cm-applications" aria-labelledby="filler-apps-heading">
        <div class="container-fluid">
            <h2 id="filler-apps-heading" class="cm-block-title">Applications</h2>

            <div class="cm-apps-rows">
                <div class="cm-apps-row cm-apps-row--4">
                    <?php foreach ($fillerApps as $app): ?>
                        <article class="cm-app-card">
                            <div class="cm-app-icon" aria-hidden="true">
                                <?php if (!empty($app['icon'])): ?>
                                    <img class="cm-app-svg" src="<?= htmlspecialchars($app['icon']) ?>" alt="<?= htmlspecialchars((string) ($app['alt'] ?? '')) ?>" />
                                <?php else: ?>
                                    <i class="<?= htmlspecialchars((string) $app['fa']) ?> cm-app-fa"></i>
                                <?php endif; ?>
                            </div>
                            <h3 class="cm-app-title"><?= htmlspecialchars($app['title']) ?></h3>
                            <p class="cm-app-text"><?= htmlspecialchars($app['text']) ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

  <section class="fm-why" aria-labelledby="filler-why-heading">
        <div class="container-fluid">
            <h2 id="filler-why-heading" class="cm-block-title">Why choose us?</h2>
            <div class="fm-why-grid">
                <?php foreach ($fillerWhy as $row): ?>
                    <article class="cm-app-card fm-why-card">
                        <div class="cm-app-icon" aria-hidden="true">
                            <img class="cm-app-svg fm-why-icon" src="<?= htmlspecialchars($row['icon']) ?>" alt="" />
                        </div>
                        <p class="fm-why-text"><?= htmlspecialchars($row['text']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
         <div class="cm-best-cta">
                <a class="btn btn-primary cm-best-btn" href="./contact.php">Get a quote now</a>
            </div>
    </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
