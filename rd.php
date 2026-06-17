<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/db.php';

$rdRow = get_row('SELECT * FROM `rd` LIMIT 1');

$site = [
    'brand' => 'SRI VASAVI',
    'tagline' => 'Delivering Polymer Solutions since 2007',
];

$pageTitle = 'R & D - ' . $site['brand'];
$metaDescription = 'Discover our R&D and quality lab capabilities: rigorous testing, development and customised masterbatch solutions backed by modern equipment and expert teams.';
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

$pageSchema = '<!-- Schema markup -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [

    {
      "@type": "WebSite",
      "@id": "https://www.srivasavi.co.in/#website",
      "url": "https://www.srivasavi.co.in/",
      "name": "Sri Vasavi Pigments",
      "alternateName": "Plastimix",
      "publisher": {
        "@id": "https://www.srivasavi.co.in/#organization"
      }
    },

    {
      "@type": "Organization",
      "@id": "https://www.srivasavi.co.in/#organization",
      "name": "Sri Vasavi Pigments",
      "url": "https://www.srivasavi.co.in/",
      "logo": {
        "@type": "ImageObject",
        "url": "https://www.srivasavi.co.in/assets/images/logo.png"
      },
      "email": "info@vasavipigments.com",
      "telephone": "+91-884-2321425",
      "foundingDate": "1997",
      "description": "Sri Vasavi Pigments is a Masterbatch Manufacturer in India with an in-house Product Development and Quality Lab established in 2021, developing custom Colour Masterbatches, White Masterbatches, Additive Masterbatches, Antimicrobial Masterbatches, Anti-Static Masterbatches, Flame Retardant Masterbatches and Anti-Rodent Masterbatches certified to ISO 9001:2015.",
      "brand": {
        "@type": "Brand",
        "name": "Plastimix"
      },
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "1-13-056, Gopal Nagar",
        "addressLocality": "Yanam",
        "postalCode": "533464",
        "addressRegion": "Puducherry",
        "addressCountry": "IN"
      },
      "hasCredential": {
        "@type": "EducationalOccupationalCredential",
        "name": "ISO 9001:2015 Quality Management System Certification"
      }
    },

    {
      "@type": "WebPage",
      "@id": "https://www.srivasavi.co.in/rd.php#webpage",
      "url": "https://www.srivasavi.co.in/rd.php",
      "name": "Masterbatch Research & Development | Custom Polymer Solutions",
      "description": "Our advanced R&D team develops innovative Colour Masterbatches, White Masterbatches and Additive Masterbatches, including Antimicrobial Masterbatches, Anti-Static Masterbatches, Flame Retardant Masterbatches and Anti-Rodent Masterbatches for demanding plastic applications.",
      "inLanguage": "en",
      "isPartOf": {
        "@id": "https://www.srivasavi.co.in/#website"
      },
      "about": {
        "@id": "https://www.srivasavi.co.in/#organization"
      },
      "breadcrumb": {
        "@id": "https://www.srivasavi.co.in/rd.php#breadcrumb"
      },
      "keywords": "masterbatch R&D, Colour Masterbatches, White Masterbatches, Additive Masterbatches, Antimicrobial Masterbatches, Anti-Static Masterbatches, Flame Retardant Masterbatches, Anti-Rodent Masterbatches, custom polymer solutions, ISO 9001:2015, masterbatch quality lab, product development lab India"
    },

    {
      "@type": "BreadcrumbList",
      "@id": "https://www.srivasavi.co.in/rd.php#breadcrumb",
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "name": "Home",
          "item": "https://www.srivasavi.co.in/"
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": "R & D",
          "item": "https://www.srivasavi.co.in/rd.php"
        }
      ]
    },

    {
      "@type": "ResearchOrganization",
      "@id": "https://www.srivasavi.co.in/rd.php#rd-lab",
      "name": "Sri Vasavi Pigments Product Development and Quality Lab",
      "foundingDate": "2021",
      "description": "Established in 2021, the Sri Vasavi Pigments Product Development and Quality Lab is equipped with the latest digital testing equipment to formulate and validate custom Colour Masterbatches, White Masterbatches, Additive Masterbatches, Antimicrobial Masterbatches, Flame Retardant Masterbatches, Anti-Rodent Masterbatches and Anti-Static Masterbatches. The lab ensures compliance with ISO 9001:2015, RoHS, REACH, and FDA standards.",
      "parentOrganization": {
        "@id": "https://www.srivasavi.co.in/#organization"
      },
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "1-13-056, Gopal Nagar",
        "addressLocality": "Yanam",
        "postalCode": "533464",
        "addressRegion": "Puducherry",
        "addressCountry": "IN"
      }
    },

    {
      "@type": "ItemList",
      "@id": "https://www.srivasavi.co.in/rd.php#rd-capabilities",
      "name": "R&D Capabilities at Sri Vasavi Pigments",
      "description": "The Sri Vasavi Pigments R&D lab supports the development and quality assurance of Colour Masterbatches, White Masterbatches, Additive Masterbatches, Antimicrobial Masterbatches, Anti-Static Masterbatches, Flame Retardant Masterbatches and Anti-Rodent Masterbatches through four core capabilities.",
      "numberOfItems": 8,
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "name": "Uncompromising Quality Assurance",
          "description": "Rigorous in-house testing protocols allow Sri Vasavi Pigments to maintain and exceed quality benchmarks, ensuring every Colour Masterbatch, White Masterbatch, Additive Masterbatch and specialty masterbatch meets exact customer requirements."
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": "Continuous Innovation in Masterbatch Formulation",
          "description": "Investment in research to develop and refine formulations that enhance the performance, sustainability, and cost-effectiveness of Colour Masterbatches, White Masterbatches and Additive Masterbatches, including exploration of polymer compatibilities and process optimisations."
        },
        {
          "@type": "ListItem",
          "position": 3,
          "name": "Validation of Specialty Masterbatches",
          "description": "In-house assessments and external laboratory certifications ensure specialty masterbatches including Antimicrobial Masterbatches, Anti-Static Masterbatches, Flame Retardant Masterbatches and Anti-Rodent Masterbatches comply with RoHS, REACH, FDA, and ISO international standards."
        },
        {
          "@type": "ListItem",
          "position": 4,
          "name": "End-Product Performance Analysis",
          "description": "The R&D facility analyses finished plastic products manufactured using our masterbatches to assess a range of physical and functional properties, ensuring consistent and reliable results."
        },
        {
          "@type": "ListItem",
          "position": 5,
          "name": "ISO 9001:2015 Certified Quality Management System",
          "description": "Sri Vasavi Pigments adheres to quality control procedures as outlined by its ISO 9001:2015 certified quality management system, governing all production of Colour Masterbatches, White Masterbatches, Additive Masterbatches and specialty products."
        },
        {
          "@type": "ListItem",
          "position": 6,
          "name": "Meticulous Raw Material and Vendor Qualification",
          "description": "Every raw material and vendor undergoes a thorough qualification process, ensuring alignment with defined quality benchmarks before integration into masterbatch production."
        },
        {
          "@type": "ListItem",
          "position": 7,
          "name": "Standardised Operating Procedures (SOPs)",
          "description": "Well-defined SOPs uphold uniformity and precision across all production stages for Colour Masterbatches, White Masterbatches, Additive Masterbatches and functional specialty masterbatches, reinforcing quality at every step."
        },
        {
          "@type": "ListItem",
          "position": 8,
          "name": "Batch-Wise Quality Assurance",
          "description": "Every batch of Colour Masterbatches, White Masterbatches, Additive Masterbatches and specialty masterbatches is assessed against established criteria, verifying adherence to predefined product specifications before final approval and dispatch."
        }
      ]
    },

    {
      "@type": "FAQPage",
      "@id": "https://www.srivasavi.co.in/rd.php#faq",
      "mainEntity": [
        {
          "@type": "Question",
          "name": "Does Sri Vasavi Pigments have an in-house R&D and quality lab?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Yes. Sri Vasavi Pigments established a dedicated Product Development and Quality Lab in 2021. The facility is equipped with the latest digital testing equipment and is used to formulate and validate custom Colour Masterbatches, White Masterbatches, Additive Masterbatches, Antimicrobial Masterbatches, Flame Retardant Masterbatches, Anti-Rodent Masterbatches and Anti-Static Masterbatches."
          }
        },
        {
          "@type": "Question",
          "name": "Can Sri Vasavi Pigments develop custom masterbatch formulations?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Yes. Sri Vasavi Pigments specialises in developing tailor-made masterbatch solutions. Our R&D team collaborates closely with clients to understand their specific needs and formulates custom Colour Masterbatches, White Masterbatches, Additive Masterbatches and specialty masterbatches including Antimicrobial, Flame Retardant, Anti-Rodent and Anti-Static variants that meet precise specifications."
          }
        },
        {
          "@type": "Question",
          "name": "Is Sri Vasavi Pigments ISO 9001:2015 certified?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Yes. Sri Vasavi Pigments operates under an ISO 9001:2015 certified quality management system. This certification governs production of all masterbatches including Colour Masterbatches, White Masterbatches, Additive Masterbatches, Antimicrobial Masterbatches, Flame Retardant Masterbatches, Anti-Rodent Masterbatches and Anti-Static Masterbatches, ensuring consistent quality and performance."
          }
        },
        {
          "@type": "Question",
          "name": "What quality and compliance standards do Sri Vasavi Pigments masterbatches meet?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Sri Vasavi Pigments validates its specialty masterbatches including Antimicrobial Masterbatches, Flame Retardant Masterbatches, Anti-Static Masterbatches and Anti-Rodent Masterbatches against internationally recognised standards including RoHS, REACH, FDA, and ISO through both in-house assessment and external laboratory certification."
          }
        },
        {
          "@type": "Question",
          "name": "How does Sri Vasavi Pigments ensure batch-to-batch consistency in its masterbatches?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Sri Vasavi Pigments ensures batch-to-batch consistency in Colour Masterbatches, White Masterbatches, Additive Masterbatches and all specialty masterbatches through Standardised Operating Procedures (SOPs), real-time in-process quality monitoring, and batch-wise quality assurance protocols — all governed by its ISO 9001:2015 certified quality management system."
          }
        },
        {
          "@type": "Question",
          "name": "How long has Sri Vasavi Pigments been innovating in masterbatch manufacturing?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Sri Vasavi Pigments has been committed to innovation in masterbatch manufacturing for almost three decades since its establishment in 1997. In 2021, the company formalised this commitment by establishing a dedicated Product Development and Quality Lab to accelerate R&D for Colour Masterbatches, White Masterbatches, Additive Masterbatches and specialty products."
          }
        },
        {
          "@type": "Question",
          "name": "What is the R&D process for developing Additive Masterbatches at Sri Vasavi Pigments?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "The development of Additive Masterbatches including Antimicrobial Masterbatches, Anti-Static Masterbatches, Flame Retardant Masterbatches and Anti-Rodent Masterbatches at Sri Vasavi Pigments follows a structured process: client collaboration to define requirements, raw material and vendor qualification, formulation development and in-house testing, compliance validation against RoHS, REACH, FDA and ISO standards, and final batch-wise quality approval before dispatch."
          }
        },
        {
          "@type": "Question",
          "name": "Does Sri Vasavi Pigments test finished plastic products made using its masterbatches?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Yes. The Sri Vasavi Pigments R&D facility analyses finished plastic products manufactured using its Colour Masterbatches, White Masterbatch, Additive Masterbatches and specialty masterbatches. This end-product performance assessment ensures that results are consistent and meet the functional requirements of each specific application."
          }
        }
      ]
    }

  ]
}
</script>';

require __DIR__ . '/includes/user/header.php';
?>

<main id="main">
    <?php if ($rdRow): ?>
    <section class="rd-page" aria-label="R and D">
        <div class="container-fluid">
            <div class="rd-grid">
                <div class="rd-media" aria-hidden="true">
                    <img class="rd-img" src="<?= htmlspecialchars(base_url(ltrim((string) $rdRow['image'], './'))) ?>" alt="" />
                </div>

                <div class="rd-copy">
                    <h1 class="section-title">A Commitment to Innovation and Quality</h1>
                    <?= $rdRow['content'] ?>
                </div>
            </div>
        </div>
    </section>

    <section class="rd-lab" aria-label="Testing and development">
        <div class="container-fluid">
            <div class="rd-lab-head">
                <h2 class="section-title center">A Centre of Testing and Development</h2>
                <p class="rd-lab-sub">
                    Our R&D philosophy is built upon a foundation of unwavering quality. We employ rigorous testing methodologies throughout the development process, ensuring that our masterbatches meet the highest performance standards.
                </p>
            </div>

            <div class="rd-cards">
                <article class="rd-card">
                    <h3 class="rd-card-title">A Well-Equipped Space</h3>
                    <?= $rdRow['equiped_space'] ?>
                </article>

                <article class="rd-card">
                    <h3 class="rd-card-title">Rigorous Quality Control</h3>
                    <?= $rdRow['Quality_control'] ?>
                </article>
            </div>
        </div>
    </section>
    <?php else: ?>
        <div style="padding: 100px 0; text-align: center;">
            <p>R & D content is currently unavailable.</p>
        </div>
    <?php endif; ?>
</main>

<?php require __DIR__ . '/includes/user/footer.php'; ?>
