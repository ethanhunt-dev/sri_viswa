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

// Build dynamic product page schema
$relatedProducts = [];
try {
    $dbRelated = get_result('SELECT product_name, slug FROM products WHERE id != ? ORDER BY id ASC', [$product['id']]);
    foreach ($dbRelated as $rp) {
        $relatedProducts[] = [
            '@type' => 'Product',
            'name' => $rp['product_name'],
            'url' => base_url('product/' . $rp['slug'])
        ];
    }
} catch (Throwable $t) {
    // Fail silently
}

$benefitItems = [];
foreach ($benefits as $idx => $b) {
    $benefitItems[] = [
        '@type' => 'ListItem',
        'position' => $idx + 1,
        'name' => trim(strip_tags(str_replace('&nbsp;', ' ', $b['title']))),
        'description' => trim(strip_tags(str_replace('&nbsp;', ' ', $b['text'])))
    ];
}

$appItems = [];
foreach ($apps as $idx => $app) {
    $appItems[] = [
        '@type' => 'ListItem',
        'position' => $idx + 1,
        'name' => trim(strip_tags(str_replace('&nbsp;', ' ', $app['title']))),
        'description' => trim(strip_tags(str_replace('&nbsp;', ' ', $app['text'])))
    ];
}

$graph = [
    [
        '@type' => 'WebSite',
        '@id' => 'https://www.srivasavi.co.in/#website',
        'url' => 'https://www.srivasavi.co.in/',
        'name' => 'Sri Vasavi Pigments',
        'alternateName' => 'Plastimix',
        'publisher' => [
            '@id' => 'https://www.srivasavi.co.in/#organization'
        ]
    ],
    [
        '@type' => 'Organization',
        '@id' => 'https://www.srivasavi.co.in/#organization',
        'name' => 'Sri Vasavi Pigments',
        'url' => 'https://www.srivasavi.co.in/',
        'logo' => [
            '@type' => 'ImageObject',
            'url' => 'https://www.srivasavi.co.in/assets/images/logo.png'
        ],
        'email' => 'info@vasavipigments.com',
        'telephone' => '+91-884-2321425',
        'foundingDate' => '1997',
        'description' => 'Sri Vasavi Pigments is a leading Masterbatch Manufacturer in India producing Colour Masterbatches, White Masterbatches, Additive Masterbatches, Antimicrobial Masterbatches, Anti-Static Masterbatches, Flame Retardant Masterbatches and Anti-Rodent Masterbatches.',
        'brand' => [
            '@type' => 'Brand',
            'name' => 'Plastimix'
        ],
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => '1-13-056, Gopal Nagar',
            'addressLocality' => 'Yanam',
            'postalCode' => '533464',
            'addressRegion' => 'Puducherry',
            'addressCountry' => 'IN'
        ]
    ],
    [
        '@type' => 'WebPage',
        '@id' => base_url('product/' . $slug . '#webpage'),
        'url' => base_url('product/' . $slug),
        'name' => $product['product_name'] . ' Manufacturer in India | Custom Polymer Solutions',
        'description' => trim(strip_tags((string)($product['description'] ?? ''))),
        'inLanguage' => 'en',
        'isPartOf' => [
            '@id' => 'https://www.srivasavi.co.in/#website'
        ],
        'about' => [
            '@id' => 'https://www.srivasavi.co.in/#organization'
        ],
        'breadcrumb' => [
            '@id' => base_url('product/' . $slug . '#breadcrumb')
        ]
    ],
    [
        '@type' => 'BreadcrumbList',
        '@id' => base_url('product/' . $slug . '#breadcrumb'),
        'itemListElement' => [
            [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'Home',
                'item' => 'https://www.srivasavi.co.in/'
            ],
            [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => 'Products',
                'item' => 'https://www.srivasavi.co.in/#products'
            ],
            [
                '@type' => 'ListItem',
                'position' => 3,
                'name' => $product['product_name'],
                'item' => base_url('product/' . $slug)
            ]
        ]
    ],
    [
        '@type' => 'Product',
        '@id' => base_url('product/' . $slug . '#product'),
        'name' => $product['product_name'],
        'url' => base_url('product/' . $slug),
        'image' => 'https://www.srivasavi.co.in/assets/images/logo.png',
        'description' => trim(strip_tags((string)($product['description'] ?? ''))),
        'brand' => [
            '@type' => 'Brand',
            'name' => 'Plastimix'
        ],
        'manufacturer' => [
            '@id' => 'https://www.srivasavi.co.in/#organization'
        ],
        'category' => 'Masterbatches',
        'offers' => [
            '@type' => 'Offer',
            'url' => base_url('contact.php'),
            'priceCurrency' => 'INR',
            'availability' => 'https://schema.org/InStock',
            'seller' => [
                '@id' => 'https://www.srivasavi.co.in/#organization'
            ],
            'areaServed' => [
                '@type' => 'Country',
                'name' => 'India'
            ]
        ],
        'isRelatedTo' => $relatedProducts
    ]
];

if (count($benefitItems) > 0) {
    $graph[] = [
        '@type' => 'ItemList',
        '@id' => base_url('product/' . $slug . '#benefits'),
        'name' => 'Benefits of Sri Vasavi Pigments ' . $product['product_name'],
        'numberOfItems' => count($benefitItems),
        'itemListElement' => $benefitItems
    ];
}

if (count($appItems) > 0) {
    $graph[] = [
        '@type' => 'ItemList',
        '@id' => base_url('product/' . $slug . '#applications'),
        'name' => 'Applications of Sri Vasavi Pigments ' . $product['product_name'],
        'numberOfItems' => count($appItems),
        'itemListElement' => $appItems
    ];
}

$pageSchema = '<!-- Schema markup -->
<script type="application/ld+json">
' . json_encode(['@context' => 'https://schema.org', '@graph' => $graph], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . '
</script>';

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
