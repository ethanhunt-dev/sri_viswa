<?php
declare(strict_types=1);

$site = [
    'brand' => 'Sri Vasavi Pigments | Masterbatch & Compound Manufacturer Since 1997
',
    'tagline' => 'Delivering Polymer Solutions since 2007',
];

$pageTitle = 'Sri Vasavi Pigments | Masterbatch &amp; Compound Manufacturer Since 1997';
$metaDescription = 'Established in 1997, Sri Vasavi Pigments manufactures high-performance masterbatches and compounds from Yanam, Puducherry, serving customers across India.';
$metaKeywords = 'masterbatch manufacturer, colour masterbatch, white masterbatch, additive masterbatch, filler masterbatch, polymer compounds, Plastimix, Sri Vasavi Pigments';
$robots = 'index,follow';

$nav = [
    ['label' => 'Home', 'href' => '#home'],
    ['label' => 'About Us', 'href' => './about.php'],
    ['label' => 'Industries', 'href' => './industries.php'],
    ['label' => 'R & D', 'href' => './rd.php'],
    ['label' => 'Products', 'href' => '#products'],
    ['label' => 'Contact Us', 'href' => './contact.php'],
];

$stats = [
    ['value' => '28', 'label' => 'Years', 'sub' => 'in Business', 'icon' => 'fa-regular fa-calendar-check'],
    ['value' => '2,500', 'label' => 'Colors', 'sub' => 'Created', 'icon' => 'fa-solid fa-palette'],
    ['value' => '800', 'label' => 'Customers', 'sub' => 'Served', 'icon' => 'fa-solid fa-users'],
];

$pillars = [
    ['title' => 'Unmatched Colour Expertise', 'icon' => 'assets/images/Unmatched.png'],
    ['title' => 'Performance-Driven Masterbatches', 'icon' => 'assets/images/Performance.png'],
    ['title' => 'Complete Customer Satisfaction', 'icon' => 'assets/images/Complete.png'],
];

$products = [
    ['title' => 'Additive Masterbatches', 'icon' => 'fa-solid fa-flask', 'desc' => 'Enhance the versatility of your plastics by integrating specific functionalities designed for your unique applications.

'],
    ['title' => 'Colour Masterbatches', 'icon' => 'fa-solid fa-swatchbook', 'desc' => 'With a range of 2500 colours, achieve a spectrum of vibrant and consistent colours in your plastic products.

'],
    ['title' => 'White Masterbatches', 'icon' => 'fa-solid fa-circle-half-stroke', 'desc' => 'Create high-opacity and cost-effective white plastic products with our range of white masterbatches.'],
];

$industriesTop = [
    ['label' => 'Flexible Packaging', 'icon' => 'assets/images/Flexible.home.png'],
    ['label' => 'Rigid Packaging', 'icon' => 'assets/images/Rigid-home.png'],
    ['label' => 'Water Management', 'icon' => 'assets/images/water-home.png'],
    ['label' => 'Appliances', 'icon' => 'assets/images/appliances-home.png'],
];

$industriesBottom = [
    ['label' => 'Automobiles', 'icon' => 'assets/images/Automobiles-home.png'],
    ['label' => 'Agriculture', 'icon' => 'assets/images/agriculture-home.png'],
    ['label' => 'Electricals', 'icon' => 'assets/images/electricals-home.png'],
    ['label' => 'Furniture', 'icon' => 'assets/images/furniture-home.png'],
   
];
require __DIR__ . '/includes/header.php';
?>

    <main id="main">
        <section class="hero hero-banner" aria-label="Hero">
            <div class="container-fluid hero-inner">
                <div class="hero-copy">
                   
                    <div class="hero-kicker">PLASTIMIX<sup aria-hidden="true">®</sup></div>
                    <b><p class="hero-sub">Creating high-performance <br>polymer solutions for your manufacturing needs.</p>
</b>  <a class="btn btn-primary" href="contact.php">Enquiry now</a>
                </div>

                <div class="hero-spacer" aria-hidden="true"></div>
            </div>
        </section>

        <section class="stats" aria-label="Key metrics">
            <div class="container-fluid stats-inner">
                <?php foreach ($stats as $s): ?>
                    <div class="stat">
                        <div class="stat-value" role="heading" aria-level="3">
                            <span class="stat-num"><?= htmlspecialchars($s['value']) ?></span>
                            <span class="stat-plus">+</span>
                            <span class="stat-label"><?= htmlspecialchars($s['label']) ?></span>
                        </div>
                        <div class="stat-sub"><?= htmlspecialchars($s['sub']) ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="legacy" aria-label="Legacy">
            <div class="container-fluid legacy-inner">
                <div class="legacy-media">
                    <img class="legacy-img" src="./assets/images/1.jpg" alt="Masterbatch manufacturing samples" loading="lazy" />
                </div>
                <div class="legacy-copy">
                    <h2 class="section-title">A Legacy of Excellence in Masterbatch Manufacturing</h2>
                    <p class="section-text">
                    Sri Vasavi Pigments is a pioneer of the masterbatch industry in South India. We have become a trusted name, with our commitment to quality and innovation. Our extensive manufacturing facility, combined with the expertise of our team, ensures that every product meets the highest standards. Contact us today to learn more about our acclaimed products & services.


                    </p>
                </div>
            </div>
        </section>

        <section class="pillars" aria-label="Key strengths">
            <div class="container-fluid pillars-inner">
                <?php foreach ($pillars as $p): ?>
                    <div class="pillar-card">
                        <div class="pillar-ico" aria-hidden="true">
                            <img class="pillar-svg" src="<?= htmlspecialchars($p['icon']) ?>" alt="" />
                        </div>
                        <div class="pillar-title"><?= htmlspecialchars($p['title']) ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section id="about" class="about" aria-label="About us">
            <div class="container-fluid about-inner">
                <div class="about-copy">
                    <h2 class="section-title about-title">About us</h2>
                    <p class="section-text">
                    Established in 1997, Sri Vasavi Pigments, is a manufacturer of masterbatches and compounds with a manufacturing facility located in Yanam, UT of Puducherry. Today, we stand as a renowned name in the industry, throughout India. By providing high-performance and consistency, we continue to set new standards in the industry.


                    </p>
                </div>
                <div class="about-media">
                    <img class="about-img" src="./assets/images/about-us.jpg" alt="Masterbatch pellets" loading="lazy" />
                </div>
            </div>
        </section>

        <section id="products" class="products" aria-label="Our products">
            <div class="container-fluid">
                <h2 class="section-title center">Our Products</h2>
                <div class="product-grid">
                    <article class="product-card" id="product-additive">
                        <a class="product-card__link" href="./additive-masterbatches.php" aria-label="Additive Masterbatches">
                            <div class="product-media">
                                <div class="product-media-circle">
                                    <img class="product-img" src="./assets/images/Untitled-design.png" alt="Additive Masterbatches" loading="lazy" />
                                </div>
                            </div>
                            <h3 class="product-title">Additive Masterbatches</h3>
                            <p class="product-desc">Enhance the overall life of your plastics by integrating specific functional additives designed for your unique applications.</p>
                        </a>
                    </article>

                    <article class="product-card" id="product-colour">
                        <a class="product-card__link" href="./colour-masterbatch.php" aria-label="Colour Masterbatch">
                            <div class="product-media">
                                <div class="product-media-circle">
                                    <img class="product-img" src="./assets/images/Colour-Masterbatches.png" alt="Colour Masterbatches" loading="lazy" />
                                </div>
                            </div>
                            <h3 class="product-title">Colour Masterbatches</h3>
                            <p class="product-desc">With a range of 2,500+ colours, achieve a spectrum of vibrant and consistent colours in your plastic products.</p>
                        </a>
                    </article>

                    <article class="product-card" id="product-white">
                        <a class="product-card__link" href="./white-masterbatch.php" aria-label="White Masterbatches">
                            <div class="product-media">
                                <div class="product-media-circle">
                                    <img class="product-img" src="./assets/images/White-Masterbatches.png" alt="White Masterbatches" loading="lazy" />
                                </div>
                            </div>
                            <h3 class="product-title">White Masterbatches</h3>
                            <p class="product-desc">Create high-opacity and cost-effective whites with an optimum dispersion range of white masterbatches.</p>
                        </a>
                    </article>
                </div>
            </div>
        </section>

        <section id="industries" class="industries" aria-label="Industries">
            <div class="container-fluid">
                <div class="industries-inner">
                    <div class="industries-copy">
                        <h2 class="section-title">Empowering Innovation Across Industries</h2>
                        <p class="section-text">
                            Our masterbatches are designed to deliver consistent quality and reliable performance
                            across a wide range of applications. We work closely with partners to support evolving
                            product needs and manufacturing requirements.
                        </p>
                        <br>
                        <a class="btn btn-primary" href="./contact.php">Contact us</a>
                    </div>
                    <div class="industries-panel" aria-label="Industry tiles">
                        <div class="industries-panel-rows">
                            <div class="industries-panel-row industries-panel-row--4" role="list">
                                <?php foreach ($industriesTop as $ind): ?>
                                    <div class="industry-card" role="listitem">
                                        <div class="industry-card__ico" aria-hidden="true">
                                            <img class="industry-card__svg" src="<?= htmlspecialchars($ind['icon']) ?>" alt="" />
                                        </div>
                                        <div class="industry-card__label"><?= htmlspecialchars($ind['label']) ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="industries-panel-row industries-panel-row--3" role="list">
                                <?php foreach ($industriesBottom as $ind): ?>
                                    <div class="industry-card" role="listitem">
                                        <div class="industry-card__ico" aria-hidden="true">
                                            <img class="industry-card__svg" src="<?= htmlspecialchars($ind['icon']) ?>" alt="" />
                                        </div>
                                        <div class="industry-card__label"><?= htmlspecialchars($ind['label']) ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

       

       
    </main>

<?php require __DIR__ . '/includes/footer.php'; ?>
