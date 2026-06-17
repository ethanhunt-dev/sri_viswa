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

$pageTitle = 'Page Not Found — ' . $site['brand'];
$metaDescription = 'The page you are looking for does not exist. Go back to Sri Vasavi Pigments home page.';
$robots = 'noindex,follow';

require __DIR__ . '/includes/header.php';
?>

<main id="main" class="error-page-main">
    <style>
        .error-page-section {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 80px 20px;
            background: linear-gradient(135deg, #f5f8fc 0%, #eef3fa 100%);
            min-height: calc(100vh - 350px);
            text-align: center;
        }
        .error-page-container {
            max-width: 600px;
            background: #ffffff;
            padding: 50px 40px;
            border-radius: 24px;
            box-shadow: 0 15px 35px rgba(0, 58, 133, 0.05);
            border: 1px solid rgba(12, 27, 42, 0.05);
            margin: auto;
        }
        .error-code {
            font-family: var(--fontHeading);
            font-size: 110px;
            font-weight: 900;
            line-height: 1;
            color: var(--brand);
            background: linear-gradient(135deg, var(--brand) 0%, var(--brandAccent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 20px;
            letter-spacing: -2px;
            animation: pulse-slow 3s infinite ease-in-out;
        }
        .error-title {
            font-family: var(--fontHeading);
            font-size: 28px;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 16px;
        }
        .error-desc {
            font-family: var(--fontBody);
            font-size: 16px;
            color: var(--muted);
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .error-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 14px;
            padding: 14px 28px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .error-btn i {
            font-size: 16px;
            transition: transform 0.2s ease;
        }
        .error-btn:hover i {
            transform: translateX(-4px);
        }
        @keyframes pulse-slow {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.03);
            }
        }
        @media (max-width: 576px) {
            .error-page-section {
                padding: 60px 15px;
            }
            .error-page-container {
                padding: 40px 20px;
            }
            .error-code {
                font-size: 85px;
            }
            .error-title {
                font-size: 22px;
            }
        }
    </style>

    <section class="error-page-section" aria-labelledby="error-heading">
        <div class="error-page-container">
            <div class="error-code" aria-hidden="true">404</div>
            <h1 id="error-heading" class="error-title">Oops! Page Not Found</h1>
            <p class="error-desc">
                The page you are looking for might have been removed, had its name changed, or is temporarily unavailable. Let's get you back on track!
            </p>
            <a class="btn btn-primary error-btn" href="<?= htmlspecialchars(base_url('index.php')) ?>">
                <i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Go to Homepage
            </a>
        </div>
    </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
