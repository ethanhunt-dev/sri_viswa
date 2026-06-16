<?php
declare(strict_types=1);

$site = [
    'brand' => 'Masterbatch Solutions for Multiple Industries | Sri Vasavi Pigments
',
    'tagline' => 'Delivering Polymer Solutions since 2007',
];

$pageTitle = 'Industries — ' . $site['brand'];
$metaDescription = 'Explore industry-specific masterbatch solutions by Sri Vasavi Pigments, delivering consistency, quality, and performance across applications.
';
$metaKeywords = 'masterbatch industries, flexible packaging masterbatch, rigid packaging, water management, appliances plastics, automotive plastics, agriculture films, electrical plastics';
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
    <section class="ind-page" aria-label="Industries">
        <div class="container-fluid">
            <div class="ind-head">
                <h1 class="section-title center">We understand the unique needs of various industries. Hence, we don't just supply masterbatches, we partner with your innovation. We offer customised solutions that empower you to create high-quality end products across a wide range of applications.
                </h1>
                
            </div>

            <section class="ind-row" aria-label="Flexible Packaging">
                <div class="ind-copy">
                    <h2 class="ind-title">Flexible Packaging</h2>
                    <p class="ind-text">
                        Flexible packaging requires customized solutions to meet diverse needs for durability, functionality, and visual appeal. Our masterbatches are carefully designed to enhance printability, strengthen tear resistance, and ensure excellent aesthetics. Whether you are working with woven sacks, films, or laminates, our products help you achieve outstanding performance and quality.
                    </p>
                </div>
                <div class="ind-media" aria-hidden="true">
                    <img class="ind-img" src="assets/images/Flexible.png" alt="Flexible packaging applications" loading="lazy" />
                </div>
            </section>

            <section class="ind-row ind-row--reverse" aria-label="Rigid Packaging">
            <div class="ind-media" aria-hidden="true">
                    <img class="ind-img" src="assets/images/Rigid.jpg" alt="Rigid packaging applications" loading="lazy" />
                </div>    
            <div class="ind-copy">
                    <h2 class="ind-title">Rigid Packaging</h2>
                    <p class="ind-text">
                        Rigid packaging requires a balance of strength, reliability, and aesthetic appeal. We offer functional masterbatches that deliver vibrant, consistent colors. From drums and crates to cans and containers, our solutions enable manufacturers to create products that are both durable and visually appealing.
                    </p>
                </div>
            
            </section>

            <section class="ind-row" aria-label="Water Management">
                <div class="ind-copy">
                    <h2 class="ind-title">Water Management</h2>
                    <p class="ind-text">
                        Water management systems demand products that are durable and safe. Our range of masterbatches can provide properties like Microbial resistance, Rodent resistance and UV resistance while retaining food contact safety, ensuring long-lasting performance. They are well-suited for water storage tanks, pipes, and other components, helping them withstand environmental challenges and maintain integrity.
                    </p>
                </div>
                <div class="ind-media" aria-hidden="true">
                    <img class="ind-img" src="assets/images/Water-ins.png" alt="Water management applications" loading="lazy" />
                </div>
            </section>

            <section class="ind-row ind-row--reverse" aria-label="Appliances">
            <div class="ind-media" aria-hidden="true">
                    <img class="ind-img" src="assets/images/Appliances.png" alt="Appliances applications" loading="lazy" />
                </div>    
                <div class="ind-copy">
                    <h2 class="ind-title">Appliances</h2>
                    <p class="ind-text">
                        The appliance industry demands materials that combine style and functionality. Our masterbatches are crafted to deliver smooth surface finishes, vibrant color consistency. Whether it’s air coolers, washing machines, or other household appliances, our range of color and additive masterbatches are designed to elevate aesthetics and provide the required properties.
                    </p>
                </div>
            </section>

            <section class="ind-row" aria-label="Automobiles">
                <div class="ind-copy">
                    <h2 class="ind-title">Automobiles</h2>
                    <p class="ind-text">
                        Automotive components require precise engineering and high resilience. Our masterbatches are formulated to address needs such as flame retardancy and scratch resistance. Suitable for automobile components like bumpers, dashboards and battery casings, our products meet the demanding standards of the automotive industry while ensuring top-tier performance.
                    </p>
                </div>
                <div class="ind-media" aria-hidden="true">
                    <img class="ind-img" src="./assets/images/Automobile.png" alt="Automobile applications" loading="lazy" />
                </div>
            </section>

            <section class="ind-row ind-row--reverse" aria-label="Agriculture">
            <div class="ind-media" aria-hidden="true">
                    <img class="ind-img" src="./assets/images/Agriculture.png" alt="Agriculture applications" loading="lazy" />
                </div>    
                <div class="ind-copy">
                    <h2 class="ind-title">Agriculture</h2>
                    <p class="ind-text">
                        Agricultural plastics operate in harsh environments and need to be reliable over time. Our range of masterbatches can offer critical properties like UV stabilization, weather resistance, and rodent resistance. These solutions support products such as pipes, mulch films, and greenhouse covers, helping them perform effectively under challenging conditions.
                    </p>
                </div>
            </section>

            <section class="ind-row" aria-label="Electricals">
                <div class="ind-copy">
                    <h2 class="ind-title">Electricals</h2>
                    <p class="ind-text">
                        The electrical sector prioritizes safety and high performance. Our masterbatches deliver essential features such as Flame retardancy, Thermal resistance, and customizable aesthetics. Designed for components like switches, wire ducts, and enclosures, our solutions ensure compliance with safety standards while enhancing product reliability and design.
                    </p>
                </div>
                <div class="ind-media" aria-hidden="true">
                    <img class="ind-img" src="./assets/images/Electrical.png" alt="Electrical applications" loading="lazy" />
                </div>
            </section>

            <section class="ind-row ind-row--reverse" aria-label="Furniture">
            <div class="ind-media" aria-hidden="true">
                    <img class="ind-img" src="./assets/images/Furniture-in.png" alt="Furniture applications" loading="lazy" />
                </div>    
                <div class="ind-copy">
                    <h2 class="ind-title">Furniture</h2>
                    <p class="ind-text">
                        Plastic furniture needs to be both durable and visually appealing to meet consumer expectations. Our masterbatches are formulated to provide excellent physical properties, color consistency, and surface finish. Whether for indoor or outdoor use, our solutions help manufacturers produce furniture that is strong, stylish, and durable, ensuring long-lasting performance.
                    </p>
                </div>
            </section>
        </div>
    </section>

    <section class="ind-page" aria-label="More industries">
        <div class="container-fluid">
            <div class="ind-head">
                <h3 class="section-title center">Mastering Formulations Beyond the Ordinary</h3>
                <p class="section-text">
                    Beyond these core industries, we also have experience developing custom masterbatches for various other applications. Our team is dedicated to understanding your specific needs and formulating solutions that exceed your expectations.
                </p>
            </div>
        </div>
    </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>

