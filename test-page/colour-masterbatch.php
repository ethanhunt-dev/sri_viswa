<?php
declare(strict_types=1);

$site = [
    'brand' => 'SRI VASAVI',
    'tagline' => 'Delivering Polymer Solutions since 2007',
];

$pageTitle = 'Colour Masterbatch — ' . $site['brand'];
$metaDescription = 'Colour masterbatches from Sri Vasavi Pigments deliver vibrant, consistent shades with a wide range of colours and special effects for plastic manufacturing applications.';
$metaKeywords = 'colour masterbatch, color masterbatch, plastic pigments, special effect colours, metallic masterbatch, pearlescent masterbatch, Plastimix';
$robots = 'index,follow';

$nav = [
    ['label' => 'Home', 'href' => './index.php'],
    ['label' => 'About Us', 'href' => './about.php'],
    ['label' => 'Industries', 'href' => './industries.php'],
    ['label' => 'R & D', 'href' => './rd.php'],
    ['label' => 'Products', 'href' => './index.php#products'],
    ['label' => 'Contact Us', 'href' => './contact.php'],
];

$cmBenefits = [
    [
        'title' => 'Wide Colour Range',
        'text' => 'Choose the perfect shade from a staggering selection of over 2500+ colours.',
    ],
    [
        'title' => 'Outstanding Vibrancy',
        'text' => 'High-quality pigmented masterbatches deliver exceptional colour intensity.',
    ],
    [
        'title' => 'Consistent Quality',
        'text' => 'Precisely formulated masterbatches ensure uniform colour throughout production runs.',
    ],
    [
        'title' => 'Special effect colors',
        'text' => 'Color masterbatches that provide special effects like metallic, pearlescent, marble, sparkle, fluorescent etc.',
    ],
];

$cmAppsTop = [
    [
        'title' => 'Consumer Goods:',
        'text' => 'Used across appliances, furniture, and many consumer goods to achieve consistent, attractive finishes that enhance brand value.',
        'icon' => 'assets/images/Consumer.png',
        'alt' => '',
    ],
    [
        'title' => 'Packaging Industry:',
        'text' => 'Provide vibrant, shelf-appealing coloration for bottles, caps, containers, woven sacks and flexible films.',
        'icon' => 'assets/images/Packaging.png',
        'alt' => '',
    ],
    [
        'title' => 'Automotive Components:',
        'text' => 'For interior, exterior automobile parts, batteries and other components, colour masterbatches and compounds designed to match specifications.',
        'icon' => 'assets/images/Automotive.png',
        'alt' => '',
    ],
];


$fillerWhy = [
    ['text' => 'Uncompromising quality in all of our products.', 'icon' => 'assets/images/Uncompromising.png'],
    ['text' => 'Customized solutions to address industry specific challenges.', 'icon' => 'assets/images/Highly.png'],
    ['text' => 'Cost-effective masterbatches without compromising on functionality.', 'icon' => 'assets/images/Cost.png'],
    ['text' => 'Comprehensive technical support for seamless processing.', 'icon' => 'assets/images/Comprehensive.png'],
];
$cmAppsBottom = [
    [
        'title' => 'Textiles and Fibers:',
        'text' => 'Utilized to imbue a spectrum of colors in synthetic fibers, non-wovens, and industrial threads, while maintaining consistency.',
        'icon' => 'assets/images/Textiles.png',
        'alt' => '',
    ],
        
    [
        'title' => 'Water Tanks, Pipes & Fittings:',
        'text' => 'Coloring solutions for a wide range of structural applications like tanks & pipes, to ensure optimal long term performance.',
        'icon' => 'assets/images/Water.png',
        'alt' => '',
    ],
];

$cmBest = [
    ['label' => 'Uncompromising Quality', 'icon' => 'assets/images/Uncompromising.png'],
    ['label' => 'Highly Customisable', 'icon' => 'assets/images/Highly.png'],
    ['label' => 'Cost Effective', 'icon' => 'assets/images/Cost.png'],
];

require __DIR__ . '/includes/header.php';
?>

<main id="main" class="cm-page">
    <section class="cm-hero" aria-label="Colour masterbatch">
        <div class="cm-hero-overlay"></div>
        <div class="container-fluid cm-hero-inner">
            <h1 class="cm-hero-title">Colour Masterbatch</h1>
        </div>
    </section>

    <section class="cm-intro" aria-label="Introduction">
        <div class="container-fluid cm-intro-inner">
            <p class="cm-intro-text">
                In the realm of plastic manufacturing, colour plays a crucial role as it transforms materials into visually appealing products that resonate with consumers.
            </p>
            <p class="cm-intro-text">
                Colour masterbatches are concentrated mixtures of pigments and additives meticulously incorporated during the manufacturing process. They are the foundation for achieving a spectrum of colours in the final product.
            </p>
            <p class="cm-intro-text">
                The formulation of a colour masterbatch is designed to ensure optimal dispersion of the pigments throughout the plastic. Our range of colour masterbatches can be designed to deliver a wide range of colours including special effects, for your plastic products.
            </p>
        </div>
    </section>

    <section class="cm-benefits" aria-labelledby="cm-benefits-heading">
        <div class="container-fluid">
            <h2 id="cm-benefits-heading" class="cm-block-title">Benefits of our colour masterbatches</h2>
            <div class="cm-benefits-grid">
                <?php foreach ($cmBenefits as $b): ?>
                    <article class="cm-benefit-card">
                        <h3 class="cm-benefit-title"><?= htmlspecialchars($b['title']) ?></h3>
                        <p class="cm-benefit-text"><?= htmlspecialchars($b['text']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="cm-applications" aria-labelledby="cm-apps-heading">
        <div class="container-fluid">
            <h2 id="cm-apps-heading" class="cm-block-title">Applications</h2>
            <p class="cm-apps-lead">
                The versatility of our colour masterbatches makes them suitable for a wide range of plastic product applications across various industries, including:
            </p>

            <div class="cm-apps-rows">
                <div class="cm-apps-row cm-apps-row--3">
                    <?php foreach ($cmAppsTop as $app): ?>
                        <article class="cm-app-card">
                            <div class="cm-app-icon" aria-hidden="true">
                                <img class="cm-app-svg" src="<?= htmlspecialchars((string) $app['icon']) ?>" alt="<?= htmlspecialchars((string) $app['alt']) ?>" />
                            </div>
                            <h3 class="cm-app-title"><?= htmlspecialchars($app['title']) ?></h3>
                            <p class="cm-app-text"><?= htmlspecialchars($app['text']) ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
                <div class="cm-apps-row cm-apps-row--2">
                    <?php foreach ($cmAppsBottom as $app): ?>
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
