<?php
declare(strict_types=1);

/**
 * Copy from config.example.php if missing. Adjust DB credentials for your server.
 * Default admin password after import: changeme — change via:
 *   php -r "echo password_hash('YourNewPassword', PASSWORD_DEFAULT);"
 * and replace admin.password_hash below.
 */
return [
    'db' => [
        'host' => '127.0.0.1:3306',
        'name' => 'bitnami_wordpress',
        'user' => 'bn_wordpress',
        'pass' => 'EDOTX3Ze7C6t6qjaGloXi6evMh6j7IyKkajaMtzKQIv35Zaw2I5E7mOmYqFE7cNZ',
        'charset' => 'utf8mb4',
    ],
    'admin' => [
        'username' => 'admin',
        'password_hash' => '$2y$10$j10r57y0NxDX9OF5WCa5guHiRjJG8kfHObbneps0DK9TCAzLdrjFW',
    ],
    /*
     * Contact form email alerts (PHPMailer + SMTP).
     * 1) Set enabled => true
     * 2) Fill smtp_user, smtp_pass (Gmail: App Password). from_email may be left empty to match smtp_user.
     * 3) alert_recipients: array of emails OR one string "a@x.com, b@y.com" (like your landing page)
     * If mail is enabled but SMTP is incomplete, nothing is sent (check PHP error_log).
     */
    'mail' => [
        'enabled' => true,
        'smtp_host' => 'smtp.gmail.com',
        'smtp_port' => 587,
        'smtp_secure' => 'tls',
        'smtp_auth' => true,
        'smtp_user' => 'vinod@redmattertech.com',
        'smtp_pass' => 'exvv syri fjln takm',
        'from_email' => 'vinod@redmattertech.com',
        'from_name' => 'Redmatter',
        'alert_recipients' => [
            'sales@vasavipigments.com',
            'info@vasavipigments.com',
        ],
        /*
         * Helps XAMPP/Windows when TLS fails with certificate errors. Set to [] on production if not needed.
         */
        'smtp_options' => [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ],
        ],
    ],
];
