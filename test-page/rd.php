<?php
declare(strict_types=1);

$site = [
    'brand' => 'SRI VASAVI',
    'tagline' => 'Delivering Polymer Solutions since 2007',
];

$pageTitle = 'R & D — ' . $site['brand'];
$metaDescription = 'Discover our R&D and quality lab capabilities — rigorous testing, development and customised masterbatch solutions backed by modern equipment and expert teams.';
$metaKeywords = 'masterbatch R&D, polymer testing lab, quality lab, product development, customised masterbatch solutions';
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
    <section class="rd-page" aria-label="R and D">
        <div class="container-fluid">
            <div class="rd-grid">
                <div class="rd-media" aria-hidden="true">
                    <img class="rd-img" src="./assets/images/rd.png" alt="" />
                </div>

                <div class="rd-copy">
                    <h1 class="section-title">A Commitment to Innovation and Quality</h1>
                    <p class="section-text">
                        Innovation is at the heart of everything we do. We believe it has the power to drive excellence.
                        For almost three decades, we have committed to manufacturing and delivering the best masterbatches
                        and compounds. We understand that one-size-fits-all approach is not sufficient for our customers,
                        and hence we strive to provide tailor-made products specifically suited to their applications.
                    </p>
                    <p class="section-text rd-spacer">
                        In 2021, we took a step forward by establishing a new Product Development and Quality Lab. This
                        facility is equipped with the latest digital equipment, allowing our team of experts to conduct
                        in-depth testing and development. We leverage this technology to formulate and test new
                        masterbatch solutions.
                    </p>
                    <p class="section-text rd-spacer">
                        Our team collaborates closely with clients to gain a deep understanding of their specific needs
                        and challenges. This collaborative approach allows us to develop custom masterbatches that not
                        only meet their specifications but also deliver exceptional performance and cost-effectiveness.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="rd-lab" aria-label="Testing and development">
        <div class="container-fluid">
            <div class="rd-lab-head">
                <h2 class="section-title center">A Centre of Testing and Development</h2>
                <p class="rd-lab-sub">
                Our R&D philosophy is built upon a foundation of unwavering quality. We employ rigorous testing methodologies throughout the development process, ensuring that our masterbatches meet the highest performance standards. Our R&D Laboratory ensures the following:


                </p>
            </div>

            <div class="rd-cards">
                <article class="rd-card">
                    <h3 class="rd-card-title">A Well-Equipped Space</h3>
                    <p class="rd-card-text">
                        Our R&amp;D facility boasts a comprehensive range of equipment, chosen to ensure the creation of
                        quality masterbatches. This equipment empowers our experienced team to:
                    </p>
                    <ul class="rd-list">
                        <li><b>Ensure Uncompromising Quality:</b> Rigorous in-house testing protocols allow us to maintain and exceed quality benchmarks, ensuring every masterbatch meets our customers' requirements.
                        </li>
                        <li><b>Drive Continuous Innovation: </b> We invest in research to develop and refine formulations that enhance product performance, sustainability, and cost-effectiveness. Our team actively explores additives, polymer compatibilities, and process optimizations.</li>
                        <li><b>Validate Specialty Products:</b> Whether through in-house assessments or external laboratory certifications, we ensure our specialty masterbatches comply with required international standards such as RoHS, REACH, FDA, and ISO.</li>
                        <li><b>Enhance End-Product Performance:</b> Our R&D facility is equipped to analyze final products manufactured using our masterbatches. By assessing a range of properties, we ensure our products delivery consistent results.</li>
                    </ul>
                </article>

                <article class="rd-card">
                    <h3 class="rd-card-title">Rigorous Quality Control</h3>
                    <p class="rd-card-text">
                        Our R&amp;D facility ensures that every batch of our masterbatches meets our quality standards.
                        We adhere to quality control procedures as outlined by ISO 9001:2015 certified quality management
                        system. This system encompasses:
                    </p>
                    <ul class="rd-list">
                        <li><b>Meticulous Selection and Approval of Raw Materials and Vendors:</b> Every raw material and vendor undergoes a qualification process, ensuring alignment with our defined quality benchmarks before integration into production.</li>
                        <li><b>Standardized Operating Procedures (SOPs) for Consistency:</b> Our well-defined SOPs uphold uniformity and precision across all production stages, reinforcing quality at every step. </li>
                        <li><b>Real-Time Quality Control Measures:</b> In-process monitoring allows for immediate identification and rectification of deviations, maintaining the integrity of our production standards.

                        </li>
                        <li><b>Batch-Wise Quality Assurance Protocols:</b> Each batch is assessed against established criteria, verifying adherence to predefined product specifications before final approval.
                        </li>
                    </ul>
                </article>
            </div>
        </div>
    </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>

