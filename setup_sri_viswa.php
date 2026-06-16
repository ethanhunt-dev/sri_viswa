<?php
require 'd:/xampp/htdocs/sri_viswa/includes/db.php';
$pdo = db();

try {
    // 1. Create main_menu table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `main_menu` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `title` VARCHAR(100) NOT NULL,
        `file_path` VARCHAR(255) DEFAULT NULL,
        `icon` VARCHAR(50) DEFAULT 'fa-circle-question',
        `sort_order` INT DEFAULT 0,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Seed default main_menu entries if empty
    $mainCount = $pdo->query("SELECT COUNT(*) FROM `main_menu`")->fetchColumn();
    if ($mainCount == 0) {
        $pdo->exec("INSERT INTO `main_menu` (`title`, `file_path`, `icon`, `sort_order`) VALUES
            ('Dashboard', 'index.php', 'fa-gauge-high', 1),
            ('All leads', 'submissions.php', 'fa-inbox', 2),
            ('Guide', 'guide.php', 'fa-circle-question', 3),
            ('About Us', 'about_us.php', 'fa-address-card', 4),
            ('Main Menu', 'main_menu.php', 'fa-list', 5),
            ('Sub Menu', 'sub_menu.php', 'fa-indent', 6),
            ('Change Password', 'change_password.php', 'fa-key', 7)");
        echo "main_menu seeded.\n";
    } else {
        $cpExists = $pdo->query("SELECT COUNT(*) FROM `main_menu` WHERE `file_path` = 'change_password.php'")->fetchColumn();
        if (!$cpExists) {
            $pdo->exec("INSERT INTO `main_menu` (`title`, `file_path`, `icon`, `sort_order`) VALUES ('Change Password', 'change_password.php', 'fa-key', 7)");
            echo "Change Password menu item seeded.\n";
        }
    }

    // 2. Create sub_menu table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `sub_menu` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `main_menu_id` INT NOT NULL,
        `title` VARCHAR(100) NOT NULL,
        `file_path` VARCHAR(255) DEFAULT NULL,
        `icon` VARCHAR(50) DEFAULT 'fa-circle-question',
        `sort_order` INT DEFAULT 0,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (`main_menu_id`) REFERENCES `main_menu`(`id`) ON DELETE CASCADE
    )");

    // 3. Create about_us table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `about_us` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `main_heading` VARCHAR(255) NOT NULL,
        `main_image` VARCHAR(255) DEFAULT NULL,
        `description` TEXT DEFAULT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    $aboutCount = $pdo->query("SELECT COUNT(*) FROM `about_us`")->fetchColumn();
    if ($aboutCount == 0) {
        $stmt = $pdo->prepare("INSERT INTO `about_us` (`main_heading`, `main_image`, `description`) VALUES (?, ?, ?)");
        $stmt->execute([
            'A Tradition of Quality Masterbatches Since 1997',
            'assets/images/about-hero.png',
            '<p>Sri Vasavi Pigments, established in 1997, has been at the forefront of masterbatch innovation. Our journey began with establishing a manufacturing unit in Yanam, UT of Puducherry. Today, our brand, Plastimix®, operated with an ISO 9001:2015 certification, utilizes stringent quality control processes to provide customised solutions for your specific application needs.</p><p>With 3 decades in the industry, we have a capacity of 12,000 TPA to meet the quantity requirements of our diverse clientele. We operate with a dedication to excellence in everything we do. Our commitment to exceeding customer expectations has made us a trusted partner for manufacturers across a wide range of industries.</p>'
        ]);
        echo "about_us seeded.\n";
    }

    // 4. Create year table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `year` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `year` VARCHAR(50) NOT NULL,
        `text` TEXT DEFAULT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    $yearCount = $pdo->query("SELECT COUNT(*) FROM `year`")->fetchColumn();
    if ($yearCount == 0) {
        $milestones = [
            ['1997', 'With an aim to manufacture superior quality masterbatches, SVPL was established.'],
            ['1998', 'Began supplying chair compounds to major manufacturers.'],
            ['2004', 'Focused on colour masterbatches for the packaging industry.'],
            ['2005', 'Doubled production capacity with the purchase of additional twin screw extruders.'],
            ['2014', 'Entered the export market, serving customers across various countries.'],
            ['2017', 'Broadened our product range with a new line of additive masterbatches.'],
            ['2019', 'Increased production capacity with the purchase of additional twin screw extruders.'],
            ['2021', 'Established a new R&D laboratory with digital equipment, to drive innovation.'],
            ['2022', 'Completed 25 years of delivering the best, always!']
        ];
        $stmt = $pdo->prepare("INSERT INTO `year` (`year`, `text`) VALUES (?, ?)");
        foreach ($milestones as $m) {
            $stmt->execute($m);
        }
        echo "year seeded.\n";
    }

    // 5. Create industries table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `industries` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `title` VARCHAR(255) NOT NULL,
        `image` VARCHAR(255) DEFAULT NULL,
        `description` TEXT DEFAULT NULL,
        `parent_id` INT DEFAULT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    $indCount = $pdo->query("SELECT COUNT(*) FROM `industries`")->fetchColumn();
    if ($indCount == 0) {
        $mainMenuId = $pdo->query("SELECT id FROM main_menu WHERE title = 'Guide'")->fetchColumn() ?: null;
        
        $inds = [
            ['Flexible Packaging', 'assets/images/Flexible.png', 'Flexible packaging requires customized solutions to meet diverse needs for durability, functionality, and visual appeal. Our masterbatches are carefully designed to enhance printability, strengthen tear resistance, and ensure excellent aesthetics. Whether you are working with woven sacks, films, or laminates, our products help you achieve outstanding performance and quality.'],
            ['Rigid Packaging', 'assets/images/Rigid.jpg', 'Rigid packaging requires a balance of strength, reliability, and aesthetic appeal. We offer functional masterbatches that deliver vibrant, consistent colors. From drums and crates to cans and containers, our solutions enable manufacturers to create products that are both durable and visually appealing.'],
            ['Water Management', 'assets/images/Water-ins.png', 'Water management systems demand products that are durable and safe. Our range of masterbatches can provide properties like Microbial resistance, Rodent resistance and UV resistance while retaining food contact safety, ensuring long-lasting performance. They are well-suited for water storage tanks, pipes, and other components, helping them withstand environmental challenges and maintain integrity.'],
            ['Appliances', 'assets/images/Appliances.png', 'The appliance industry demands materials that combine style and functionality. Our masterbatches are crafted to deliver smooth surface finishes, vibrant color consistency. Whether it’s air coolers, washing machines, or other household appliances, our range of color and additive masterbatches are designed to elevate aesthetics and provide the required properties.'],
            ['Automobiles', 'assets/images/Automobile.png', 'Automotive components require precise engineering and high resilience. Our masterbatches are formulated to address needs such as flame retardancy and scratch resistance. Suitable for automobile components like bumpers, dashboards and battery casings, our products meet the demanding standards of the automotive industry while ensuring top-tier performance.'],
            ['Agriculture', 'assets/images/Agriculture.png', 'Agricultural plastics operate in harsh environments and need to be reliable over time. Our range of masterbatches can offer critical properties like UV stabilization, weather resistance, and rodent resistance. These solutions support products such as pipes, mulch films, and greenhouse covers, helping them perform effectively under challenging conditions.'],
            ['Electricals', 'assets/images/Electrical.png', 'The electrical sector prioritizes safety and high performance. Our masterbatches deliver essential features such as Flame retardancy, Thermal resistance, and customizable aesthetics. Designed for components like switches, wire ducts, and enclosures, our solutions ensure compliance with safety standards while enhancing product reliability and design.'],
            ['Furniture', 'assets/images/Furniture-in.png', 'Plastic furniture needs to be both durable and visually appealing to meet consumer expectations. Our masterbatches are formulated to provide excellent physical properties, color consistency, and surface finish. Whether for indoor or outdoor use, our solutions help manufacturers produce furniture that is strong, stylish, and durable, ensuring long-lasting performance.']
        ];
        $stmt = $pdo->prepare("INSERT INTO `industries` (`title`, `image`, `description`, `parent_id`) VALUES (?, ?, ?, ?)");
        foreach ($inds as $ind) {
            $stmt->execute([$ind[0], $ind[1], $ind[2], $mainMenuId]);
        }
        echo "industries seeded.\n";
    }

    // 6. Create contact_submissions table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `contact_submissions` (
      `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `name` VARCHAR(255) NOT NULL,
      `designation` VARCHAR(255) NOT NULL,
      `company` VARCHAR(255) NOT NULL,
      `country` VARCHAR(100) DEFAULT NULL,
      `email` VARCHAR(255) NOT NULL,
      `mobile` VARCHAR(64) DEFAULT NULL,
      `product` VARCHAR(255) NOT NULL,
      `quantity` VARCHAR(128) NOT NULL,
      `remarks` TEXT,
      `ip_address` VARCHAR(45) DEFAULT NULL,
      `user_agent` VARCHAR(512) DEFAULT NULL,
      `geo_city` VARCHAR(128) DEFAULT NULL,
      `geo_state` VARCHAR(128) DEFAULT NULL,
      `geo_country` VARCHAR(128) DEFAULT NULL,
      `utm_source` VARCHAR(128) DEFAULT NULL,
      `utm_campaign` VARCHAR(128) DEFAULT NULL,
      `utm_medium` VARCHAR(128) DEFAULT NULL,
      `utm_term` VARCHAR(256) DEFAULT NULL,
      `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      KEY `idx_created_at` (`created_at`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "contact_submissions created.\n";

    // 7. Create menu_privileges table
    $pdo->exec("DROP TABLE IF EXISTS `menu_privileges`");
    $pdo->exec("CREATE TABLE `menu_privileges` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `menu_type` VARCHAR(10) NOT NULL,
        `menu_item_id` INT NOT NULL,
        `can_view` TINYINT(1) DEFAULT 1,
        `can_add` TINYINT(1) DEFAULT 1,
        `can_update` TINYINT(1) DEFAULT 1,
        `can_delete` TINYINT(1) DEFAULT 1,
        UNIQUE KEY `uk_menu_item` (`menu_type`, `menu_item_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "menu_privileges created.\n";

    // 8. Create admins table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `admins` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `username` VARCHAR(50) NOT NULL UNIQUE,
        `password_hash` VARCHAR(255) NOT NULL,
        `allowed_ip` VARCHAR(45) DEFAULT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "admins table created/verified.\n";

    $adminsCount = $pdo->query("SELECT COUNT(*) FROM `admins`")->fetchColumn();
    if ($adminsCount == 0) {
        $configPath = __DIR__ . '/includes/config.php';
        $config = is_readable($configPath) ? require $configPath : [];
        $adminCfg = $config['admin'] ?? [
            'username' => 'admin',
            'password_hash' => '$2y$10$wYUHTlQWyxbf4JkJb44CYOjgJHwF.hp5/qQTwOJTtOOURtolBaBMC'
        ];
        $stmt = $pdo->prepare("INSERT INTO `admins` (`username`, `password_hash`) VALUES (?, ?)");
        $stmt->execute([$adminCfg['username'], $adminCfg['password_hash']]);
        echo "admins table seeded.\n";
    }

    echo "All tables initialized in sri_viswa successfully!\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
