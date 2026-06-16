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
        // generate a password hash with password_hash('your_password', PASSWORD_DEFAULT)
        'password_hash' => '$2y$10$wYUHTlQWyxbf4JkJb44CYOjgJHwF.hp5/qQTwOJTtOOURtolBaBMC',
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
?>
