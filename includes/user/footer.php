<?php
declare(strict_types=1);

/** @var array{brand:string,tagline:string} $site */
/** @var array<int,array{label:string,href:string}> $nav */

$siteSettings = get_row("SELECT * FROM `site_settings` LIMIT 1");
?>
    <footer class="site-footer" aria-label="Footer">
        <div class="container-fluid footer-wrap">
            <div class="footer-cols">
                <div class="footer-col">
                    <div class="footer-title">Address</div>

                    <?php if (!empty($siteSettings['address'])): ?>
                        <div class="footer-item">
                            <span class="footer-ico" aria-hidden="true"><i class="fa-solid fa-location-dot"></i></span>
                            <a class="footer-inline-link" target="_blank" rel="noopener noreferrer" href="https://www.google.com/maps/search/?api=1&query=<?= urlencode($siteSettings['address']) ?>">
                                <?= htmlspecialchars($siteSettings['address']) ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($siteSettings['phone'])): ?>
                        <div class="footer-item">
                            <span class="footer-ico" aria-hidden="true"><i class="fa-solid fa-phone"></i></span>
                            <span>
                                Phone:
                                <?php 
                                $phoneList = array_map('trim', explode(',', $siteSettings['phone']));
                                $phoneLinks = [];
                                foreach ($phoneList as $pNum) {
                                    $cleanNum = preg_replace('/[^0-9+]/', '', $pNum);
                                    $phoneLinks[] = '<a class="footer-inline-link" href="tel:' . htmlspecialchars($cleanNum) . '">' . htmlspecialchars($pNum) . '</a>';
                                }
                                echo implode(', ', $phoneLinks);
                                ?>
                            </span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($siteSettings['email'])): ?>
                        <div class="footer-item">
                            <span class="footer-ico" aria-hidden="true"><i class="fa-solid fa-envelope"></i></span>
                            <span>
                                Email:
                                <?php 
                                $emailList = array_map('trim', explode(',', $siteSettings['email']));
                                $emailLinks = [];
                                foreach ($emailList as $em) {
                                    $emailLinks[] = '<a class="footer-inline-link" href="mailto:' . htmlspecialchars($em) . '">' . htmlspecialchars($em) . '</a>';
                                }
                                echo implode(', ', $emailLinks);
                                ?>
                            </span>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="footer-col footer-col-links">
                    <div class="footer-title">Quick Links</div>
                    <nav class="footer-links" aria-label="Footer links">
                        <?php foreach ($nav as $item): ?>
                            <a class="footer-link" href="<?= htmlspecialchars(base_url(ltrim($item['href'], './'))) ?>"><?= htmlspecialchars($item['label']) ?></a>
                        <?php endforeach; ?>
                        <button type="button" class="footer-link footer-disclaimer-trigger">Disclaimer</button>
                    </nav>
                </div>
            </div>

            <div class="footer-bottom">
                <div>© <?= date('Y') ?> Vasavi Pigment || All Rights Reserved.</div>
            </div>
        </div>
    </footer>

    <div id="disclaimer-modal" class="disclaimer-modal" hidden aria-hidden="true">
        <div class="disclaimer-modal__backdrop" data-disclaimer-close tabindex="-1"></div>
        <div class="disclaimer-modal__panel" role="dialog" aria-modal="true" aria-labelledby="disclaimer-modal-title">
            <button type="button" class="disclaimer-modal__close" data-disclaimer-close aria-label="Close disclaimer">
                <span aria-hidden="true">&times;</span>
            </button>
            <h2 id="disclaimer-modal-title" class="disclaimer-modal__title">Disclaimer</h2>
            <div class="disclaimer-modal__body">
                <p>
                    All information provided on this website is offered as a suggestion for investigation/use. The data included in here does not warrant any applicability of our products for any applications. SVPL assumes no liability for the use or interpretation of information contained on this web site.
                </p>
                <p>
                    Before using any of the information/data provided on this site, it is the responsibility of the user to check the authenticity, practicality, usability, risks associated, any legal/regulatory considerations, etc.
                </p>
                <p>
                    The disclosure of information herein is not a license to operate under, or a recommendation to infringe any patents.
                </p>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const btn = document.querySelector('.nav-toggle');
            const nav = document.getElementById('site-nav');
            const backdrop = document.getElementById('nav-backdrop');
            const wrap = document.querySelector('[data-nav-dropdown]');
            const productsToggle = document.getElementById('nav-products-toggle');
            const mqMobile = window.matchMedia('(max-width: 860px)');

            if (!btn || !nav) return;

            function setProductsOpen(open) {
                if (!wrap || !productsToggle) return;
                wrap.classList.toggle('is-open', open);
                productsToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            }

            function setMobileMenuOpen(open) {
                btn.setAttribute('aria-expanded', open ? 'true' : 'false');
                nav.classList.toggle('is-open', open);
                document.body.classList.toggle('nav-menu-open', open);
                if (backdrop) {
                    backdrop.classList.toggle('is-active', open);
                    backdrop.hidden = !open;
                    backdrop.setAttribute('aria-hidden', open ? 'false' : 'true');
                }
                if (!open) {
                    setProductsOpen(false);
                }
            }

            btn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                const isOpen = btn.getAttribute('aria-expanded') === 'true';
                setMobileMenuOpen(!isOpen);
            });

            if (backdrop) {
                backdrop.addEventListener('click', function () {
                    setMobileMenuOpen(false);
                });
            }

            nav.addEventListener('click', function (e) {
                const link = e.target.closest('a.nav-link');
                if (!link || link.classList.contains('nav-link--products')) return;
                if (mqMobile.matches) setMobileMenuOpen(false);
            });

            if (wrap && productsToggle) {
                productsToggle.addEventListener('click', function (e) {
                    if (!mqMobile.matches) return;
                    e.preventDefault();
                    e.stopPropagation();
                    setProductsOpen(!wrap.classList.contains('is-open'));
                });

                wrap.querySelectorAll('.nav-dropdown-link').forEach(function (a) {
                    a.addEventListener('click', function () {
                        if (!mqMobile.matches) return;
                        setProductsOpen(false);
                        setMobileMenuOpen(false);
                    });
                });
            }

            window.addEventListener('resize', function () {
                if (!mqMobile.matches) {
                    setProductsOpen(false);
                    setMobileMenuOpen(false);
                }
            });

            document.addEventListener('keydown', function (e) {
                if (e.key !== 'Escape') return;
                setProductsOpen(false);
                if (btn.getAttribute('aria-expanded') === 'true') {
                    setMobileMenuOpen(false);
                }
            });
        })();
        (function () {
            const modal = document.getElementById('disclaimer-modal');
            const triggers = document.querySelectorAll('.footer-disclaimer-trigger');
            if (!modal || !triggers.length) return;
            const closers = modal.querySelectorAll('[data-disclaimer-close]');
            let lastFocus = null;

            const setOpen = (open) => {
                modal.hidden = !open;
                modal.setAttribute('aria-hidden', open ? 'false' : 'true');
                document.body.classList.toggle('disclaimer-modal-open', open);
                if (open) {
                    lastFocus = document.activeElement;
                    const closeBtn = modal.querySelector('.disclaimer-modal__close');
                    if (closeBtn) closeBtn.focus();
                } else if (lastFocus && typeof lastFocus.focus === 'function') {
                    lastFocus.focus();
                }
            };

            triggers.forEach(function (t) {
                t.addEventListener('click', function () {
                    setOpen(true);
                });
            });

            closers.forEach(function (el) {
                el.addEventListener('click', function () {
                    setOpen(false);
                });
            });

            modal.addEventListener('click', function (e) {
                if (e.target === modal) setOpen(false);
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && !modal.hidden) setOpen(false);
            });
        })();
    </script>
</body>
</html>

