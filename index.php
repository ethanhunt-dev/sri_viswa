<?php
declare(strict_types=1);

$site = [
    'brand' => 'Sri Vasavi Pigments | Masterbatch & Compound Manufacturer Since 1997',
    'tagline' => 'Delivering Polymer Solutions since 2007',
];

$pageTitle = 'Sri Vasavi Pigments | Masterbatch & Compound Manufacturer Since 1997';
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

require_once __DIR__ . '/includes/db.php';

$homeData = get_row("SELECT * FROM `home_page` LIMIT 1") ?: [];
$banners = get_result("SELECT * FROM `homepage_banners` ORDER BY `sort_order` ASC, `id` ASC");
$aboutUsData = get_row("SELECT * FROM `about_us` ORDER BY `id` DESC LIMIT 1") ?: [];

$stats = [];
if (!empty($homeData)) {
    $stats = [
        ['value' => $homeData['stat1_value'] ?? '', 'label' => $homeData['stat1_label'] ?? '', 'sub' => $homeData['stat1_sub'] ?? ''],
        ['value' => $homeData['stat2_value'] ?? '', 'label' => $homeData['stat2_label'] ?? '', 'sub' => $homeData['stat2_sub'] ?? ''],
        ['value' => $homeData['stat3_value'] ?? '', 'label' => $homeData['stat3_label'] ?? '', 'sub' => $homeData['stat3_sub'] ?? ''],
    ];
}

$pillars = [];
if (!empty($homeData)) {
    $pillars = [
        ['title' => $homeData['pillar1_title'] ?? '', 'icon' => !empty($homeData['pillar1_icon']) ? base_url($homeData['pillar1_icon']) : ''],
        ['title' => $homeData['pillar2_title'] ?? '', 'icon' => !empty($homeData['pillar2_icon']) ? base_url($homeData['pillar2_icon']) : ''],
        ['title' => $homeData['pillar3_title'] ?? '', 'icon' => !empty($homeData['pillar3_icon']) ? base_url($homeData['pillar3_icon']) : ''],
    ];
}

$dbIndustries = get_result("SELECT * FROM `industries` ORDER BY `id` ASC");
$mappedInds = [];
foreach ($dbIndustries as $ind) {
    $mappedInds[] = [
        'label' => $ind['title'],
        'icon' => !empty($ind['image']) ? base_url($ind['image']) : ''
    ];
}
$industriesTop = array_slice($mappedInds, 0, 4);
$industriesBottom = array_slice($mappedInds, 4);

$pageSchema = '<!-- Schema markup -->
<script type="application/ld+json">
{
  "@context":"https://schema.org",
  "@graph":[

    {
      "@type":"Organization",
      "@id":"https://www.srivasavi.co.in/#organization",
      "name":"Sri Vasavi Pigments",
      "url":"https://www.srivasavi.co.in/",
      "logo":"https://www.srivasavi.co.in/assets/images/logo.png",
      "description":"Sri Vasavi Pigments is a leading Masterbatch Manufacturer in India producing Colour Masterbatches, White Masterbatches, Additive Masterbatches, Antimicrobial Masterbatches, Anti-Static Masterbatches, Flame Retardant Masterbatches and Anti-Rodent Masterbatches.",
      "email":"info@vasavipigments.com",
      "telephone":"+91-884-2321425",
      "brand":{
        "@type":"Brand",
        "name":"Plastimix"
      },
      "address":{
        "@type":"PostalAddress",
        "streetAddress":"1-13-056, Gopal Nagar",
        "addressLocality":"Yanam",
        "postalCode":"533464",
        "addressRegion":"Puducherry",
        "addressCountry":"IN"
      }
    },

    {
      "@type":"LocalBusiness",
      "@id":"https://www.srivasavi.co.in/#localbusiness",
      "name":"Sri Vasavi Pigments",
      "image":"https://www.srivasavi.co.in/assets/images/logo.png",
      "url":"https://www.srivasavi.co.in/",
      "telephone":"+91-884-2321425",
      "email":"sales@vasavipigments.com",
      "priceRange":"$$$",
      "address":{
        "@type":"PostalAddress",
        "streetAddress":"1-13-056, Gopal Nagar",
        "addressLocality":"Yanam",
        "postalCode":"533464",
        "addressRegion":"Puducherry",
        "addressCountry":"IN"
      }
    },

    {
      "@type":"WebSite",
      "@id":"https://www.srivasavi.co.in/#website",
      "url":"https://www.srivasavi.co.in/",
      "name":"Sri Vasavi Pigments",
      "publisher":{
        "@id":"https://www.srivasavi.co.in/#organization"
      }
    },

    {
      "@type":"Manufacturer",
      "@id":"https://www.srivasavi.co.in/#manufacturer",
      "name":"Sri Vasavi Pigments",
      "url":"https://www.srivasavi.co.in/",
      "foundingDate":"1997",
      "brand":"Plastimix",
      "description":"Manufacturer of Colour Masterbatches, White Masterbatches, Additive Masterbatches and Specialty Masterbatches for plastic applications across India."
    },

    {
      "@type":"ItemList",
      "name":"Masterbatch Products",
      "itemListElement":[

        {
          "@type":"Product",
          "position":1,
          "name":"Colour Masterbatches",
          "url":"https://www.srivasavi.co.in/colour-masterbatch.php",
          "brand":"Plastimix",
          "manufacturer":"Sri Vasavi Pigments"
        },

        {
          "@type":"Product",
          "position":2,
          "name":"White Masterbatches",
          "url":"https://www.srivasavi.co.in/white-masterbatch.php",
          "brand":"Plastimix",
          "manufacturer":"Sri Vasavi Pigments"
        },

        {
          "@type":"Product",
          "position":3,
          "name":"Additive Masterbatches",
          "url":"https://www.srivasavi.co.in/additive-masterbatches.php",
          "brand":"Plastimix",
          "manufacturer":"Sri Vasavi Pigments"
        },

        {
          "@type":"Product",
          "position":4,
          "name":"Antimicrobial Masterbatches",
          "brand":"Plastimix",
          "manufacturer":"Sri Vasavi Pigments"
        },

        {
          "@type":"Product",
          "position":5,
          "name":"Anti-Static Masterbatches",
          "brand":"Plastimix",
          "manufacturer":"Sri Vasavi Pigments"
        },

        {
          "@type":"Product",
          "position":6,
          "name":"Flame Retardant Masterbatches",
          "brand":"Plastimix",
          "manufacturer":"Sri Vasavi Pigments"
        },

        {
          "@type":"Product",
          "position":7,
          "name":"Anti-Rodent Masterbatches",
          "brand":"Plastimix",
          "manufacturer":"Sri Vasavi Pigments"
        }

      ]
    },

    {
      "@type":"FAQPage",
      "mainEntity":[

        {
          "@type":"Question",
          "name":"What products does Sri Vasavi Pigments manufacture?",
          "acceptedAnswer":{
            "@type":"Answer",
            "text":"Sri Vasavi Pigments manufactures Colour Masterbatches, White Masterbatches, Additive Masterbatches, Antimicrobial Masterbatches, Anti-Static Masterbatches, Flame Retardant Masterbatches and Anti-Rodent Masterbatches."
          }
        },

        {
          "@type":"Question",
          "name":"Where is Sri Vasavi Pigments located?",
          "acceptedAnswer":{
            "@type":"Answer",
            "text":"Sri Vasavi Pigments is located in Yanam, Puducherry, India and supplies masterbatch solutions across India."
          }
        },

        {
          "@type":"Question",
          "name":"Does Sri Vasavi Pigments offer custom colour matching?",
          "acceptedAnswer":{
            "@type":"Answer",
            "text":"Yes. Sri Vasavi Pigments develops custom colour masterbatch solutions tailored to specific polymer and application requirements."
          }
        },

        {
          "@type":"Question",
          "name":"What industries use Sri Vasavi Pigments masterbatches?",
          "acceptedAnswer":{
            "@type":"Answer",
            "text":"Industries including packaging, agriculture, water management, automotive, electrical, furniture and consumer products use Sri Vasavi Pigments masterbatches."
          }
        }

      ]
    }

  ]
}
</script>';

require __DIR__ . '/includes/user/header.php';
?>

    <main id="main">
        <section class="hero-slider-wrapper" aria-label="Hero Slider">
            <div class="hero-slider" id="hero-slider">
                <?php foreach ($banners as $idx => $b): 
                    $bImg = !empty($b['image']) ? base_url($b['image']) : base_url('assets/images/banner.jpg');
                ?>
                    <div class="hero-slide <?= $idx === 0 ? 'is-active' : '' ?>" style="background-image: url('<?= htmlspecialchars($bImg) ?>');">
                        <div class="container-fluid hero-inner">
                            <div class="hero-copy">
                                <div class="hero-kicker"><?= htmlspecialchars(strip_tags((string)$b['kicker'])) ?><sup aria-hidden="true">®</sup></div>
                                <b><div class="hero-sub"><?= $b['title'] ?></div></b>
                                <a class="btn btn-primary" href="<?= base_url(ltrim($b['button_url'], './')) ?>"><?= htmlspecialchars(strip_tags((string)$b['button_text'])) ?></a>
                            </div>
                            <div class="hero-spacer" aria-hidden="true"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <?php if (count($banners) > 1): ?>
                <button class="slider-arrow prev" id="slider-prev" aria-label="Previous slide" type="button"><i class="fa-solid fa-chevron-left"></i></button>
                <button class="slider-arrow next" id="slider-next" aria-label="Next slide" type="button"><i class="fa-solid fa-chevron-right"></i></button>
                
                <div class="slider-dots" id="slider-dots">
                    <?php foreach ($banners as $idx => $b): ?>
                        <button class="slider-dot <?= $idx === 0 ? 'is-active' : '' ?>" data-slide="<?= $idx ?>" aria-label="Go to slide <?= $idx + 1 ?>" type="button"></button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <section class="stats" aria-label="Key metrics">
            <div class="container-fluid stats-inner">
                <?php foreach ($stats as $s): ?>
                    <div class="stat">
                        <div class="stat-value" role="heading" aria-level="3">
                            <span class="stat-num"><?= htmlspecialchars((string)$s['value']) ?></span>
                            <span class="stat-plus">+</span>
                            <span class="stat-label"><?= htmlspecialchars((string)$s['label']) ?></span>
                        </div>
                        <div class="stat-sub"><?= htmlspecialchars((string)$s['sub']) ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="legacy" aria-label="Legacy">
            <div class="container-fluid legacy-inner">
                <div class="legacy-media">
                    <?php
                    $legacyImage = !empty($homeData['legacy_image']) ? base_url($homeData['legacy_image']) : base_url('assets/images/1.jpg');
                    ?>
                    <img class="legacy-img" src="<?= htmlspecialchars($legacyImage) ?>" alt="Masterbatch manufacturing samples" loading="lazy" />
                </div>
                <div class="legacy-copy">
                    <h2 class="section-title"><?= htmlspecialchars(strip_tags((string)$homeData['legacy_title'])) ?></h2>
                    <div class="section-text">
                        <?= $homeData['legacy_text'] ?>
                    </div>
                </div>
            </div>
        </section>

        <section class="pillars" aria-label="Key strengths">
            <div class="container-fluid pillars-inner">
                <?php foreach ($pillars as $p): ?>
                    <div class="pillar-card">
                        <div class="pillar-ico" aria-hidden="true">
                            <img class="pillar-svg" src="<?= htmlspecialchars((string)$p['icon']) ?>" alt="" />
                        </div>
                        <div class="pillar-title"><?= htmlspecialchars(strip_tags((string)$p['title'])) ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section id="about" class="about" aria-label="About us">
            <div class="container-fluid about-inner">
                <div class="about-copy">
                    <h2 class="section-title about-title"><?= htmlspecialchars(strip_tags((string)($aboutUsData['main_heading'] ?? 'About us'))) ?></h2>
                    <div class="section-text">
                        <?= mb_strimwidth(strip_tags((string)($aboutUsData['main_text'] ?? '')), 0, 250, '...') ?>
                    </div>
                    <br>
                    <a class="btn btn-primary" href="<?= base_url('about') ?>">Read More</a>
                </div>
                <div class="about-media">
                    <?php
                    $aboutImage = !empty($aboutUsData['image_on_home_page']) ? base_url($aboutUsData['image_on_home_page']) : base_url('assets/images/about-us.jpg');
                    ?>
                    <img class="about-img" src="<?= htmlspecialchars($aboutImage) ?>" alt="Masterbatch pellets" loading="lazy" />
                </div>
            </div>
        </section>

        <section id="products" class="products" aria-label="Our products">
            <div class="container-fluid">
                <h2 class="section-title center">Our Products</h2>
                <div class="product-grid">
                    <?php
                    $dbProducts = get_result("SELECT * FROM `products` ORDER BY `id` ASC LIMIT 3");
                    foreach ($dbProducts as $prod):
                        $slug = $prod['slug'];
                        if ($slug === 'colour-masterbatches' || $slug === 'colour-masterbatch') {
                            $prodUrl = base_url('colour-masterbatch');
                        } elseif ($slug === 'white-masterbatches' || $slug === 'white-masterbatch') {
                            $prodUrl = base_url('white-masterbatch');
                        } elseif ($slug === 'additive-masterbatches') {
                            $prodUrl = base_url('additive-masterbatches');
                        } elseif ($slug === 'filler-masterbatches') {
                            $prodUrl = base_url('filler-masterbatches');
                        } else {
                            $prodUrl = base_url('product/' . $slug);
                        }
                        $prodImg = base_url(ltrim((string)($prod['image_1'] ?? ''), '/'));
                    ?>
                        <article class="product-card" id="product-<?= htmlspecialchars($prod['slug']) ?>">
                            <a class="product-card__link" href="<?= htmlspecialchars($prodUrl) ?>" aria-label="<?= htmlspecialchars($prod['product_name']) ?>">
                                <div class="product-media">
                                    <div class="product-media-circle">
                                        <img class="product-img" src="<?= htmlspecialchars($prodImg) ?>" alt="<?= htmlspecialchars($prod['product_name']) ?>" loading="lazy" />
                                    </div>
                                </div>
                                <h3 class="product-title"><?= htmlspecialchars($prod['product_name']) ?></h3>
                                <p class="product-desc"><?= strip_tags((string)($prod['description_on_home_page'] ?? '')) ?></p>
                            </a>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section id="industries" class="industries" aria-label="Industries">
            <div class="container-fluid">
                <div class="industries-inner">
                    <div class="industries-copy">
                        <h2 class="section-title"><?= htmlspecialchars(strip_tags((string)($homeData['industries_title'] ?? 'Empowering Innovation Across Industries'))) ?></h2>
                        <div class="section-text">
                            <?= $homeData['industries_text'] ?? '' ?>
                        </div>
                        <br>
                        <a class="btn btn-primary" href="<?= base_url('contact') ?>">Contact Us</a>
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

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const slides = document.querySelectorAll("#hero-slider .hero-slide");
            const dots = document.querySelectorAll("#slider-dots .slider-dot");
            const prevBtn = document.getElementById("slider-prev");
            const nextBtn = document.getElementById("slider-next");
            
            if (slides.length <= 1) return;
            
            let currentSlide = 0;
            let slideInterval = setInterval(nextSlide, 6000); // Auto-rotation every 6 seconds
            
            function showSlide(index) {
                // Clear active states
                slides[currentSlide].classList.remove("is-active");
                if (dots.length > 0) dots[currentSlide].classList.remove("is-active");
                
                // Set new active slide
                currentSlide = (index + slides.length) % slides.length;
                
                slides[currentSlide].classList.add("is-active");
                if (dots.length > 0) dots[currentSlide].classList.add("is-active");
            }
            
            function nextSlide() {
                showSlide(currentSlide + 1);
            }
            
            function prevSlide() {
                showSlide(currentSlide - 1);
            }
            
            function resetInterval() {
                clearInterval(slideInterval);
                slideInterval = setInterval(nextSlide, 6000);
            }
            
            if (nextBtn) {
                nextBtn.addEventListener("click", function () {
                    nextSlide();
                    resetInterval();
                });
            }
            
            if (prevBtn) {
                prevBtn.addEventListener("click", function () {
                    prevSlide();
                    resetInterval();
                });
            }
            
            dots.forEach(dot => {
                dot.addEventListener("click", function () {
                    const slideIndex = parseInt(this.getAttribute("data-slide"));
                    showSlide(slideIndex);
                    resetInterval();
                });
            });

            // Touch Swipe Support
            let startX = 0;
            let endX = 0;
            const slider = document.getElementById("hero-slider");

            if (slider) {
                slider.addEventListener("touchstart", function (e) {
                    startX = e.touches[0].clientX;
                }, { passive: true });

                slider.addEventListener("touchend", function (e) {
                    endX = e.changedTouches[0].clientX;
                    const diffX = startX - endX;
                    if (Math.abs(diffX) > 50) { // Threshold of 50px swipe
                        if (diffX > 0) {
                            nextSlide(); // Swipe left -> next
                        } else {
                            prevSlide(); // Swipe right -> prev
                        }
                        resetInterval();
                    }
                }, { passive: true });
            }
        });
    </script>

<?php require __DIR__ . '/includes/user/footer.php'; ?>
