<?php
declare(strict_types=1);

return [
    'db' => [
        'host' => '127.0.0.1',
        'name' => 'sri_viswa',
        'user' => 'root',
        'pass' => '',
        'charset' => 'utf8mb4',
    ],
    'admin' => [
        'username' => 'admin',
        'password_hash' => 'PASTE_PHP_PASSWORD_HASH_HERE',
    ],
    'mail' => [
        'enabled' => false,
        'smtp_host' => 'smtp.gmail.com',
        'smtp_port' => 587,
        'smtp_secure' => 'tls',
        'smtp_auth' => true,
        'smtp_user' => '',
        'smtp_pass' => '',
        'from_email' => '',
        'from_name' => 'SRI VASAVI Website',
        'alert_recipients' => ['you@example.com'],
        'smtp_options' => [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ],
        ],
    ],
];
