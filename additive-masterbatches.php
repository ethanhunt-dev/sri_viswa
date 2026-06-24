<?php
declare(strict_types=1);

$site = [
    'brand' => 'SRI VASAVI',
    'tagline' => 'Delivering Polymer Solutions since 2007',
];

$pageTitle = 'Additive Masterbatches — ' . $site['brand'];
$metaDescription = 'Additive masterbatches from Sri Vasavi Pigments enhance polymer performance: UV, anti-static, antimicrobial, slip, anti-block, flame retardant, PPA and more.';
$metaKeywords = 'additive masterbatch, UV stabilizer masterbatch, anti-static masterbatch, antimicrobial masterbatch, flame retardant masterbatch, slip masterbatch, anti-block';
$robots = 'index,follow';

$nav = [
    ['label' => 'Home', 'href' => './index.php'],
    ['label' => 'About Us', 'href' => './about.php'],
    ['label' => 'Industries', 'href' => './industries.php'],
    ['label' => 'R & D', 'href' => './rd.php'],
    ['label' => 'Products', 'href' => './index.php#products'],
    ['label' => 'Contact Us', 'href' => './contact.php'],
];

$plastimixRows = [
    ['name' => 'Antimicrobial Masterbatches', 'desc' => 'Inhibit the growth of bacteria, fungi, and other microbes in plastics, enhancing hygiene for products used in water storage, healthcare, and packaging.'],
    ['name' => 'UV Stabilizer Masterbatches', 'desc' => 'Protect polymers from ultraviolet degradation, maintaining color and strength in products exposed to sunlight such as films and outdoor goods.'],
    ['name' => 'Anti-Static Masterbatches', 'desc' => 'Minimize static build-up on plastic surfaces, making them safer and easier to handle in packaging, electronic housings, and cleanroom applications.'],
    ['name' => 'Flame Retardant Masterbatches', 'desc' => 'Reduce flammability and slow down ignition, used in electrical components, appliance parts, and transport products for improved fire safety.'],
    ['name' => 'Biodegradable Masterbatches', 'desc' => 'Support controlled decomposition of plastics, ideal for agriculture films and single-use packaging to meet sustainability requirements.'],
    ['name' => 'Slip Masterbatches', 'desc' => 'Lower friction for smoother processing and handling, beneficial in flexible packaging, films, and bags.'],
    ['name' => 'Anti-Block Masterbatches', 'desc' => 'Prevent plastic surfaces from sticking together, aiding manufacturing and use in multilayer films and liners.'],
    ['name' => 'Anti-Rodent Masterbatches', 'desc' => 'Discourage rodent damage, helping to protect cable sheathing and water pipes in infrastructure and utilities.'],
    ['name' => 'Desiccant Masterbatches', 'desc' => 'Absorb moisture during processing, improving product quality for recycled resins and sensitive moulded parts.'],
    ['name' => 'Optical Brightener Masterbatches', 'desc' => 'Enhance brightness and visual appeal, commonly used in packaging, consumer goods, and textiles.'],
    ['name' => 'Polymer Processing Aid (PPA) Masterbatches', 'desc' => 'Improve melt flow and processability, reducing surface defects in blown film and extrusion applications.'],
    ['name' => 'Anti-Fog Masterbatches', 'desc' => 'Retain clarity in films by preventing fogging, especially for food packaging and greenhouse covers.'],
    ['name' => 'Nucleating and Clarifying Masterbatches', 'desc' => 'Improve clarity and stiffness in polymers, used in injection-molded products and clear packaging.'],
    ['name' => 'VCI (Vapor Corrosion Inhibitor) Masterbatches', 'desc' => 'Release protective agents to guard metals from corrosion during storage and shipping.'],
    ['name' => 'Anti-Slip Masterbatches', 'desc' => 'Create micro-textures to reduce slippage, suitable for sacks, packaging films, and pallet wraps.'],
    ['name' => 'Anti-Ripening Masterbatches', 'desc' => 'Slow the ripening process in packaged produce, extending shelf life in agricultural and retail packaging.'],
    ['name' => 'Antioxidant Masterbatches', 'desc' => 'Protect polymers from oxidative damage caused by heat and processing, enhancing durability in automotive, household, and packaging products.'],
    ['name' => 'Purging Masterbatches', 'desc' => 'Effectively clean extruders and molding machines, reducing contamination between material or color changes in production lines.'],
    ['name' => 'Conductive Compound', 'desc' => 'Impart electrical conductivity for antistatic containers, ESD protection, and specialized packaging for electronics.'],
];

$industryBullets = [
    'Flexible & rigid packaging',
    'Agricultural films and geomembranes',
    'Battery components & casings',
    'Electrical wires and cables',
    'Consumer durables, appliances, and storage solutions',
    'Pipes, water tanks and other structural plastics',
];



$fillerWhy = [
    ['text' => 'Uncompromising quality in all of our products.', 'icon' => 'assets/images/Uncompromising.png'],
    ['text' => 'Customized solutions to address industry specific challenges.', 'icon' => 'assets/images/Highly.png'],
    ['text' => 'Cost-effective masterbatches without compromising on functionality.', 'icon' => 'assets/images/Cost.png'],
    ['text' => 'Comprehensive technical support for seamless processing.', 'icon' => 'assets/images/Comprehensive.png'],
];


// Build page schema dynamically from database
try {
    require_once __DIR__ . '/includes/db.php';
    
    // Load from database if available
    $dbRows = get_result("SELECT name, description AS `desc` FROM `additive_masterbatches` ORDER BY `sort_order` ASC, `id` ASC");
    if (!empty($dbRows)) {
        $plastimixRows = $dbRows;
    }
    
    $slug = 'additive-masterbatches';
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
    <section class="cm-hero cm-hero--additive" aria-label="Additive masterbatches">
        <div class="cm-hero-overlay"></div>
        <div class="container-fluid cm-hero-inner">
            <h1 class="cm-hero-title">Additive Masterbatches</h1>
        </div>
    </section>

    <section class="cm-intro" aria-label="Introduction">
        <div class="container-fluid cm-intro-inner">
            <p class="cm-intro-text">
                At <strong>Sri Vasavi Pigments</strong>, we understand that the demands on modern plastics extend far beyond basic coloration. Our <strong>additive masterbatches</strong> are expertly designed to enhance the essential properties of polymers, ensuring your products meet ever-evolving performance, regulatory, and aesthetic standards across industries.
            </p>
        </div>
    </section>

    <section class="am-content" aria-labelledby="am-function-heading">
        <div class="container-fluid am-content-inner">
            <h2 id="am-function-heading" class="am-subtitle">Enhancing functionality across applications</h2>
            <p class="am-body">
                Utilizing our industry experience, our team formulates additive masterbatches that are both highly effective and process friendly. Whether you manufacture packaging films requiring anti-fog properties, furniture that must withstand UV stress, or specialty sheets needing antistatic surfaces, our solutions are purpose-engineered to add tangible value.
            </p>
            <p class="am-body">
                We also recommend or develop suitable masterbatch solutions based on your specific processing requirements, resin systems, and end-use needs.
            </p>
        </div>
    </section>

    <section class="am-table-section" aria-labelledby="am-range-heading">
        <div class="container-fluid">
            <h2 id="am-range-heading" class="am-range-title">PLASTIMIX<sup aria-hidden="true">®</sup> range of Additive Masterbatches</h2>
            <div class="am-table-scroll">
                <table class="am-range-table">
                    <thead>
                        <tr>
                            <th scope="col">PLASTIMIX<sup>®</sup> Range</th>
                            <th scope="col">Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($plastimixRows as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= $row['desc'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <section class="am-dual" aria-label="Industries and support">
        <div class="container-fluid am-dual-inner">
            <div class="am-dual-card">
                <h2 class="am-dual-heading">Industries and End-Use Solutions</h2>
                <p class="am-dual-lead">Our additive masterbatches are trusted by leading manufacturers in:</p>
                <ul class="am-dual-list">
                    <?php foreach ($industryBullets as $item): ?>
                        <li><?= htmlspecialchars($item) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="am-dual-card">
                <h2 class="am-dual-heading">Customer-Centric Support &amp; Customization</h2>
                <p class="am-dual-text">
                    At Sri Vasavi Pigments, we provide more than just reliable masterbatch solutions—we partner with you to understand your process, resin selection, and performance targets. Our team works collaboratively to recommend, fine-tune, or develop additive systems that support consistent quality, regulatory confidence, and long-term value for your products and operations.
                </p>
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
