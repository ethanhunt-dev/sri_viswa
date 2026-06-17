<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/db.php';

$industries = get_result('SELECT * FROM `industries` ORDER BY id ASC');

$site = [
    'brand' => 'Masterbatch Solutions for Multiple Industries | Sri Vasavi Pigments',
    'tagline' => 'Delivering Polymer Solutions since 2007',
];

$pageTitle = 'Industries - ' . $site['brand'];
$metaDescription = 'Explore industry-specific masterbatch solutions by Sri Vasavi Pigments, delivering consistency, quality, and performance across applications.';
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
      "description": "Sri Vasavi Pigments is a leading Masterbatch Manufacturer in India offering Colour Masterbatches, White Masterbatches, Additive Masterbatches, Antimicrobial Masterbatches, Anti-Static Masterbatches, Flame Retardant Masterbatches and Anti-Rodent Masterbatches since 1997.",
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
      "description": "Sri Vasavi Pigments manufactures Colour Masterbatches, White Masterbatches, Additive Masterbatches, Antimicrobial Masterbatches, Anti-Static Masterbatches, Flame Retardant Masterbatches and Anti-Rodent Masterbatches for packaging, automotive, agriculture, electrical, appliance and furniture industries across India.",
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
      "contactPoint": [
        {
          "@type": "ContactPoint",
          "telephone": "+91-884-2321425",
          "contactType": "sales",
          "areaServed": "IN",
          "availableLanguage": ["English", "Telugu"]
        },
        {
          "@type": "ContactPoint",
          "email": "sales@vasavipigments.com",
          "contactType": "sales",
          "areaServed": "IN"
        }
      ]
    },

    {
      "@type": "WebPage",
      "@id": "https://www.srivasavi.co.in/industries.php#webpage",
      "url": "https://www.srivasavi.co.in/industries.php",
      "name": "Masterbatch Solutions for Packaging, Automotive & Industrial Applications",
      "description": "Discover how Colour Masterbatches, White Masterbatches, Additive Masterbatches, Antimicrobial Masterbatches, Flame Retardant Masterbatches and Anti-Rodent Masterbatches enhance performance across packaging, automotive, agriculture, water management and industrial sectors.",
      "inLanguage": "en",
      "isPartOf": {
        "@id": "https://www.srivasavi.co.in/#website"
      },
      "about": {
        "@id": "https://www.srivasavi.co.in/#organization"
      },
      "breadcrumb": {
        "@id": "https://www.srivasavi.co.in/industries.php#breadcrumb"
      },
      "keywords": "Colour Masterbatches, White Masterbatches, Additive Masterbatches, Antimicrobial Masterbatches, Anti-Static Masterbatches, Flame Retardant Masterbatches, Anti-Rodent Masterbatches, masterbatch manufacturer India, flexible packaging masterbatch, automotive masterbatch, agriculture masterbatch"
    },

    {
      "@type": "BreadcrumbList",
      "@id": "https://www.srivasavi.co.in/industries.php#breadcrumb",
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
          "name": "Industries",
          "item": "https://www.srivasavi.co.in/industries.php"
        }
      ]
    },

    {
      "@type": "ItemList",
      "@id": "https://www.srivasavi.co.in/industries.php#industry-list",
      "name": "Industries Served by Sri Vasavi Pigments",
      "description": "Sri Vasavi Pigments provides Colour Masterbatches, White Masterbatches, Additive Masterbatches, Antimicrobial Masterbatches, Flame Retardant Masterbatches, Anti-Rodent Masterbatches and Anti-Static Masterbatches across eight core industries.",
      "numberOfItems": 8,
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "name": "Flexible Packaging",
          "description": "Colour Masterbatches and Additive Masterbatches for flexible packaging applications enhance printability, tear resistance, and aesthetics in woven sacks, films, and laminates.",
          "url": "https://www.srivasavi.co.in/industries.php#flexible-packaging"
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": "Rigid Packaging",
          "description": "Colour Masterbatches and White Masterbatches for rigid packaging deliver vibrant, consistent colour and durability in drums, crates, cans, and containers.",
          "url": "https://www.srivasavi.co.in/industries.php#rigid-packaging"
        },
        {
          "@type": "ListItem",
          "position": 3,
          "name": "Water Management",
          "description": "Antimicrobial Masterbatches, Anti-Rodent Masterbatches and UV-stabilising Additive Masterbatches ensure long-lasting, food-contact-safe performance in water storage tanks and pipes.",
          "url": "https://www.srivasavi.co.in/industries.php#water-management"
        },
        {
          "@type": "ListItem",
          "position": 4,
          "name": "Appliances",
          "description": "Colour Masterbatches and Additive Masterbatches for the appliance industry deliver smooth surface finishes and vibrant colour consistency in air coolers, washing machines, and household appliances.",
          "url": "https://www.srivasavi.co.in/industries.php#appliances"
        },
        {
          "@type": "ListItem",
          "position": 5,
          "name": "Automobiles",
          "description": "Flame Retardant Masterbatches and Additive Masterbatches for scratch resistance are used in automotive components including bumpers, dashboards, and battery casings.",
          "url": "https://www.srivasavi.co.in/industries.php#automobiles"
        },
        {
          "@type": "ListItem",
          "position": 6,
          "name": "Agriculture",
          "description": "Additive Masterbatches with UV stabilisation and weather resistance, along with Anti-Rodent Masterbatches, protect agricultural pipes, mulch films, and greenhouse covers in harsh environments.",
          "url": "https://www.srivasavi.co.in/industries.php#agriculture"
        },
        {
          "@type": "ListItem",
          "position": 7,
          "name": "Electricals",
          "description": "Flame Retardant Masterbatches and Additive Masterbatches with thermal resistance and Anti-Static Masterbatches are used in switches, wire ducts, and electrical enclosures to meet safety standards.",
          "url": "https://www.srivasavi.co.in/industries.php#electricals"
        },
        {
          "@type": "ListItem",
          "position": 8,
          "name": "Furniture",
          "description": "Colour Masterbatches and Additive Masterbatches for plastic furniture provide excellent colour consistency, superior surface finish, and physical durability for both indoor and outdoor use.",
          "url": "https://www.srivasavi.co.in/industries.php#furniture"
        }
      ]
    },

    {
      "@type": "FAQPage",
      "@id": "https://www.srivasavi.co.in/industries.php#faq",
      "mainEntity": [
        {
          "@type": "Question",
          "name": "Which industries does Sri Vasavi Pigments serve with masterbatch solutions?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Sri Vasavi Pigments supplies Colour Masterbatches, White Masterbatches, Additive Masterbatches, Antimicrobial Masterbatches, Flame Retardant Masterbatches, Anti-Rodent Masterbatches and Anti-Static Masterbatches to eight core industries: Flexible Packaging, Rigid Packaging, Water Management, Appliances, Automobiles, Agriculture, Electricals, and Furniture."
          }
        },
        {
          "@type": "Question",
          "name": "What masterbatches are used in flexible packaging?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Flexible packaging applications use Colour Masterbatches and Additive Masterbatches that enhance printability, strengthen tear resistance, and ensure excellent aesthetics. They are suitable for woven sacks, blown films, and laminates."
          }
        },
        {
          "@type": "Question",
          "name": "Which masterbatches are recommended for rigid packaging?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Rigid packaging products such as drums, crates, cans, and containers benefit from Colour Masterbatches and White Masterbatches that deliver vibrant, consistent colour along with high strength and long-term durability."
          }
        },
        {
          "@type": "Question",
          "name": "Which masterbatches are used in water management systems?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Water management systems such as tanks and pipes require Antimicrobial Masterbatches to prevent microbial growth, Anti-Rodent Masterbatches to prevent gnawing damage, and Additive Masterbatches with UV resistance — all while maintaining food contact safety."
          }
        },
        {
          "@type": "Question",
          "name": "What masterbatches are suitable for the appliance industry?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "The appliance industry uses Colour Masterbatches for vibrant, consistent aesthetics and Additive Masterbatches for smooth surface finish and functional properties in products like air coolers and washing machines."
          }
        },
        {
          "@type": "Question",
          "name": "Which masterbatches are used in automotive components?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Automotive components like bumpers, dashboards, and battery casings use Flame Retardant Masterbatches for fire safety compliance and Additive Masterbatches for scratch resistance, meeting the precise engineering demands of the automotive industry."
          }
        },
        {
          "@type": "Question",
          "name": "What masterbatches are used in agriculture?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Agricultural plastics such as pipes, mulch films, and greenhouse covers use Additive Masterbatches with UV stabilisation and weather resistance, and Anti-Rodent Masterbatches to protect against gnawing, ensuring reliable performance in harsh outdoor conditions."
          }
        },
        {
          "@type": "Question",
          "name": "Which masterbatches are used in the electrical industry?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Electrical components such as switches, wire ducts, and enclosures use Flame Retardant Masterbatches for fire safety compliance, Additive Masterbatches with thermal resistance, and Anti-Static Masterbatches to prevent electrostatic discharge."
          }
        },
        {
          "@type": "Question",
          "name": "What masterbatches are used for plastic furniture?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Plastic furniture manufacturers use Colour Masterbatches for consistent, attractive colour and Additive Masterbatches to achieve superior surface finish and physical durability for both indoor and outdoor furniture."
          }
        },
        {
          "@type": "Question",
          "name": "What are Antimicrobial Masterbatches and where are they used?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Antimicrobial Masterbatches incorporate antimicrobial agents into the plastic matrix to inhibit the growth of bacteria and fungi on product surfaces. They are widely used in water storage tanks, pipes, food packaging, and healthcare plastic applications."
          }
        },
        {
          "@type": "Question",
          "name": "What are Flame Retardant Masterbatches used for?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Flame Retardant Masterbatches are used in automotive components, electrical enclosures, switches, and wire ducts where fire safety compliance is required. They slow the ignition and spread of fire in plastic parts, meeting industry safety standards."
          }
        },
        {
          "@type": "Question",
          "name": "What are Anti-Rodent Masterbatches and which industries use them?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Anti-Rodent Masterbatches use natural deterrent agents to make plastic products unattractive to rodents. They are used in the water management and agriculture industries — particularly in pipes, water tanks, mulch films, and cable conduits — to prevent gnawing damage."
          }
        },
        {
          "@type": "Question",
          "name": "What are Anti-Static Masterbatches used for?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Anti-Static Masterbatches reduce or eliminate static electricity build-up on plastic surfaces. They are used in the electrical industry and in packaging films, electronic component trays, and industrial containers to protect products from electrostatic discharge."
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
    <section class="ind-page" aria-label="Industries">
        <div class="container-fluid">
            <div class="ind-head">
                <h1 class="section-title center">We understand the unique needs of various industries. Hence, we don't just supply masterbatches, we partner with your innovation. We offer customised solutions that empower you to create high-quality end products across a wide range of applications.</h1>
            </div>

            <?php foreach ($industries as $index => $ind): ?>
                <?php
                $isReverse = ($index % 2 === 1);
                $imgHtml = '<div class="ind-media" aria-hidden="true"><img class="ind-img" src="' . htmlspecialchars(base_url(ltrim((string) $ind['image'], './'))) . '" alt="' . htmlspecialchars((string) $ind['title']) . ' applications" loading="lazy" /></div>';
                $copyHtml = '<div class="ind-copy"><h2 class="ind-title">' . htmlspecialchars((string) $ind['title']) . '</h2><p class="ind-text">' . htmlspecialchars((string) $ind['description']) . '</p></div>';
                ?>
                <section class="ind-row<?= $isReverse ? ' ind-row--reverse' : '' ?>" aria-label="<?= htmlspecialchars((string) $ind['title']) ?>">
                    <?php if ($isReverse): ?>
                        <?= $imgHtml ?>
                        <?= $copyHtml ?>
                    <?php else: ?>
                        <?= $copyHtml ?>
                        <?= $imgHtml ?>
                    <?php endif; ?>
                </section>
            <?php endforeach; ?>
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

<?php require __DIR__ . '/includes/user/footer.php'; ?>
