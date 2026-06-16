<?php
declare(strict_types=1);

$site = [
    'brand' => 'About Us - Vasavi Pigment
',
    'tagline' => 'Delivering Polymer Solutions since 2007',
];

$pageTitle = 'About Us - Vasavi Pigment';
$metaDescription = 'Learn about Sri Vasavi Pigments and our Plastimix® brand — a tradition of quality masterbatches since 1997, backed by strong manufacturing and customised solutions.';
$metaKeywords = 'about Sri Vasavi Pigments, Plastimix, masterbatch company, polymer solutions, Yanam manufacturing';
$robots = 'index,follow';

$nav = [
    ['label' => 'Home', 'href' => './index.php'],
    ['label' => 'About Us', 'href' => './about.php'],
    ['label' => 'Industries', 'href' => './industries.php'],
    ['label' => 'R & D', 'href' => './rd.php'],
    ['label' => 'Products', 'href' => './index.php#products'],
    ['label' => 'Contact Us', 'href' => './contact.php'],
];

require __DIR__ . '/includes/header.php';
?>

<main id="main">
    <section class="about-page" aria-label="About us">
        <div class="container-fluid">
            <div class="about-page-inner">
                <div class="about-page-media" aria-hidden="true">
                    <img class="about-page-img" src="./assets/images/about-hero.png" alt="" loading="lazy" />
                </div>

                <div class="about-page-copy">
                    <h1 class="about-page-title">A Tradition of Quality Masterbatches Since 1997</h1>
                    <p class="about-page-text">
                        Sri Vasavi Pigments, established in 1997, has been at the forefront of masterbatch innovation. Our journey began with establishing a manufacturing unit in Yanam, UT of Puducherry. Today, our brand, Plastimix<sup aria-hidden="true">®</sup>, operated with an ISO 9001:2015 certification, utilizes stringent quality control processes to provide customised solutions for your specific application needs.
                    </p>
                    <p class="about-page-text">
                        With 3 decades in the industry, we have a capacity of 12,000 TPA to meet the quantity requirements of our diverse clientele. We operate with a dedication to excellence in everything we do. Our commitment to exceeding customer expectations has made us a trusted partner for manufacturers across a wide range of industries.
                    </p>

<a class="btn btn-primary about-page-btn" href="industries.php">Explore Our Products</a>
                </div>
            </div>
        </div>
    </section>

    <?php
    $timelineMilestones = [
        [
            'year' => '1997',
            'text' => 'With an aim to manufacture superior quality masterbatches, SVPL was established.',
        ],
        [
            'year' => '1998',
            'text' => 'Began supplying chair compounds to major manufacturers.',
        ],
        [
            'year' => '2004',
            'text' => 'Focused on colour masterbatches for the packaging industry.',
        ],
        [
            'year' => '2005',
            'text' => 'Doubled production capacity with the purchase of additional twin screw extruders.',
        ],
        [
            'year' => '2014',
            'text' => 'Entered the export market, serving customers across various countries.',
        ],
        [
            'year' => '2017',
            'text' => 'Broadened our product range with a new line of additive masterbatches.',
        ],
        [
            'year' => '2019',
            'text' => 'Increased production capacity with the purchase of additional twin screw extruders.',
        ],
        [
            'year' => '2021',
            'text' => 'Established a new R&D laboratory with digital equipment, to drive innovation.',
        ],
        [
            'year' => '2022',
            'text' => 'Completed 25 years of delivering the best, always!',
        ],
    ];
    ?>

    

    <section class="cv" aria-label="Core values">
        <div class="container-fluid">
            <h2 class="cv-title">Core Values</h2>

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
                            <div class="cv-head">Relationships Built to Last: </div>
                            <div class="cv-text">We believe in fostering enduring relationships built on trust and mutual respect.</div>
                        </div>
                    </article>
                </div>

                <div class="cv-dots" aria-label="Carousel navigation" role="tablist"></div>
            </div>
        </div>
    </section>


    <section class="about-timeline" aria-label="Company timeline">
        <div class="container-fluid about-timeline-inner">
            <h2 class="about-tl-title">A Legacy of Innovation and Growth</h2>

            <div class="about-tl-slider" data-slider="about-timeline">
                <button type="button" class="about-tl-arrow about-tl-arrow--prev" aria-label="Show previous milestone">
                    <i class="fa-solid fa-angle-left" aria-hidden="true"></i>
                </button>
                <div class="about-tl-viewport">
                    <div class="about-tl-track">
                        <?php foreach ($timelineMilestones as $m): ?>
                            <?php
                            $detail = $m['detail'] ?? $m['text'];
                            $preview = $m['preview'] ?? $m['text'];
                            $useClamp = !isset($m['preview']);
                            ?>
                            <article class="about-tl-item">
                                <button
                                    type="button"
                                    class="about-tl-trigger"
                                    aria-label="Open full story for <?= htmlspecialchars($m['year']) ?>"
                                    data-tl-year="<?= htmlspecialchars($m['year'], ENT_QUOTES, 'UTF-8') ?>"
                                    data-tl-detail="<?= htmlspecialchars($detail, ENT_QUOTES, 'UTF-8') ?>"
                                >
                                    <div class="about-tl-node" aria-hidden="true">
                                        <span class="about-tl-dot"></span>
                                        <span class="about-tl-stem"></span>
                                    </div>
                                    <span class="about-tl-year"><?= htmlspecialchars($m['year']) ?></span>
                                    <span class="about-tl-text<?= $useClamp ? ' about-tl-text--clamp' : '' ?>"><?= htmlspecialchars($preview) ?></span>
                                </button>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </div>
                <button type="button" class="about-tl-arrow about-tl-arrow--next" aria-label="Show next milestone">
                    <i class="fa-solid fa-angle-right" aria-hidden="true"></i>
                </button>
            </div>

            <div
                class="about-tl-modal"
                id="about-tl-modal"
                hidden
                aria-hidden="true"
                role="dialog"
                aria-modal="true"
                aria-labelledby="about-tl-modal-detail"
            >
                <div class="about-tl-modal__backdrop" data-about-tl-close tabindex="-1"></div>
                <button type="button" class="about-tl-modal__close-corner" data-about-tl-close aria-label="Close">
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                </button>
                <div class="about-tl-modal__panel">
                    <p id="about-tl-modal-detail" class="about-tl-modal__detail"></p>
                    <p class="about-tl-modal__year" id="about-tl-modal-year"></p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>

<script>
    (function () {
        const root = document.querySelector('[data-slider="core-values"]');
        if (!root) return;
        const track = root.querySelector('.cv-track');
        const dotsWrap = root.querySelector('.cv-dots');
        if (!track || !dotsWrap) return;

        const slides = Array.from(track.querySelectorAll('.cv-slide'));
        if (slides.length === 0) return;

        const reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        const intervalMs = 4500;

        let dots = [];
        let index = 0;
        let timer = null;
        let paused = false;

        const buildDots = () => {
            dotsWrap.innerHTML = '';
            dots = slides.map((_, i) => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'cv-dot';
                btn.setAttribute('role', 'tab');
                btn.setAttribute('aria-label', 'Slide ' + (i + 1));
                btn.setAttribute('aria-selected', i === 0 ? 'true' : 'false');
                btn.addEventListener('click', () => {
                    go(i, true);
                    restart();
                });
                dotsWrap.appendChild(btn);
                return btn;
            });
        };

        const setCurrent = (idx) => {
            index = idx;
            dots.forEach((d, i) => {
                d.setAttribute('aria-selected', i === idx ? 'true' : 'false');
                d.setAttribute('aria-current', i === idx ? 'true' : 'false');
            });
        };

        const nearestIndex = () => {
            const x = track.scrollLeft;
            let best = 0;
            let bestDist = Infinity;
            slides.forEach((s, i) => {
                const d = Math.abs(s.offsetLeft - x);
                if (d < bestDist) {
                    bestDist = d;
                    best = i;
                }
            });
            return best;
        };

        const go = (idx, smooth) => {
            const clamped = Math.max(0, Math.min(slides.length - 1, idx));
            const slide = slides[clamped];
            if (!slide) return;
            track.scrollTo({
                left: slide.offsetLeft,
                behavior: !reduceMotion && smooth ? 'smooth' : 'auto',
            });
            setCurrent(clamped);
        };

        const next = () => {
            const nxt = index >= slides.length - 1 ? 0 : index + 1;
            go(nxt, true);
        };

        const start = () => {
            if (timer || reduceMotion || slides.length < 2) return;
            timer = window.setInterval(next, intervalMs);
        };

        const stop = () => {
            if (!timer) return;
            window.clearInterval(timer);
            timer = null;
        };

        const restart = () => {
            stop();
            if (!paused) start();
        };

        buildDots();
        setCurrent(0);

        track.addEventListener(
            'scroll',
            () => {
                window.requestAnimationFrame(() => setCurrent(nearestIndex()));
            },
            { passive: true },
        );

        root.addEventListener('mouseenter', () => {
            paused = true;
            stop();
        });
        root.addEventListener('mouseleave', () => {
            paused = false;
            start();
        });
        root.addEventListener('focusin', () => {
            paused = true;
            stop();
        });
        root.addEventListener('focusout', () => {
            paused = false;
            start();
        });

        window.addEventListener('resize', () => {
            go(nearestIndex(), false);
        });

        start();
    })();

    (function () {
        const root = document.querySelector('[data-slider="about-timeline"]');
        if (!root) return;
        const viewport = root.querySelector('.about-tl-viewport');
        const track = root.querySelector('.about-tl-track');
        const prevBtn = root.querySelector('.about-tl-arrow--prev');
        const nextBtn = root.querySelector('.about-tl-arrow--next');
        if (!viewport || !track) return;

        const items = Array.from(track.querySelectorAll('.about-tl-item'));
        if (items.length === 0) return;

        const reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        const desktopMq = window.matchMedia('(min-width: 900px)');
        let index = 0;

        const scrollTargetFor = function (el) {
            if (desktopMq.matches) {
                return el.offsetLeft;
            }
            return Math.max(0, el.offsetLeft - (viewport.clientWidth - el.offsetWidth) / 2);
        };

        const nearestIndex = function () {
            const x = viewport.scrollLeft;
            let best = 0;
            let bestDist = Infinity;
            items.forEach(function (el, i) {
                const target = scrollTargetFor(el);
                const d = Math.abs(target - x);
                if (d < bestDist || (d === bestDist && i < best)) {
                    bestDist = d;
                    best = i;
                }
            });
            return best;
        };

        const go = (idx, smooth) => {
            const clamped = Math.max(0, Math.min(items.length - 1, idx));
            const el = items[clamped];
            if (!el) return;
            let left = scrollTargetFor(el);
            const maxScroll = Math.max(0, viewport.scrollWidth - viewport.clientWidth);
            left = Math.max(0, Math.min(left, maxScroll));
            viewport.scrollTo({
                left: left,
                behavior: !reduceMotion && smooth ? 'smooth' : 'auto',
            });
            index = clamped;
        };

        prevBtn &&
            prevBtn.addEventListener('click', function () {
                go(index <= 0 ? items.length - 1 : index - 1, true);
            });
        nextBtn &&
            nextBtn.addEventListener('click', function () {
                go(index >= items.length - 1 ? 0 : index + 1, true);
            });

        go(0, false);

        viewport.addEventListener(
            'scroll',
            function () {
                window.requestAnimationFrame(function () {
                    index = nearestIndex();
                });
            },
            { passive: true },
        );

        const onResize = function () {
            go(nearestIndex(), false);
        };
        window.addEventListener('resize', onResize);
        if (desktopMq.addEventListener) {
            desktopMq.addEventListener('change', onResize);
        } else if (desktopMq.addListener) {
            desktopMq.addListener(onResize);
        }
    })();

    (function () {
        const modal = document.getElementById('about-tl-modal');
        if (!modal) return;
        const detailEl = document.getElementById('about-tl-modal-detail');
        const yearEl = document.getElementById('about-tl-modal-year');
        if (!detailEl || !yearEl) return;

        let lastTrigger = null;

        const openModal = function (trigger) {
            const detail = trigger.getAttribute('data-tl-detail') || '';
            const year = trigger.getAttribute('data-tl-year') || '';
            detailEl.textContent = detail;
            yearEl.textContent = year;
            lastTrigger = trigger;
            modal.removeAttribute('hidden');
            modal.setAttribute('aria-hidden', 'false');
            document.body.classList.add('about-tl-modal-open');
            const closeBtn = modal.querySelector('.about-tl-modal__close-corner');
            if (closeBtn) closeBtn.focus();
        };

        const closeModal = function () {
            modal.setAttribute('hidden', '');
            modal.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('about-tl-modal-open');
            if (lastTrigger && typeof lastTrigger.focus === 'function') {
                lastTrigger.focus();
            }
            lastTrigger = null;
        };

        document.querySelectorAll('.about-tl-trigger').forEach(function (btn) {
            btn.addEventListener('click', function () {
                openModal(btn);
            });
        });

        modal.querySelectorAll('[data-about-tl-close]').forEach(function (el) {
            el.addEventListener('click', function (e) {
                e.preventDefault();
                closeModal();
            });
        });

        document.addEventListener('keydown', function (e) {
            if (e.key !== 'Escape') return;
            if (modal.hasAttribute('hidden')) return;
            closeModal();
        });
    })();
</script>

