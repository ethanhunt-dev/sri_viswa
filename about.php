<?php
declare(strict_types=1);

/* ============================================================
 *  SECTION 1 — DEPENDENCIES
 *  Loads the database helper so we can call db() later.
 * ============================================================ */
require_once __DIR__ . '/includes/db.php';


/* ============================================================
 *  SECTION 2 — SITE-WIDE CONFIG
 *  Brand name and tagline used in the header / meta tags.
 * ============================================================ */
$site = [
    'brand'   => 'SRI VASAVI',
    'tagline' => 'Delivering Polymer Solutions since 2007',
];


/* ============================================================
 *  SECTION 3 — NAVIGATION LINKS
 *  Each item has a visible label and a href.
 *  The header partial loops over this array to build the <nav>.
 * ============================================================ */
$nav = [
    ['label' => 'Home',       'href' => './index.php'],
    ['label' => 'About Us',   'href' => './about.php'],
    ['label' => 'Industries', 'href' => './industries.php'],
    ['label' => 'R & D',      'href' => './rd.php'],
    ['label' => 'Products',   'href' => './index.php#products'],
    ['label' => 'Contact Us', 'href' => './contact.php'],
];


/* ============================================================
 *  SECTION 4 — PAGE META
 *  These variables are read by includes/user/header.php and
 *  injected into <title>, <meta description>, etc.
 * ============================================================ */
$pageTitle       = 'About Us - ' . $site['brand'];
$metaDescription = 'Learn about Sri Vasavi Pigments, a masterbatch and compound manufacturer established in 1997 with a manufacturing facility in Yanam, Puducherry.';
$metaKeywords    = 'Sri Vasavi Pigments about us, Plastimix, masterbatch manufacturer, polymer compounds';
$robots          = 'index,follow';


/* ============================================================
 *  SECTION 5 — DEFAULT / FALLBACK DATA
 *
 *  These values are shown when the database is unavailable
 *  OR when the relevant DB table is empty.
 *
 *  $aboutRow          — empty array; filled from DB below.
 *  $timelineMilestones — 4 hardcoded milestones used as fallback.
 * ============================================================ */
$aboutRow = [];  // Will be overwritten if the DB has a row.

$timelineMilestones = [];


/* ============================================================
 *  SECTION 6 — DATABASE QUERIES
 *
 *  Wrapped in try/catch so a DB failure does NOT crash the page.
 *  On failure the fallback data from Section 5 is used silently.
 *
 *  Query 1: about_us table
 *    - Fetches the most recently updated row (ORDER BY id DESC).
 *    - Provides: main_heading, main_text, main_image, description.
 *
 *  Query 2: year table
 *    - Fetches all milestone rows sorted oldest → newest.
 *    - Overwrites $timelineMilestones only when rows are found.
 * ============================================================ */
try {
    $pdo = db(); // Opens a PDO connection via the helper in db.php.

    // --- About Us content ---
    $row = $pdo
        ->query('SELECT * FROM `about_us` ORDER BY id DESC LIMIT 1')
        ->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $aboutRow = $row; // Replace empty array with real DB data.
    }

    // --- Timeline milestones ---
    $rows = $pdo
        ->query('SELECT year, text FROM `year` ORDER BY year ASC')
        ->fetchAll(PDO::FETCH_ASSOC);

    if ($rows) {
        $timelineMilestones = $rows; // Replace fallback array with DB rows.
    }

} catch (Throwable) {
    // DB is down or query failed — keep the fallback values from Section 5.
    $aboutRow = [];
    $timelineMilestones = [];
}


/* ============================================================
 *  SECTION 7 — PREPARE TEMPLATE VARIABLES
 *
 *  Extract the values we actually need from $aboutRow so the
 *  HTML below stays clean and readable.
 *
 *  $mainImage        — image path stored in DB, trimmed of leading ./
 *  $aboutDescription — prefers main_text; falls back to description.
 * ============================================================ */
$mainImage        = trim((string) ($aboutRow['main_image']));
$aboutDescription = strip_tags((string) ($aboutRow['main_text']));


/* ============================================================
 *  SECTION 8 — HEADER PARTIAL
 *  Outputs <head>, opens <body>, and renders the site nav.
 *  It reads $pageTitle, $metaDescription, $metaKeywords,
 *  $robots, $site, and $nav set above.
 * ============================================================ */
$pageSchema = '<!-- Schema markup -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [

    {
      "@type": "AboutPage",
      "@id": "https://www.srivasavi.co.in/about.php#aboutpage",
      "url": "https://www.srivasavi.co.in/about.php",
      "name": "About Sri Vasavi Pigments",
      "description": "Sri Vasavi Pigments is a leading Masterbatch Manufacturer in India established in 1997, offering Colour Masterbatches, White Masterbatches, Additive Masterbatches and specialty masterbatch solutions.",
      "isPartOf": {
        "@id": "https://www.srivasavi.co.in/#website"
      }
    },

    {
      "@type": "Organization",
      "@id": "https://www.srivasavi.co.in/#organization",
      "name": "Sri Vasavi Pigments",
      "url": "https://www.srivasavi.co.in/",
      "logo": "https://www.srivasavi.co.in/assets/images/logo.png",
      "email": "info@vasavipigments.com",
      "telephone": "+91-884-2321425",
      "foundingDate": "1997",
      "brand": {
        "@type": "Brand",
        "name": "Plastimix"
      },
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "1-13-056, Gopal Nagar",
        "addressLocality": "Yanam",
        "postalCode": "533464",
        "addressRegion": "Puducherry",
        "addressCountry": "IN"
      }
    },

    {
      "@type": "Manufacturer",
      "@id": "https://www.srivasavi.co.in/#manufacturer",
      "name": "Sri Vasavi Pigments",
      "url": "https://www.srivasavi.co.in/",
      "description": "Manufacturer of Colour Masterbatches, White Masterbatches, Additive Masterbatches, Antimicrobial Masterbatches, Anti-Static Masterbatches, Flame Retardant Masterbatches and Anti-Rodent Masterbatches."
    },

    {
      "@type": "BreadcrumbList",
      "@id": "https://www.srivasavi.co.in/about.php#breadcrumb",
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "name": "Home",
          "item": "https://www.srivasavi.co.in/"
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": "About Us",
          "item": "https://www.srivasavi.co.in/about.php"
        }
      ]
    },

    {
      "@type": "FAQPage",
      "mainEntity": [

        {
          "@type": "Question",
          "name": "When was Sri Vasavi Pigments established?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Sri Vasavi Pigments was established in 1997 and has over 28 years of experience in manufacturing masterbatches and polymer compounds."
          }
        },

        {
          "@type": "Question",
          "name": "What products does Sri Vasavi Pigments manufacture?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Sri Vasavi Pigments manufactures Colour Masterbatches, White Masterbatches, Additive Masterbatches, Antimicrobial Masterbatches, Anti-Static Masterbatches, Flame Retardant Masterbatches and Anti-Rodent Masterbatches."
          }
        },

        {
          "@type": "Question",
          "name": "Is Sri Vasavi Pigments a masterbatch manufacturer in India?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Yes. Sri Vasavi Pigments is a leading masterbatch manufacturer in India supplying innovative masterbatch solutions to plastic manufacturers nationwide."
          }
        },

        {
          "@type": "Question",
          "name": "Does Sri Vasavi Pigments supply masterbatches to Chennai?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Yes. Sri Vasavi Pigments supplies Colour Masterbatches, White Masterbatches and Additive Masterbatches to manufacturers in Chennai and throughout South India."
          }
        },

        {
          "@type": "Question",
          "name": "Can Sri Vasavi Pigments develop custom colour masterbatches?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Yes. Sri Vasavi Pigments offers custom colour matching services and develops colour masterbatches tailored to specific polymers, applications and customer requirements."
          }
        },

        {
          "@type": "Question",
          "name": "What industries use Sri Vasavi Pigments masterbatches?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Our masterbatches are used in flexible packaging, rigid packaging, water management, agriculture, automotive, electrical, furniture and appliance manufacturing industries."
          }
        },

        {
          "@type": "Question",
          "name": "What specialty additive masterbatches are available?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "We manufacture Antimicrobial Masterbatches, Anti-Static Masterbatches, Flame Retardant Masterbatches and Anti-Rodent Masterbatches for specialized plastic applications."
          }
        }

      ]
    }

  ]
}
</script>';

require __DIR__ . '/includes/user/header.php';
?>


<!-- ===========================================================
     SECTION 9 — PAGE CONTENT
     Three sections make up this page:
       9a. About Us hero  (image + heading + description text)
       9b. Core Values    (auto-scrolling carousel)
       9c. Timeline       (horizontal slider with modal popups)
     =========================================================== -->
<main id="main">


    <!-- -------------------------------------------------------
         9a. ABOUT US HERO
         Layout: image on the left, copy (heading + text) on the right.
         Both the image and heading are optional — they only render
         when the DB has supplied a value for them.
         ------------------------------------------------------- -->
    <section class="about-page" aria-label="About us">
        <div class="container-fluid">
            <div class="about-page-inner">

                <!-- Left column: company image (hidden from screen readers) -->
                <div class="about-page-media" aria-hidden="true">
                    <?php if ($mainImage !== ''): ?>
                        <!-- ltrim removes any leading "./" from the DB-stored path -->
                        <img
                            class="about-page-img"
                            src="<?= htmlspecialchars(base_url(ltrim($mainImage, './'))) ?>"
                            alt=""
                            loading="lazy"
                        />
                    <?php endif; ?>
                </div>

                <!-- Right column: heading, body text, CTA button -->
                <div class="about-page-copy">

                    <?php if (!empty($aboutRow['main_heading'])): ?>
                        <!-- h1 is the page's primary heading for SEO -->
                        <h1 class="about-page-title">
                            <?= htmlspecialchars((string) $aboutRow['main_heading']) ?>
                        </h1>
                    <?php endif; ?>

                    <?php if ($aboutDescription !== ''): ?>
                        <!-- innerHTML (not escaped) because the DB stores formatted HTML -->
                        <div class="about-page-description-wrap">
                            <?= $aboutDescription ?>
                        </div>
                    <?php endif; ?>

                    <!-- CTA button — always shown regardless of DB content -->
                    <a class="btn btn-primary about-page-btn" href="industries.php">
                        Explore Our Products
                    </a>

                </div>
            </div>
        </div>
    </section>


    <!-- -------------------------------------------------------
         9b. CORE VALUES CAROUSEL
         Five static cards in a horizontal scroll track.
         JavaScript (Section 11a) auto-advances every 4.5 s,
         pauses on hover/focus, and builds the dot indicators.
         Cards are hardcoded — they are not DB-driven.
         ------------------------------------------------------- -->
    <section class="cv" aria-label="Core values">
        <div class="container-fluid">
            <h2 class="cv-title">Core Values</h2>

            <!-- data-slider="core-values" is the JS hook -->
            <div class="cv-slider" data-slider="core-values">
                <div class="cv-track">

                    <article class="cv-slide">
                        <div class="cv-card">
                            <div class="cv-ico" aria-hidden="true">
                                <img class="cv-ico-img" src="assets/images/Quality-Uncompromised.png" alt="" width="150" height="150" loading="lazy" />
                            </div>
                            <div class="cv-head">Quality Uncompromised</div>
                            <div class="cv-text">We are committed to provide superior products that meet standards and exceed expectations.</div>
                        </div>
                    </article>

                    <article class="cv-slide">
                        <div class="cv-card">
                            <div class="cv-ico" aria-hidden="true">
                                <img class="cv-ico-img" src="assets/images/Quality-Uncompromised-1-150x150.png" alt="" width="150" height="150" loading="lazy" />
                            </div>
                            <div class="cv-head">Reliability You Can Trust</div>
                            <div class="cv-text">With streamlined processes and a dedicated team, you can count on us to deliver excellence on time, every time.</div>
                        </div>
                    </article>

                    <article class="cv-slide">
                        <div class="cv-card">
                            <div class="cv-ico" aria-hidden="true">
                                <img class="cv-ico-img" src="./assets/images/Transparency-at-Our-Core-150x150.png" alt="" width="150" height="150" loading="lazy" />
                            </div>
                            <div class="cv-head">Transparency at Our Core</div>
                            <div class="cv-text">We believe in a spectrum of transparency, from crystal-clear communication to ethical business practices.</div>
                        </div>
                    </article>

                    <article class="cv-slide">
                        <div class="cv-card">
                            <div class="cv-ico" aria-hidden="true">
                                <img class="cv-ico-img" src="./assets/images/Innovation-for-Tomorrow-150x150.png" alt="" width="150" height="150" loading="lazy" />
                            </div>
                            <div class="cv-head">Innovation for Tomorrow</div>
                            <div class="cv-text">Our ongoing research and development ensures we stay at the forefront of the industry.</div>
                        </div>
                    </article>

                    <article class="cv-slide">
                        <div class="cv-card">
                            <div class="cv-ico" aria-hidden="true">
                                <img class="cv-ico-img" src="./assets/images/Innovation-for-Tomorrow-1-150x150.png" alt="" width="150" height="150" loading="lazy" />
                            </div>
                            <div class="cv-head">Relationships Built to Last</div>
                            <div class="cv-text">We believe in fostering enduring relationships built on trust and mutual respect.</div>
                        </div>
                    </article>

                </div>

                <!-- Dot buttons are injected here by JavaScript (Section 11a) -->
                <div class="cv-dots" aria-label="Carousel navigation" role="tablist"></div>
            </div>
        </div>
    </section>


    <!-- -------------------------------------------------------
         9c. COMPANY TIMELINE
         Milestones come from the DB (or fallback array).
         Each milestone is a <button> that opens a modal popup
         with the full detail text.
         JS hooks: data-slider="about-timeline" (Section 11b)
                   #about-tl-modal               (Section 11c)
         ------------------------------------------------------- -->
    <?php if (!empty($timelineMilestones)): ?>
    <section class="about-timeline" aria-label="Company timeline">
        <div class="container-fluid about-timeline-inner">
            <h2 class="about-tl-title">A Legacy of Innovation and Growth</h2>

            <!-- data-slider="about-timeline" is the JS hook -->
            <div class="about-tl-slider" data-slider="about-timeline">

                <!-- Prev arrow — JS scrolls the viewport left -->
                <button type="button" class="about-tl-arrow about-tl-arrow--prev" aria-label="Show previous milestone">
                    <i class="fa-solid fa-angle-left" aria-hidden="true"></i>
                </button>

                <div class="about-tl-viewport">
                    <div class="about-tl-track">

                        <?php foreach ($timelineMilestones as $m): ?>
                            <?php
                            // $detail  — full text shown in the modal (may contain HTML from DB).
                            // $preview — plain-text version shown on the card (HTML stripped).
                            // $useClamp — always true here; CSS clamps preview to 2–3 lines.
                            $detail  = $m['detail'] ?? $m['text'];
                            $preview = html_entity_decode(strip_tags($m['text']), ENT_QUOTES, 'UTF-8');
                            $useClamp = true;
                            ?>
                            <article class="about-tl-item">
                                <!--
                                    Clicking this button opens the modal.
                                    data-tl-year   — displayed as the modal heading.
                                    data-tl-detail — injected as innerHTML into the modal body.
                                -->
                                <button
                                    type="button"
                                    class="about-tl-trigger"
                                    aria-label="Open full story for <?= htmlspecialchars($m['year']) ?>"
                                    data-tl-year="<?= htmlspecialchars($m['year'],  ENT_QUOTES, 'UTF-8') ?>"
                                    data-tl-detail="<?= htmlspecialchars($detail,   ENT_QUOTES, 'UTF-8') ?>"
                                >
                                    <!-- Visual dot + vertical stem on the timeline line -->
                                    <div class="about-tl-node" aria-hidden="true">
                                        <span class="about-tl-dot"></span>
                                        <span class="about-tl-stem"></span>
                                    </div>

                                    <span class="about-tl-year"><?= htmlspecialchars($m['year']) ?></span>

                                    <!-- about-tl-text--clamp limits height via CSS line-clamp -->
                                    <span class="about-tl-text<?= $useClamp ? ' about-tl-text--clamp' : '' ?>">
                                        <?= htmlspecialchars($preview) ?>
                                    </span>
                                </button>
                            </article>
                        <?php endforeach; ?>

                    </div>
                </div>

                <!-- Next arrow — JS scrolls the viewport right -->
                <button type="button" class="about-tl-arrow about-tl-arrow--next" aria-label="Show next milestone">
                    <i class="fa-solid fa-angle-right" aria-hidden="true"></i>
                </button>
            </div>


            <!-- ---------------------------------------------------
                 TIMELINE MODAL
                 Hidden by default (hidden attribute + aria-hidden).
                 JS in Section 11c populates #about-tl-modal-detail
                 and #about-tl-modal-year, then removes the hidden attr.
                 Closes on: backdrop click, × button, Escape key.
                 --------------------------------------------------- -->
            <div
                class="about-tl-modal"
                id="about-tl-modal"
                hidden
                aria-hidden="true"
                role="dialog"
                aria-modal="true"
                aria-labelledby="about-tl-modal-detail"
            >
                <!-- Semi-transparent backdrop; clicking it closes the modal -->
                <div class="about-tl-modal__backdrop" data-about-tl-close tabindex="-1"></div>

                <!-- × close button in the top-right corner -->
                <button type="button" class="about-tl-modal__close-corner" data-about-tl-close aria-label="Close">
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                </button>

                <div class="about-tl-modal__panel">
                    <!-- Detail injected as innerHTML so DB HTML formatting is preserved -->
                    <div id="about-tl-modal-detail" class="about-tl-modal__detail"></div>
                    <!-- Year text injected as textContent (plain, no HTML needed) -->
                    <p class="about-tl-modal__year" id="about-tl-modal-year"></p>
                </div>
            </div>

        </div>
    </section>
    <?php endif; ?>
</main>


<!-- ===========================================================
     SECTION 10 — FOOTER PARTIAL
     Closes </body> and </html>, renders footer links / copyright.
     =========================================================== -->
<?php require __DIR__ . '/includes/user/footer.php'; ?>


<script>
/* ===========================================================
   SECTION 11 — CLIENT-SIDE JAVASCRIPT
   Three self-contained IIFEs (immediately invoked functions)
   so their variables don't pollute the global scope.

     11a — Core Values carousel   (auto-scroll + dot nav)
     11b — Timeline slider        (prev/next arrows)
     11c — Timeline modal         (open / close / keyboard)
   =========================================================== */


/* -----------------------------------------------------------
   11a. CORE VALUES CAROUSEL
   - Reads slides from .cv-track > .cv-slide
   - Builds dot buttons and injects them into .cv-dots
   - Auto-advances every 4500 ms
   - Pauses on mouseenter / focusin; resumes on leave / focusout
   - Respects prefers-reduced-motion (no animation if enabled)
   ----------------------------------------------------------- */
(function () {
    const root     = document.querySelector('[data-slider="core-values"]');
    if (!root) return;

    const track    = root.querySelector('.cv-track');
    const dotsWrap = root.querySelector('.cv-dots');
    if (!track || !dotsWrap) return;

    const slides = Array.from(track.querySelectorAll('.cv-slide'));
    if (slides.length === 0) return;

    // Honour the OS "reduce motion" accessibility setting.
    const reduceMotion = window.matchMedia &&
                         window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const intervalMs = 4500; // Time between auto-advances (ms).

    let dots   = [];
    let index  = 0;      // Index of the currently visible slide.
    let timer  = null;   // Holds the setInterval reference.
    let paused = false;  // True while the user is hovering / focusing.

    /* Build one <button> dot per slide and append to .cv-dots */
    const buildDots = () => {
        dotsWrap.innerHTML = '';
        dots = slides.map((_, i) => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'cv-dot';
            btn.setAttribute('role', 'tab');
            btn.setAttribute('aria-label', 'Slide ' + (i + 1));
            btn.setAttribute('aria-selected', i === 0 ? 'true' : 'false');
            btn.addEventListener('click', () => { go(i, true); restart(); });
            dotsWrap.appendChild(btn);
            return btn;
        });
    };

    /* Update aria attributes on all dots to reflect the active index */
    const setCurrent = (idx) => {
        index = idx;
        dots.forEach((d, i) => {
            d.setAttribute('aria-selected', i === idx ? 'true' : 'false');
            d.setAttribute('aria-current',  i === idx ? 'true' : 'false');
        });
    };

    /* Find which slide is closest to the current scroll position */
    const nearestIndex = () => {
        const x = track.scrollLeft;
        let best = 0, bestDist = Infinity;
        slides.forEach((s, i) => {
            const d = Math.abs(s.offsetLeft - x);
            if (d < bestDist) { bestDist = d; best = i; }
        });
        return best;
    };

    /* Scroll the track to a specific slide index */
    const go = (idx, smooth) => {
        const clamped = Math.max(0, Math.min(slides.length - 1, idx));
        const slide   = slides[clamped];
        if (!slide) return;
        track.scrollTo({
            left:     slide.offsetLeft,
            behavior: !reduceMotion && smooth ? 'smooth' : 'auto',
        });
        setCurrent(clamped);
    };

    /* Advance to the next slide (wraps back to 0 at the end) */
    const next = () => {
        const nxt = index >= slides.length - 1 ? 0 : index + 1;
        go(nxt, true);
    };

    const start   = () => { if (timer || reduceMotion || slides.length < 2) return; timer = window.setInterval(next, intervalMs); };
    const stop    = () => { if (!timer) return; window.clearInterval(timer); timer = null; };
    const restart = () => { stop(); if (!paused) start(); };

    // Initialise dots and position at slide 0.
    buildDots();
    setCurrent(0);

    // Keep dot highlight in sync when the user scrolls manually.
    track.addEventListener('scroll', () => {
        window.requestAnimationFrame(() => setCurrent(nearestIndex()));
    }, { passive: true });

    // Pause auto-advance while the user interacts with the carousel.
    root.addEventListener('mouseenter', () => { paused = true;  stop();  });
    root.addEventListener('mouseleave', () => { paused = false; start(); });
    root.addEventListener('focusin',    () => { paused = true;  stop();  });
    root.addEventListener('focusout',   () => { paused = false; start(); });

    // Re-snap on resize so the correct slide stays fully in view.
    window.addEventListener('resize', () => { go(nearestIndex(), false); });

    start(); // Begin auto-advancing.
})();


/* -----------------------------------------------------------
   11b. TIMELINE SLIDER (prev / next arrows)
   - Scrolls .about-tl-viewport left or right by one item.
   - On desktop (≥900 px) items are flush-left; on mobile they
     are centred in the viewport.
   - Wraps around at both ends (last → first, first → last).
   ----------------------------------------------------------- */
(function () {
    const root     = document.querySelector('[data-slider="about-timeline"]');
    if (!root) return;

    const viewport = root.querySelector('.about-tl-viewport');
    const track    = root.querySelector('.about-tl-track');
    const prevBtn  = root.querySelector('.about-tl-arrow--prev');
    const nextBtn  = root.querySelector('.about-tl-arrow--next');
    if (!viewport || !track) return;

    const items      = Array.from(track.querySelectorAll('.about-tl-item'));
    if (items.length === 0) return;

    const reduceMotion = window.matchMedia &&
                         window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const desktopMq    = window.matchMedia('(min-width: 900px)');
    let index = 0;

    /* Calculate the scroll target for a given item element.
       Desktop: align to the item's left edge.
       Mobile:  centre the item inside the viewport. */
    const scrollTargetFor = (el) => {
        if (desktopMq.matches) return el.offsetLeft;
        return Math.max(0, el.offsetLeft - (viewport.clientWidth - el.offsetWidth) / 2);
    };

    /* Find the item index closest to the current scroll position */
    const nearestIndex = () => {
        const x = viewport.scrollLeft;
        let best = 0, bestDist = Infinity;
        items.forEach((el, i) => {
            const d = Math.abs(scrollTargetFor(el) - x);
            if (d < bestDist || (d === bestDist && i < best)) { bestDist = d; best = i; }
        });
        return best;
    };

    /* Scroll to a specific item index */
    const go = (idx, smooth) => {
        const clamped  = Math.max(0, Math.min(items.length - 1, idx));
        const el       = items[clamped];
        if (!el) return;
        const maxScroll = Math.max(0, viewport.scrollWidth - viewport.clientWidth);
        const left      = Math.max(0, Math.min(scrollTargetFor(el), maxScroll));
        viewport.scrollTo({ left, behavior: !reduceMotion && smooth ? 'smooth' : 'auto' });
        index = clamped;
    };

    // Arrow button click handlers (wrap at both ends).
    prevBtn && prevBtn.addEventListener('click', () => {
        go(index <= 0 ? items.length - 1 : index - 1, true);
    });
    nextBtn && nextBtn.addEventListener('click', () => {
        go(index >= items.length - 1 ? 0 : index + 1, true);
    });

    go(0, false); // Start at the first item.

    // Keep index in sync when the user scrolls manually.
    viewport.addEventListener('scroll', () => {
        window.requestAnimationFrame(() => { index = nearestIndex(); });
    }, { passive: true });

    // Re-snap when window or breakpoint changes.
    const onResize = () => { go(nearestIndex(), false); };
    window.addEventListener('resize', onResize);
    if (desktopMq.addEventListener) { desktopMq.addEventListener('change', onResize); }
    else if (desktopMq.addListener) { desktopMq.addListener(onResize); }
})();


/* -----------------------------------------------------------
   11c. TIMELINE MODAL
   - Each .about-tl-trigger button carries two data attributes:
       data-tl-year   — year string
       data-tl-detail — full milestone text (may be HTML)
   - openModal() copies those into the modal and shows it.
   - closeModal() hides the modal and returns focus to the
     trigger that opened it (accessibility best practice).
   - Closes on: backdrop click, × button, Escape key.
   ----------------------------------------------------------- */
(function () {
    const modal    = document.getElementById('about-tl-modal');
    if (!modal) return;

    const detailEl = document.getElementById('about-tl-modal-detail');
    const yearEl   = document.getElementById('about-tl-modal-year');
    if (!detailEl || !yearEl) return;

    let lastTrigger = null; // Remember which button opened the modal.

    /* Show the modal and populate it with the milestone data */
    const openModal = (trigger) => {
        const detail = trigger.getAttribute('data-tl-detail') || '';
        const year   = trigger.getAttribute('data-tl-year')   || '';

        detailEl.innerHTML  = detail; // innerHTML so DB HTML formatting is preserved.
        yearEl.textContent  = year;   // textContent for the year (plain text only needed).

        lastTrigger = trigger;
        modal.removeAttribute('hidden');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('about-tl-modal-open'); // Prevents background scroll.

        // Move focus into the modal for keyboard / screen-reader users.
        const closeBtn = modal.querySelector('.about-tl-modal__close-corner');
        if (closeBtn) closeBtn.focus();
    };

    /* Hide the modal and return focus to the button that opened it */
    const closeModal = () => {
        modal.setAttribute('hidden', '');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('about-tl-modal-open');
        if (lastTrigger && typeof lastTrigger.focus === 'function') {
            lastTrigger.focus(); // Return focus for accessibility.
        }
        lastTrigger = null;
    };

    // Attach open handler to every timeline card button.
    document.querySelectorAll('.about-tl-trigger').forEach((btn) => {
        btn.addEventListener('click', () => openModal(btn));
    });

    // Attach close handler to backdrop and × button (both carry data-about-tl-close).
    modal.querySelectorAll('[data-about-tl-close]').forEach((el) => {
        el.addEventListener('click', (e) => { e.preventDefault(); closeModal(); });
    });

    // Close on Escape key (standard modal accessibility pattern).
    document.addEventListener('keydown', (e) => {
        if (e.key !== 'Escape') return;
        if (modal.hasAttribute('hidden')) return; // Only act when modal is open.
        closeModal();
    });
})();
</script>