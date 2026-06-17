<?php
declare(strict_types=1);

$site = [
    'brand' => 'SRI VASAVI',
    'tagline' => 'Delivering Polymer Solutions since 2007',
];

$pageTitle = 'White Masterbatches — ' . $site['brand'];
$metaDescription = 'White masterbatches from Sri Vasavi Pigments provide brilliant whiteness, high opacity and consistent dispersion for packaging, moulding and extrusion applications.';
$metaKeywords = 'white masterbatch, TiO2 masterbatch, high opacity masterbatch, plastic whiteness, packaging masterbatch, injection moulding';
$robots = 'index,follow';

$nav = [
    ['label' => 'Home', 'href' => './index.php'],
    ['label' => 'About Us', 'href' => './about.php'],
    ['label' => 'Industries', 'href' => './industries.php'],
    ['label' => 'R & D', 'href' => './rd.php'],
    ['label' => 'Products', 'href' => './index.php#products'],
    ['label' => 'Contact Us', 'href' => './contact.php'],
];


$fillerWhy = [
    ['text' => 'Uncompromising quality in all of our products.', 'icon' => 'assets/images/Uncompromising.png'],
    ['text' => 'Customized solutions to address industry specific challenges.', 'icon' => 'assets/images/Highly.png'],
    ['text' => 'Cost-effective masterbatches without compromising on functionality.', 'icon' => 'assets/images/Cost.png'],
    ['text' => 'Comprehensive technical support for seamless processing.', 'icon' => 'assets/images/Comprehensive.png'],
];

$wmBenefits = [
    [
        'title' => 'Brilliant Whiteness',
        'text' => 'Delivers exceptional brightness and visual appeal to plastic products.',
    ],
    [
        'title' => 'High Opacity',
        'text' => 'Ensures complete coverage and uniform appearance.',
    ],
    [
        'title' => 'Consistent Quality',
        'text' => 'Offers uniform dispersion and minimizes streaking or defects.',
    ],
    [
        'title' => 'Wide Compatibility',
        'text' => 'Can be designed for use with a wide range of polymers.',
    ],
];

$wmAppsTop = [
    [
        'title' => 'Packaging Industry:',
        'text' => 'Films, containers, and wraps requiring high opacity and aesthetic appeal.',
        'icon' => 'assets/images/Packaging.png',
        'alt' => '',
    ],
    [
        'title' => 'Water Tanks, Pipes & Fittings:',
        'text' => 'Durable opacity solutions for various structural products used in storage and conveyance of water.',
        'icon' => 'assets/images/Water.png',
        'alt' => '',
    ],
    [
        'title' => 'Consumer Goods:',
        'text' => 'Bright white household items like furniture, kitchenware, and appliances.',
        'icon' => 'assets/images/Consumer.png',
        'alt' => '',
    ],
];

$wmAppsBottom = [
    [
        'title' => 'Automotive Industry:',
        'text' => 'Interior and exterior components along with ancillaries like batteries, requiring durable white finishes.',
        'icon' => 'assets/images/Automotive.png',
        'alt' => '',
    ],
    [
        'title' => 'Textiles & Fibers:',
        'text' => 'Provide vibrant whiteness for fabric based applications.',
            'icon' => 'assets/images/Textiles.png',
        'alt' => '',
    ],
];

$wmBest = [
    ['label' => 'Uncompromising quality in all of our products', 'icon' => './assets/images/Uncompromising.png'],
    ['label' => 'Customized solutions to address industry specific challenges.', 'icon' => './assets/images/Highly.png'],
    ['label' => 'Cost-effective masterbatches without compromising on functionality.', 'icon' => './assets/images/Cost-effective.png'],
    ['label' => 'Comprehensive technical support for seamless processing.', 'icon' => './assets/images/cost.png'],
];

// Build page schema dynamically from database
try {
    require_once __DIR__ . '/includes/db.php';
    $slug = 'white-masterbatch';
    $product = get_row('SELECT * FROM `products` WHERE `slug` = ?', [$slug]);
    if ($product) {
        $benefits = get_result('SELECT * FROM `benefits` WHERE `product_id` = ? ORDER BY `id` ASC', [$product['id']]);
        $apps = get_result('SELECT * FROM `applications` WHERE `product_id` = ? ORDER BY `id` ASC', [$product['id']]);
        
        $relatedProducts = [];
        $dbRelated = get_result('SELECT product_name, slug FROM products WHERE id != ? ORDER BY id ASC', [$product['id']]);
        foreach ($dbRelated as $rp) {
            $relatedProducts[] = [
                '@type' => 'Product',
                'name' => $rp['product_name'],
                'url' => base_url('product/' . $rp['slug'])
            ];
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
    }
} catch (Throwable $e) {
    // Fail silently
}

require __DIR__ . '/includes/header.php';
?>

<main id="main" class="cm-page">
    <section class="cm-hero cm-hero--white" aria-label="White masterbatches">
        <div class="cm-hero-overlay"></div>
        <div class="container-fluid cm-hero-inner">
            <h1 class="cm-hero-title">White Masterbatches</h1>
        </div>
    </section>

    <section class="cm-intro" aria-label="Introduction">
        <div class="container-fluid cm-intro-inner">
            <p class="cm-intro-text">
            White Masterbatches are used to achieve opacity and various white finishes in plastic products. By integrating titanium dioxide (TiO₂) and other performance-enhancing additives, our White Masterbatches ensure excellent dispersion, superior brightness, and optimal opacity.

            </p>
            <p class="cm-intro-text">
            They can be designed to suit a wide range of applications, delivering consistent results and providing required lightfastness and weatherability.


            </p>
        </div>
    </section>

    <section class="cm-benefits" aria-labelledby="wm-benefits-heading">
        <div class="container-fluid">
            <h2 id="wm-benefits-heading" class="cm-block-title">Benefits of our white masterbatches</h2>
            <div class="cm-benefits-grid">
                <?php foreach ($wmBenefits as $b): ?>
                    <article class="cm-benefit-card">
                        <h3 class="cm-benefit-title"><?= htmlspecialchars($b['title']) ?></h3>
                        <p class="cm-benefit-text"><?= htmlspecialchars($b['text']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="cm-applications" aria-labelledby="wm-apps-heading">
        <div class="container-fluid">
            <h2 id="wm-apps-heading" class="cm-block-title">Applications</h2>
            <p class="cm-apps-lead">
                Our white masterbatches are suited to a broad range of plastic applications across industries, including:
            </p>

            <div class="cm-apps-rows">
                <div class="cm-apps-row cm-apps-row--3">
                    <?php foreach ($wmAppsTop as $app): ?>
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
                    <?php foreach ($wmAppsBottom as $app): ?>
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
