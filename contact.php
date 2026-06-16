<?php
declare(strict_types=1);

$site = [
    'brand' => 'SRI VASAVI',
    'tagline' => 'Delivering Polymer Solutions since 2007',
];

$nav = [
    ['label' => 'Home', 'href' => './index.php'],
    ['label' => 'About Us', 'href' => './about.php'],
    ['label' => 'Industries', 'href' => './industries.php'],
    ['label' => 'R & D', 'href' => './rd.php'],
    ['label' => 'Products', 'href' => './index.php#products'],
    ['label' => 'Contact Us', 'href' => './contact.php'],
];

$pageTitle = 'Contact Us — ' . $site['brand'];
$metaDescription = 'Contact Sri Vasavi Pigments for enquiries on colour, additive, white and filler masterbatches. Reach us by phone or email, or send your requirement through the form.';
$metaKeywords = 'contact Sri Vasavi Pigments, masterbatch enquiry, additive masterbatch, colour masterbatch, white masterbatch, filler masterbatch';
$robots = 'index,follow';

$countries = [
    'Afghanistan','Albania','Algeria','Andorra','Angola','Antigua and Barbuda','Argentina','Armenia','Australia','Austria','Azerbaijan',
    'Bahamas','Bahrain','Bangladesh','Barbados','Belarus','Belgium','Belize','Benin','Bhutan','Bolivia','Bosnia and Herzegovina','Botswana','Brazil','Brunei','Bulgaria','Burkina Faso','Burundi',
    'Cabo Verde','Cambodia','Cameroon','Canada','Central African Republic','Chad','Chile','China','Colombia','Comoros','Congo','Costa Rica','Côte d’Ivoire','Croatia','Cuba','Cyprus','Czechia',
    'Democratic Republic of the Congo','Denmark','Djibouti','Dominica','Dominican Republic',
    'Ecuador','Egypt','El Salvador','Equatorial Guinea','Eritrea','Estonia','Eswatini','Ethiopia',
    'Fiji','Finland','France',
    'Gabon','Gambia','Georgia','Germany','Ghana','Greece','Grenada','Guatemala','Guinea','Guinea-Bissau','Guyana',
    'Haiti','Honduras','Hungary',
    'Iceland','India','Indonesia','Iran','Iraq','Ireland','Israel','Italy',
    'Jamaica','Japan','Jordan',
    'Kazakhstan','Kenya','Kiribati','Kuwait','Kyrgyzstan',
    'Laos','Latvia','Lebanon','Lesotho','Liberia','Libya','Liechtenstein','Lithuania','Luxembourg',
    'Madagascar','Malawi','Malaysia','Maldives','Mali','Malta','Marshall Islands','Mauritania','Mauritius','Mexico','Micronesia','Moldova','Monaco','Mongolia','Montenegro','Morocco','Mozambique','Myanmar',
    'Namibia','Nauru','Nepal','Netherlands','New Zealand','Nicaragua','Niger','Nigeria','North Korea','North Macedonia','Norway',
    'Oman',
    'Pakistan','Palau','Palestine','Panama','Papua New Guinea','Paraguay','Peru','Philippines','Poland','Portugal',
    'Qatar',
    'Romania','Russia','Rwanda',
    'Saint Kitts and Nevis','Saint Lucia','Saint Vincent and the Grenadines','Samoa','San Marino','São Tomé and Príncipe','Saudi Arabia','Senegal','Serbia','Seychelles','Sierra Leone','Singapore','Slovakia','Slovenia','Solomon Islands','Somalia','South Africa','South Korea','South Sudan','Spain','Sri Lanka','Sudan','Suriname','Sweden','Switzerland','Syria',
    'Taiwan','Tajikistan','Tanzania','Thailand','Timor-Leste','Togo','Tonga','Trinidad and Tobago','Tunisia','Turkey','Turkmenistan','Tuvalu',
    'Uganda','Ukraine','United Arab Emirates','United Kingdom','United States','Uruguay','Uzbekistan',
    'Vanuatu','Vatican City','Venezuela','Vietnam',
    'Yemen',
    'Zambia','Zimbabwe',
];

require __DIR__ . '/includes/header.php';
?>

<main id="main">
    <section class="contact-page" aria-label="Contact us">
        <div class="container-fluid">
            <div class="contact-page-head">
                <h1 class="contact-page-title">GET IN TOUCH</h1>
                <div class="contact-page-sub">contact us today to learn more about our products &amp; services</div>
            </div>

            <div class="contact-page-grid">
                <div class="contact-page-left">
                    <div class="contact-detail">
                        <span class="contact-detail-ico" aria-hidden="true"><i class="fa-solid fa-phone"></i></span>
                        <div class="contact-detail-text">
                            <a class="contact-link" href="tel:+918842321425">+91 884-2321425</a>,
                            <a class="contact-link" href="tel:+918842321462">2321462</a>
                        </div>
                    </div>
                    <div class="contact-detail">
                        <span class="contact-detail-ico" aria-hidden="true"><i class="fa-solid fa-location-dot"></i></span>
                        <div class="contact-detail-text">
                            <a class="contact-link" target="_blank" rel="noopener noreferrer" href="https://www.google.com/maps/search/?api=1&query=1-13-056%2C%20Gopal%20Nagar%2C%20Yanam%20533%20464%2C%20U.T%20of%20Puducherry%2C%20India">
                                1-13-056, Gopal Nagar, Yanam- 533 464, U.T of Puducherry, India.
                            </a>
                        </div>
                    </div>
                    <div class="contact-detail">
                        <span class="contact-detail-ico" aria-hidden="true"><i class="fa-solid fa-envelope"></i></span>
                        <div class="contact-detail-text">
                            <a class="contact-link" href="mailto:sales@vasavipigments.com">sales@vasavipigments.com</a>
                        </div>
                    </div>
                    <div class="contact-detail">
                        <span class="contact-detail-ico" aria-hidden="true"><i class="fa-solid fa-envelope"></i></span>
                        <div class="contact-detail-text">
                            <a class="contact-link" href="mailto:info@vasavipigments.com">info@vasavipigments.com</a>
                        </div>
                    </div>
                </div>

                <div class="contact-page-right">
                    <div id="contact-form-errors" class="contact-error" role="alert" hidden>
                        <ul class="contact-error-list" id="contact-form-errors-list"></ul>
                    </div>

                    <form id="contact-form" class="contact-form" method="post" action="save" autocomplete="on" novalidate>
                        <input type="hidden" name="utm_source" value="" id="utm_source" />
                        <input type="hidden" name="utm_campaign" value="" id="utm_campaign" />
                        <input type="hidden" name="utm_medium" value="" id="utm_medium" />
                        <input type="hidden" name="utm_term" value="" id="utm_term" />

                        <div class="form-row">
                            <label class="form-field">
                                <span class="form-label">Name <span class="req">*</span></span>
                                <input class="form-input" name="name" required />
                            </label>
                            <label class="form-field">
                                <span class="form-label">Designation <span class="req">*</span></span>
                                <input class="form-input" name="designation" required />
                            </label>
                        </div>

                        <div class="form-row">
                            <label class="form-field">
                                <span class="form-label">Company Name <span class="req">*</span></span>
                                <input class="form-input" name="company" required />
                            </label>
                            <label class="form-field">
                                <span class="form-label">Country</span>
                                <select class="form-input" name="country">
                                    <option value="">Select country</option>
                                    <?php foreach ($countries as $c): ?>
                                        <option value="<?= htmlspecialchars($c) ?>" <?= $c === 'India' ? 'selected' : '' ?>><?= htmlspecialchars($c) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </label>
                        </div>

                        <div class="form-row">
                            <label class="form-field">
                                <span class="form-label">Email <span class="req">*</span></span>
                                <input class="form-input" type="email" name="email" required autocomplete="email" />
                            </label>
                            <label class="form-field">
                                <span class="form-label">Phone <span class="req">*</span></span>
                                <input
                                    class="form-input"
                                    type="tel"
                                    name="your_phone"
                                    id="your_phone"
                                    pattern="[0-9]{10}"
                                    title="Enter exactly 10 digits"
                                    minlength="10"
                                    maxlength="10"
                                    inputmode="numeric"
                                    autocomplete="tel"
                                    required
                                    aria-label="Phone number, 10 digits required"
                                />
                            </label>
                        </div>

                        <div class="form-row">
                            <label class="form-field">
                                <span class="form-label">Product <span class="req">*</span></span>
                                <input class="form-input" name="product" required />
                            </label>
                            <label class="form-field">
                                <span class="form-label">Quantity required <span class="req">*</span></span>
                                <input class="form-input" name="quantity" required />
                            </label>
                        </div>

                        <label class="form-field">
                            <span class="form-label">Remarks</span>
                            <textarea class="form-textarea" name="remarks" rows="4"></textarea>
                        </label>

                        <button class="form-submit" type="submit" id="contact-form-submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<div id="contact-thanks-modal" class="contact-thanks-modal" hidden aria-hidden="true">
    <div class="contact-thanks-modal__backdrop" data-contact-thanks-close tabindex="-1"></div>
    <div class="contact-thanks-modal__panel" role="dialog" aria-modal="true" aria-labelledby="contact-thanks-title">
        <button type="button" class="contact-thanks-modal__close" data-contact-thanks-close aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="contact-thanks-modal__icon" aria-hidden="true"><i class="fa-solid fa-circle-check"></i></div>
        <h2 id="contact-thanks-title" class="contact-thanks-modal__title">Thank you for filling the form</h2>
        <p class="contact-thanks-modal__text">We have received your enquiry and will get back to you shortly.</p>
        <button type="button" class="contact-thanks-modal__btn" data-contact-thanks-close>OK</button>
    </div>
</div>

<script>
(function () {
    const modal = document.getElementById('contact-thanks-modal');
    const form = document.getElementById('contact-form');
    const errBox = document.getElementById('contact-form-errors');
    const errList = document.getElementById('contact-form-errors-list');
    const submitBtn = document.getElementById('contact-form-submit');

    function hideErrors() {
        if (!errBox || !errList) return;
        errList.innerHTML = '';
        errBox.hidden = true;
    }

    function showErrors(messages) {
        if (!errBox || !errList) return;
        errList.innerHTML = '';
        messages.forEach(function (msg) {
            const li = document.createElement('li');
            li.textContent = msg;
            errList.appendChild(li);
        });
        errBox.hidden = false;
        errBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    let lastFocus = null;

    const setModalOpen = function (open) {
        if (!modal) return;
        if (open) {
            modal.removeAttribute('hidden');
        } else {
            modal.setAttribute('hidden', 'hidden');
        }
        modal.hidden = !open;
        modal.setAttribute('aria-hidden', open ? 'false' : 'true');
        document.body.classList.toggle('contact-thanks-modal-open', open);
        if (open) {
            lastFocus = document.activeElement;
            const btn = modal.querySelector('.contact-thanks-modal__btn');
            if (btn) btn.focus();
        } else if (lastFocus && typeof lastFocus.focus === 'function') {
            lastFocus.focus();
        }
    };

    window.openContactThanksModal = function () {
        setModalOpen(true);
    };

    if (modal) {
        modal.querySelectorAll('[data-contact-thanks-close]').forEach(function (el) {
            el.addEventListener('click', function () {
                setModalOpen(false);
            });
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && !modal.hasAttribute('hidden')) setModalOpen(false);
        });
    }

    /* UTM from query string (optional) */
    try {
        const p = new URLSearchParams(window.location.search);
        [['utm_source', 'utm_source'], ['utm_campaign', 'utm_campaign'], ['utm_medium', 'utm_medium'], ['utm_term', 'utm_term']].forEach(function (pair) {
            const v = p.get(pair[0]);
            if (v) {
                const el = document.getElementById(pair[1]);
                if (el) el.value = v;
            }
        });
    } catch (e) { /* ignore */ }

    if (!form || !submitBtn) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        hideErrors();

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        submitBtn.disabled = true;
        const fd = new FormData(form);

        fetch('save', {
            method: 'POST',
            body: fd,
            credentials: 'same-origin',
            headers: { 'Accept': 'text/plain' }
        })
            .then(function (res) {
                return res.text().then(function (text) {
                    return { ok: res.ok, text: (text || '').trim() };
                });
            })
            .then(function (r) {
                if (r.text === 'success') {
                    form.reset();
                    if (window.openContactThanksModal) window.openContactThanksModal();
                    return;
                }
                if (r.text === 'validation_error') {
                    showErrors(['Please check the form: fill all required fields correctly.']);
                    return;
                }
                if (r.text === 'db_error') {
                    showErrors(['We could not save your message. Please try again later or email us directly.']);
                    return;
                }
                if (r.text === 'method_not_allowed') {
                    showErrors(['Invalid request. Please reload the page and try again.']);
                    return;
                }
                showErrors(['Something went wrong. Please try again.']);
            })
            .catch(function () {
                showErrors(['Network error. Check your connection and try again.']);
            })
            .finally(function () {
                submitBtn.disabled = false;
            });
    });
})();
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>
