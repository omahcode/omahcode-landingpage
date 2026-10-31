<?php
/**
 * OMAHCODE - Landing Page Resmi
 * Partner Digitalisasi dan Pengembangan Website Profesional di Cirebon
 * Brand Colors: Deep Navy (#0B192C) & Electric Cyan (#00B4D8)
 */

require_once __DIR__ . '/config/helpers.php';

init_session();
$pdo = get_db();

// 1. Fetch site settings
$siteName       = get_setting('site_name', 'OMAHCODE');
$siteTagline    = get_setting('site_tagline', 'Solusi Digital untuk Setiap Kebutuhan.');
$sitePositioning= get_setting('site_positioning', 'Partner Digitalisasi & Jasa Pembuatan Website Profesional di Cirebon');
$heroHeadline   = get_setting('hero_headline', 'Solusi Digital untuk Mengembangkan Bisnis dan Institusi Anda.');
$heroSubheadline= get_setting('hero_subheadline', 'OMAHCODE membantu sekolah, perusahaan, UMKM, dan instansi pemerintahan menghadirkan solusi digital melalui pengembangan website dan aplikasi yang inovatif, fungsional, serta sesuai kebutuhan.');
$heroCtaPrimary = get_setting('hero_cta_primary', 'Konsultasikan Kebutuhan Anda');
$heroCtaSecondary = get_setting('hero_cta_secondary', 'Jelajahi Solusi Kami');
$aboutTitle     = get_setting('about_title', 'Tentang OMAHCODE');
$aboutLead      = get_setting('about_lead', 'Partner Digitalisasi dan Pengembangan Website Profesional di Cirebon.');
$aboutDesc      = get_setting('about_description', 'OMAHCODE merupakan developer dan penyedia layanan pengembangan website profesional yang berbasis di Cirebon, Indonesia. Kami hadir mendampingi sekolah, instansi pemerintahan, perusahaan, dan UMKM dalam merancang sistem informasi terstruktur, aplikasi web responsif, dan digitalisasi operasional.');
$whyHeadline    = get_setting('why_headline', 'Mengapa Memilih OMAHCODE?');
$whySubheadline = get_setting('why_subheadline', 'Kami mengutamakan kualitas arsitektur software, estetika desain modern, kemudahan penggunaan, dan keberlanjutan sistem.');
$workflowHeadline = get_setting('workflow_headline', 'Alur Kerja Profesional Kami');
$workflowSubheadline = get_setting('workflow_subheadline', 'Tahapan terstruktur dari analisis kebutuhan hingga peluncuran dan pemeliharaan jangka panjang.');
$ctaHeadline    = get_setting('cta_headline', 'Siap Mengembangkan Solusi Digital untuk Kebutuhan Anda?');
$ctaDescription = get_setting('cta_description', 'Diskusikan kebutuhan website dan sistem informasi Anda bersama OMAHCODE. Kami siap membantu menemukan solusi teknologi yang tepat.');
$ctaButton      = get_setting('cta_button', 'Hubungi OMAHCODE Sekarang');
$whatsappNumber = get_setting('whatsapp_number', '6281234567890');
$contactEmail   = get_setting('contact_email', 'halo@omahcode.com');
$contactPhone   = get_setting('contact_phone', '+62 812-3456-7890');
$contactAddress = get_setting('contact_address', 'Jl. Pemuda No. 88, Kesambi, Kota Cirebon, Jawa Barat 45132');
$contactMaps    = get_setting('contact_maps', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126748.56347862024!2d108.474272!3d-6.724734!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6ee2649e6e5b47%3A0x301e8f1fc28b8a0!2sKota%20Cirebon%2C%20Jawa%20Barat!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid');
$siteLogo       = get_setting('site_logo', 'assets/img/omahcode-logo.png');
$siteIcon       = get_setting('site_icon', 'assets/img/omahcode-icon.png');
$siteFavicon    = get_setting('site_favicon', 'assets/img/favicon.png');
$metaTitle      = get_setting('meta_title', 'OMAHCODE | Partner Digitalisasi & Jasa Pembuatan Website Profesional di Cirebon');
$metaDescription= get_setting('meta_description', 'Jasa pembuatan website profesional di Cirebon. OMAHCODE melayani website sekolah, sistem informasi, profil perusahaan, UMKM, dan aplikasi web custom.');
$metaKeywords   = get_setting('meta_keywords', 'jasa pembuatan website cirebon, developer website cirebon, jasa website sekolah, web sistem informasi, aplikasi web cirebon, omahcode');

// 2. Fetch Active Services from MySQL
$servicesStmt = $pdo->query("SELECT * FROM services WHERE is_active = 1 ORDER BY sort_order ASC, id ASC");
$services = $servicesStmt->fetchAll();

// 3. Fetch Active Digital Products from MySQL
$productsStmt = $pdo->query("SELECT * FROM products WHERE is_active = 1 ORDER BY sort_order ASC, id ASC");
$products = $productsStmt->fetchAll();

$productCategories = [];
foreach ($products as $prod) {
    if (!empty($prod['category']) && !in_array($prod['category'], $productCategories)) {
        $productCategories[] = $prod['category'];
    }
}

// 4. Fetch Active Portfolio from MySQL
$portfolioStmt = $pdo->query("SELECT * FROM portfolio WHERE is_active = 1 ORDER BY sort_order ASC, id ASC");
$portfolios = $portfolioStmt->fetchAll();

$hasProducts = !empty($products);
$hasPortfolios = !empty($portfolios);
$heroSecondaryTarget = $hasProducts ? '#produk' : '#layanan';

$flash = flash_get();
$whatsappMainUrl = get_whatsapp_url();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?= e($metaDescription) ?>">
    <meta name="keywords" content="<?= e($metaKeywords) ?>">
    <meta name="author" content="OMAHCODE Developer Team">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= base_url() ?>">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= base_url() ?>">
    <meta property="og:title" content="<?= e($metaTitle) ?>">
    <meta property="og:description" content="<?= e($metaDescription) ?>">
    <meta property="og:image" content="<?= asset($siteLogo) ?>">

    <title><?= e($metaTitle) ?></title>
    <link rel="shortcut icon" href="<?= asset($siteFavicon) ?>" type="image/x-icon">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Stylesheets -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/custom-icon.css" rel="stylesheet">
    <link href="assets/css/magnific-popup.css" rel="stylesheet">
    <link href="assets/css/swiper-bundle.min.css" rel="stylesheet">
    <link href="assets/css/animate.min.css" rel="stylesheet">
    <link href="assets/css/validnavs.css" rel="stylesheet">
    <link href="assets/css/helper.css" rel="stylesheet">
    <link href="assets/css/unit-test.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">

    <!-- OMAHCODE Brand Harmonization Styles -->
    <style>
        :root {
            --omah-navy: #0B192C;
            --omah-navy-dark: #070D18;
            --omah-blue: #0077B6;
            --omah-cyan: #00B4D8;
            --omah-cyan-light: #90E0EF;
            --omah-cyan-glow: rgba(0, 180, 216, 0.15);
            --omah-slate: #64748B;
            --omah-light: #F8FAFC;
            --omah-white: #FFFFFF;
            --omah-border: #E2E8F0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #334155;
            background-color: var(--omah-white);
            overflow-x: hidden;
        }

        html {
            scroll-behavior: smooth;
        }

        section, div[id] {
            scroll-margin-top: 85px;
        }

        /* Navbar Styling */
        nav.navbar.validnavs {
            background: #ffffff !important;
            box-shadow: 0 4px 20px rgba(11, 25, 44, 0.05);
            padding: 12px 0;
            transition: all 0.3s ease;
        }

        .navbar-brand {
            padding: 0;
            display: flex;
            align-items: center;
        }

        .navbar-brand img.logo {
            height: 44px;
            width: auto;
            max-width: 220px;
            object-fit: contain;
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover img.logo {
            transform: scale(1.02);
        }

        .navbar-nav > li > a {
            color: #0F172A !important;
            font-weight: 600;
            font-size: 15px;
            padding: 24px 14px !important;
            transition: color 0.2s ease;
        }

        .navbar-nav > li > a:hover {
            color: var(--omah-cyan) !important;
        }

        .btn-omah-nav {
            background: #25D366;
            color: #ffffff !important;
            padding: 10px 22px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(37, 211, 102, 0.35);
            border: none;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-omah-nav:hover {
            background: #1eb855;
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(37, 211, 102, 0.45);
            color: #ffffff !important;
        }

        /* Hero Section */
        .hero-omah-section {
            background: radial-gradient(circle at 85% 20%, rgba(0, 180, 216, 0.16) 0%, transparent 45%),
                        linear-gradient(135deg, var(--omah-navy-dark) 0%, var(--omah-navy) 60%, #002B49 100%);
            padding: 160px 0 100px 0;
            position: relative;
            color: #ffffff;
            overflow: hidden;
        }

        .badge-omah-brand {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            background: rgba(0, 180, 216, 0.12);
            border: 1px solid rgba(0, 180, 216, 0.35);
            border-radius: 50px;
            font-size: 13px;
            font-weight: 700;
            color: var(--omah-cyan-light);
            letter-spacing: 0.3px;
            margin-bottom: 24px;
            backdrop-filter: blur(10px);
        }

        .hero-omah-section h1 {
            font-size: 46px;
            font-weight: 800;
            line-height: 1.25;
            color: #ffffff;
            margin-bottom: 20px;
            letter-spacing: -0.5px;
        }

        .hero-omah-section h1 .text-highlight {
            background: linear-gradient(90deg, #00B4D8 0%, #90E0EF 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-omah-section p.lead-text {
            font-size: 17px;
            line-height: 1.75;
            color: #CBD5E1;
            margin-bottom: 35px;
            max-width: 600px;
        }

        .hero-cta-btns {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .btn-omah-cta {
            background: #25D366;
            color: #ffffff !important;
            padding: 14px 28px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 15px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 25px rgba(37, 211, 102, 0.3);
            border: none;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-omah-cta:hover {
            background: #1eb855;
            transform: translateY(-2px);
            box-shadow: 0 14px 28px rgba(37, 211, 102, 0.45);
        }

        .btn-omah-outline {
            background: rgba(255, 255, 255, 0.06);
            color: #ffffff !important;
            padding: 14px 28px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 15px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(8px);
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-omah-outline:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: #ffffff;
            transform: translateY(-2px);
        }

        /* Hero Right Composition */
        .hero-composition {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 400px;
        }

        .hero-logo-frame {
            background: radial-gradient(circle, rgba(0, 180, 216, 0.15) 0%, rgba(11, 25, 44, 0.85) 75%);
            border: 2px solid rgba(0, 180, 216, 0.3);
            border-radius: 36px;
            padding: 40px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.5), inset 0 0 40px rgba(0, 180, 216, 0.1);
            backdrop-filter: blur(16px);
            display: inline-block;
            transition: all 0.4s ease;
        }

        .hero-logo-frame:hover {
            transform: translateY(-4px) scale(1.02);
            border-color: var(--omah-cyan);
            box-shadow: 0 30px 70px rgba(0, 180, 216, 0.25);
        }

        .hero-logo-frame img {
            max-height: 200px;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 15px 25px rgba(0, 0, 0, 0.35));
        }

        .floating-pill-stat {
            position: absolute;
            background: rgba(11, 25, 44, 0.9);
            border: 1px solid rgba(0, 180, 216, 0.35);
            border-radius: 16px;
            padding: 12px 18px;
            backdrop-filter: blur(12px);
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.35);
            z-index: 2;
        }

        .floating-pill-stat.card-top {
            top: 20px;
            right: 10px;
        }

        .floating-pill-stat.card-bottom {
            bottom: 20px;
            left: 10px;
        }

        /* FontAwesome Compatibility Fallbacks */
        .fa-shield-halved:before {
            content: "\f2f7";
        }

        /* Footer Social Media Buttons - Crisp Circular Icons */
        .footer-social-btn {
            width: 38px !important;
            height: 38px !important;
            min-width: 38px !important;
            max-width: 38px !important;
            min-height: 38px !important;
            max-height: 38px !important;
            padding: 0 !important;
            margin: 0 !important;
            border-radius: 50% !important;
            background: rgba(255, 255, 255, 0.08) !important;
            border: 1px solid rgba(255, 255, 255, 0.16) !important;
            color: #ffffff !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 15px !important;
            line-height: 1 !important;
            transition: all 0.25s ease !important;
            text-decoration: none !important;
            box-shadow: none !important;
        }

        .footer-social-btn:hover {
            background: linear-gradient(135deg, var(--omah-cyan) 0%, var(--omah-blue) 100%) !important;
            border-color: var(--omah-cyan) !important;
            color: #ffffff !important;
            transform: translateY(-3px) !important;
            box-shadow: 0 6px 16px rgba(0, 180, 216, 0.45) !important;
        }

        /* Mobile Viewport Polish & Sidenav Drawer */
        @media (max-width: 1023px) {
            nav.navbar.validnavs {
                padding: 10px 0 !important;
            }

            .navbar-brand img.logo {
                height: 38px !important;
                max-width: 190px !important;
            }

            nav.navbar.validnavs .navbar-toggle {
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                width: 44px !important;
                height: 44px !important;
                padding: 0 !important;
                margin: 0 !important;
                background: #f8fafc !important;
                border: 1px solid #e2e8f0 !important;
                border-radius: 10px !important;
                color: #0B192C !important;
                cursor: pointer !important;
                float: left !important;
                visibility: visible !important;
                opacity: 1 !important;
                position: relative !important;
                z-index: 10 !important;
                transition: all 0.2s ease !important;
            }

            nav.navbar.validnavs .navbar-toggle:hover,
            nav.navbar.validnavs .navbar-toggle:focus {
                background: #f1f5f9 !important;
                color: var(--omah-cyan) !important;
                border-color: var(--omah-cyan) !important;
            }

            nav.navbar.validnavs .navbar-toggle i,
            nav.navbar.validnavs .navbar-toggle .fa,
            nav.navbar.validnavs .navbar-toggle .fa-solid {
                font-family: "Font Awesome 6 Pro", sans-serif !important;
                font-weight: 900 !important;
                font-size: 22px !important;
                color: #0B192C !important;
                display: inline-block !important;
                visibility: visible !important;
                opacity: 1 !important;
                line-height: 1 !important;
            }

            .btn-close-navbar,
            .btn-close-menu {
                width: 36px !important;
                height: 36px !important;
                border-radius: 50% !important;
                background: #f1f5f9 !important;
                border: 1px solid #e2e8f0 !important;
                color: #0B192C !important;
                font-size: 17px !important;
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                cursor: pointer !important;
                padding: 0 !important;
                transition: all 0.2s ease !important;
            }

            .btn-close-navbar:hover,
            .btn-close-menu:hover {
                background: #fee2e2 !important;
                color: #dc3545 !important;
                border-color: #fca5a5 !important;
            }

            nav.navbar.validnavs.mobile-sidenav .navbar-collapse,
            nav.navbar.validnavs .navbar-collapse,
            #navbar-menu {
                position: fixed !important;
                top: 0 !important;
                left: -380px !important;
                width: 310px !important;
                max-width: 86vw !important;
                height: 100vh !important;
                min-height: 100vh !important;
                padding: 22px 20px !important;
                background: #ffffff !important;
                box-shadow: 12px 0 40px rgba(11, 25, 44, 0.28) !important;
                z-index: 99999 !important;
                overflow-y: auto !important;
                -webkit-overflow-scrolling: touch !important;
                transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
                display: block !important;
                visibility: visible !important;
            }

            nav.navbar.validnavs.mobile-sidenav .navbar-collapse.show,
            nav.navbar.validnavs .navbar-collapse.show,
            #navbar-menu.show,
            #navbar-menu.active-drawer {
                left: 0 !important;
            }

            .overlay-screen {
                display: none;
                z-index: 99998 !important;
                position: fixed !important;
                inset: 0 !important;
                width: 100vw !important;
                height: 100vh !important;
                background: rgba(11, 25, 44, 0.6) !important;
                backdrop-filter: blur(2px) !important;
                cursor: pointer !important;
            }

            .overlay-screen.opened,
            .overlay-screen.active-overlay {
                display: block !important;
            }

            .mobile-drawer-header {
                display: flex !important;
                align-items: center !important;
                justify-content: space-between !important;
                padding-bottom: 14px !important;
                margin-bottom: 18px !important;
                border-bottom: 1px solid #f1f5f9 !important;
            }

            .btn-close-menu {
                width: 36px !important;
                height: 36px !important;
                border-radius: 50% !important;
                background: #f1f5f9 !important;
                border: 1px solid #e2e8f0 !important;
                color: #0B192C !important;
                font-size: 17px !important;
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                cursor: pointer !important;
                padding: 0 !important;
                transition: all 0.2s ease !important;
            }

            .btn-close-menu:hover {
                background: #fee2e2 !important;
                color: #dc3545 !important;
                border-color: #fca5a5 !important;
            }

            .navbar-nav > li > a {
                padding: 12px 14px !important;
                font-size: 15px !important;
                border-radius: 8px !important;
            }

            .navbar-nav > li > a:hover {
                background: #f8fafc !important;
            }
        }

        @media (min-width: 1024px) {
            nav.navbar.validnavs .navbar-toggle {
                display: none !important;
            }
        }

        /* Mobile Viewport Polish: Spacing & Compact Footer */
        @media (max-width: 768px) {
            #kontak {
                padding-top: 55px !important;
                padding-bottom: 45px !important;
            }

            footer.footer-section {
                padding-top: 45px !important;
            }

            footer.footer-section .container.footer-main-container {
                padding-bottom: 25px !important;
            }

            .footer-col-title {
                font-size: 15px !important;
                margin-bottom: 12px !important;
            }

            .footer-nav-list li {
                margin-bottom: 7px !important;
            }

            .footer-nav-list li a {
                font-size: 13px !important;
            }

            .footer-contact-item {
                font-size: 13px !important;
                margin-bottom: 7px !important;
            }

            .footer-brand-desc {
                font-size: 13px !important;
                line-height: 1.5 !important;
                margin-bottom: 12px !important;
            }
        }

        .icon-circle-cyan {
            width: 48px !important;
            height: 48px !important;
            min-width: 48px !important;
            max-width: 48px !important;
            min-height: 48px !important;
            max-height: 48px !important;
            flex-shrink: 0 !important;
            align-self: flex-start !important;
            border-radius: 14px !important;
            background: linear-gradient(135deg, var(--omah-cyan) 0%, var(--omah-blue) 100%);
            color: #ffffff !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 20px !important;
            margin-top: 2px;
        }

        @media (max-width: 767px) {
            .icon-circle-cyan {
                width: 44px !important;
                height: 44px !important;
                min-width: 44px !important;
                max-width: 44px !important;
                min-height: 44px !important;
                max-height: 44px !important;
                border-radius: 12px !important;
                font-size: 18px !important;
            }
        }

        /* Section Titles */
        .omah-section-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .omah-section-title .badge-sub {
            display: inline-block;
            font-size: 13px;
            font-weight: 800;
            color: var(--omah-cyan);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 8px;
        }

        .omah-section-title h2 {
            font-size: 34px;
            font-weight: 800;
            color: var(--omah-navy);
            margin-bottom: 14px;
            letter-spacing: -0.5px;
        }

        .omah-section-title p {
            color: var(--omah-slate);
            font-size: 16px;
            max-width: 650px;
            margin: 0 auto;
        }

        /* Service Cards */
        .service-card-omah {
            background: #ffffff;
            border-radius: 20px;
            padding: 30px 24px;
            border: 1px solid var(--omah-border);
            transition: all 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
            height: 100%;
            display: flex;
            flex-direction: column;
            box-shadow: 0 4px 20px rgba(11, 25, 44, 0.03);
        }

        .service-card-omah:hover {
            transform: translateY(-8px);
            border-color: var(--omah-cyan);
            box-shadow: 0 20px 40px rgba(0, 180, 216, 0.12);
        }

        .service-card-omah .icon-box {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            background: rgba(0, 180, 216, 0.08);
            border: 1px solid rgba(0, 180, 216, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: var(--omah-blue);
            margin-bottom: 22px;
            transition: all 0.3s ease;
        }

        .service-card-omah:hover .icon-box {
            background: linear-gradient(135deg, var(--omah-cyan) 0%, var(--omah-blue) 100%);
            color: #ffffff;
            border-color: transparent;
        }

        .service-card-omah h3 {
            font-size: 19px;
            font-weight: 700;
            color: var(--omah-navy);
            margin-bottom: 12px;
            line-height: 1.35;
        }

        .service-card-omah p {
            font-size: 14px;
            color: var(--omah-slate);
            line-height: 1.65;
            margin-bottom: 20px;
            flex-grow: 1;
        }

        .service-card-omah .link-consult {
            font-size: 14px;
            font-weight: 700;
            color: var(--omah-blue);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: gap 0.2s ease, color 0.2s ease;
        }

        .service-card-omah:hover .link-consult {
            gap: 10px;
            color: var(--omah-cyan);
        }

        /* Products Catalog Cards */
        .product-card-omah {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid var(--omah-border);
            overflow: hidden;
            transition: all 0.35s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
            box-shadow: 0 4px 20px rgba(11, 25, 44, 0.04);
        }

        .product-card-omah:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 180, 216, 0.15);
            border-color: var(--omah-cyan);
        }

        .product-card-omah .prod-img-wrap {
            position: relative;
            height: 210px;
            background: #f1f5f9;
            overflow: hidden;
        }

        .product-card-omah .prod-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-card-omah:hover .prod-img-wrap img {
            transform: scale(1.06);
        }

        .product-badge-cat {
            position: absolute;
            top: 14px;
            left: 14px;
            background: rgba(11, 25, 44, 0.88);
            color: var(--omah-cyan);
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 6px 14px;
            border-radius: 30px;
            backdrop-filter: blur(6px);
            border: 1px solid rgba(0, 180, 216, 0.3);
        }

        .product-card-omah .prod-body {
            padding: 24px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .product-card-omah .prod-title {
            font-size: 20px;
            font-weight: 800;
            color: var(--omah-navy);
            margin-bottom: 10px;
        }

        .product-card-omah .prod-desc {
            font-size: 14px;
            line-height: 1.65;
            color: var(--omah-slate);
            margin-bottom: 18px;
            flex-grow: 1;
        }

        .prod-features-list {
            margin-bottom: 20px;
            padding-left: 0;
            list-style: none;
        }

        .prod-features-list li {
            font-size: 13px;
            color: #334155;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .prod-features-list li i {
            color: var(--omah-cyan);
            font-size: 13px;
        }

        .prod-target {
            background: #F8FAFC;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 12px;
            color: var(--omah-slate);
            margin-bottom: 20px;
            border: 1px dashed #CBD5E1;
        }

        .btn-prod-action {
            width: 100%;
            background: linear-gradient(135deg, var(--omah-cyan) 0%, var(--omah-blue) 100%);
            color: #ffffff !important;
            padding: 12px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 14px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
            border: none;
        }

        .btn-prod-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 180, 216, 0.35);
        }

        /* Filter Tabs */
        .filter-nav-wrap {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 40px;
        }

        .filter-nav-btn {
            background: #ffffff;
            border: 1px solid var(--omah-border);
            color: var(--omah-slate);
            padding: 9px 22px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .filter-nav-btn:hover, .filter-nav-btn.active {
            background: var(--omah-cyan);
            color: #ffffff;
            border-color: var(--omah-cyan);
            box-shadow: 0 4px 15px rgba(0, 180, 216, 0.3);
        }

        /* Work Process */
        .process-box-card {
            background: #ffffff;
            border: 1px solid var(--omah-border);
            border-radius: 20px;
            padding: 30px 24px;
            height: 100%;
            position: relative;
            transition: all 0.3s ease;
        }

        .process-box-card:hover {
            border-color: var(--omah-cyan);
            box-shadow: 0 14px 28px rgba(0, 180, 216, 0.1);
            transform: translateY(-4px);
        }

        .process-number {
            font-size: 32px;
            font-weight: 800;
            color: var(--omah-cyan);
            line-height: 1;
            margin-bottom: 14px;
        }

        /* Floating WhatsApp Button */
        .wa-float-btn {
            position: fixed;
            bottom: 28px;
            right: 28px;
            background: #25D366;
            color: #ffffff !important;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            box-shadow: 0 10px 25px rgba(37, 211, 102, 0.45);
            z-index: 9999;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-decoration: none;
        }

        .wa-float-btn:hover {
            transform: scale(1.12);
            box-shadow: 0 14px 30px rgba(37, 211, 102, 0.6);
        }

        .wa-float-tooltip {
            position: absolute;
            right: 70px;
            background: var(--omah-navy);
            color: #ffffff;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 700;
            white-space: nowrap;
            pointer-events: none;
            opacity: 0;
            transform: translateX(10px);
            transition: all 0.25s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            border: 1px solid rgba(0, 180, 216, 0.3);
        }

        .wa-float-btn:hover .wa-float-tooltip {
            opacity: 1;
            transform: translateX(0);
        }

        /* Tech Tag Pills */
        .tech-pill {
            display: inline-block;
            background: #F1F5F9;
            color: var(--omah-blue);
            font-size: 12px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 6px;
            margin-right: 4px;
            margin-bottom: 4px;
            border: 1px solid #E2E8F0;
        }
    </style>
</head>

<body>

    <!-- Header / Sticky Navbar -->
    <header>
        <nav class="navbar navbar-common mobile-sidenav navbar-sticky navbar-default validnavs navbar-fixed">
            <div class="container d-flex justify-content-between align-items-center">

                <!-- Logo Brand -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" aria-label="Buka Menu">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <a class="navbar-brand" href="<?= base_url() ?>">
                        <img src="<?= asset($siteLogo) ?>" class="logo" alt="<?= e($siteName) ?>">
                    </a>
                </div>

                <!-- Navigation Drawer -->
                <div class="collapse navbar-collapse" id="navbar-menu">
                    <div class="mobile-drawer-header d-lg-none">
                        <img src="<?= asset($siteLogo) ?>" alt="<?= e($siteName) ?>" style="height: 32px; width: auto; object-fit: contain;">
                        <button type="button" class="btn-close-navbar" aria-label="Tutup Menu">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    
                    <ul class="nav navbar-nav navbar-center" data-in="fadeInDown" data-out="fadeOutUp">
                        <li><a href="#home">Beranda</a></li>
                        <li><a href="#tentang">Tentang Kami</a></li>
                        <li><a href="#layanan">Layanan</a></li>
                        <?php if ($hasProducts): ?>
                            <li><a href="#produk">Produk Digital</a></li>
                        <?php endif; ?>
                        <li><a href="#keunggulan">Keunggulan</a></li>
                        <?php if ($hasPortfolios): ?>
                            <li><a href="#portofolio">Portofolio</a></li>
                        <?php endif; ?>
                        <li><a href="#alur-kerja">Alur Kerja</a></li>
                        <li><a href="#kontak">Kontak</a></li>
                    </ul>

                    <!-- Mobile Drawer CTA Button -->
                    <div class="d-lg-none mt-4 pt-3 border-top">
                        <a href="<?= $whatsappMainUrl ?>" target="_blank" rel="noopener noreferrer" class="btn-omah-nav w-100 justify-content-center">
                            <?= svg_wa('18px', '#ffffff') ?> Konsultasi Sekarang
                        </a>
                    </div>
                </div>

                <!-- CTA Button -->
                <div class="attr-right">
                    <div class="attr-nav flex">
                        <ul>
                            <li class="button">
                                <a href="<?= $whatsappMainUrl ?>" target="_blank" rel="noopener noreferrer" class="btn-omah-nav">
                                    <?= svg_wa('18px', '#ffffff') ?> Konsultasi
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>  
            <div class="overlay-screen"></div>
        </nav>
    </header>
    <!-- End Header -->

    <!-- Start Hero Section -->
    <div id="home" class="hero-omah-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <div class="hero-content wow fadeInUp">
                        <div class="badge-omah-brand">
                            <i class="fa-solid fa-code text-info"></i> <?= e($sitePositioning) ?>
                        </div>
                        <h1>
                            Solusi Digital untuk Mengembangkan <span class="text-highlight">Bisnis & Institusi Anda</span>
                        </h1>
                        <p class="lead-text">
                            <?= e($heroSubheadline) ?>
                        </p>
                        <div class="hero-cta-btns">
                            <a href="<?= $whatsappMainUrl ?>" target="_blank" rel="noopener noreferrer" class="btn-omah-cta">
                                <?= svg_wa('20px', '#ffffff') ?> <?= e($heroCtaPrimary) ?>
                            </a>
                            <a href="<?= $heroSecondaryTarget ?>" class="btn-omah-outline">
                                <i class="fa-solid fa-shapes"></i> <?= e($heroCtaSecondary) ?>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Hero Visual with Official Icon Frame -->
                <div class="col-lg-5 text-center mt-5 mt-lg-0">
                    <div class="hero-composition wow fadeInRight" data-wow-delay="200ms">
                        <div class="floating-pill-stat card-top d-none d-sm-flex">
                            <div class="icon-circle-cyan">
                                <i class="fa-solid fa-laptop-code"></i>
                            </div>
                            <div class="text-start">
                                <div class="font-weight-bold font-size-14 text-white">100% Responsif</div>
                                <small style="color: var(--omah-cyan-light);">Mobile-First Design</small>
                            </div>
                        </div>

                        <div class="hero-logo-frame">
                            <img src="<?= asset($siteIcon) ?>" alt="OMAHCODE Official Icon">
                        </div>

                        <div class="floating-pill-stat card-bottom d-none d-sm-flex">
                            <div class="icon-circle-cyan">
                                <i class="fa-solid fa-shield-check"></i>
                            </div>
                            <div class="text-start">
                                <div class="font-weight-bold font-size-14 text-white">Aman & Teruji</div>
                                <small style="color: var(--omah-cyan-light);">Arsitektur Modern</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Hero Section -->

    <!-- Flash Notification -->
    <?php if ($flash): ?>
    <div class="container mt-4">
        <div class="alert alert-<?= $flash['type'] === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show rounded-4" role="alert">
            <i class="fa-solid <?= $flash['type'] === 'success' ? 'fa-circle-check' : 'fa-triangle-exclamation' ?> me-2"></i>
            <?= e($flash['message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    <?php endif; ?>

    <!-- Start Tentang Kami -->
    <div id="tentang" class="py-5" style="padding-top: 90px !important; padding-bottom: 90px !important;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 text-center mb-5 mb-lg-0">
                    <div class="p-4 p-md-5 rounded-4 border shadow-sm text-center position-relative" style="background: linear-gradient(135deg, #F8FAFC 0%, #ECFEFF 100%);">
                        <img src="<?= asset($siteIcon) ?>" alt="OMAHCODE Icon" style="max-height: 180px; width: auto;" class="img-fluid mb-4">
                        <h4 class="font-weight-bold text-dark mb-1">OMAHCODE</h4>
                        <p class="text-muted font-size-14 mb-0"><?= e($sitePositioning) ?></p>
                        <hr class="my-3">
                        <div class="d-flex justify-content-around text-start">
                            <div>
                                <small class="text-muted d-block font-size-12">Fokus</small>
                                <strong class="text-dark font-size-14">Web & Aplikasi</strong>
                            </div>
                            <div>
                                <small class="text-muted d-block font-size-12">Lokasi</small>
                                <strong class="text-dark font-size-14">Cirebon, ID</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 ps-lg-5">
                    <span class="badge-omah-brand text-primary" style="background: rgba(0, 180, 216, 0.08); border-color: rgba(0, 180, 216, 0.25);">
                        TENTANG KAMI
                    </span>
                    <h2 class="mb-3" style="font-size: 36px; font-weight: 800; color: var(--omah-navy); line-height: 1.3;">
                        <?= e($aboutLead) ?>
                    </h2>
                    <p class="text-muted mb-4" style="font-size: 16px; line-height: 1.8;">
                        <?= e($aboutDesc) ?>
                    </p>

                    <div class="row g-3 mb-4">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-start gap-2">
                                <i class="fa-solid fa-circle-check fs-5 mt-1" style="color: var(--omah-cyan);"></i>
                                <div>
                                    <h6 class="mb-1 font-weight-bold text-dark">Website Profesional</h6>
                                    <small class="text-muted">Desain elegan, clean code, & berkecepatan tinggi.</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-start gap-2">
                                <i class="fa-solid fa-circle-check fs-5 mt-1" style="color: var(--omah-cyan);"></i>
                                <div>
                                    <h6 class="mb-1 font-weight-bold text-dark">Digitalisasi Administrasi</h6>
                                    <small class="text-muted">Paperless, e-arsip, dan otomasi alur kerja.</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-start gap-2">
                                <i class="fa-solid fa-circle-check fs-5 mt-1" style="color: var(--omah-cyan);"></i>
                                <div>
                                    <h6 class="mb-1 font-weight-bold text-dark">Sistem Informasi Manajemen</h6>
                                    <small class="text-muted">Database terpusat dengan laporan analitik akurat.</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-start gap-2">
                                <i class="fa-solid fa-circle-check fs-5 mt-1" style="color: var(--omah-cyan);"></i>
                                <div>
                                    <h6 class="mb-1 font-weight-bold text-dark">Solusi Sesuai Kebutuhan</h6>
                                    <small class="text-muted">Tailor-made mengikuti alur kerja nyata pengguna.</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-start gap-2">
                                <i class="fa-solid fa-circle-check fs-5 mt-1" style="color: var(--omah-cyan);"></i>
                                <div>
                                    <h6 class="mb-1 font-weight-bold text-dark">Dukungan Berkelanjutan</h6>
                                    <small class="text-muted">Pendampingan teknis, update sistem berkala, dan monitoring.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="<?= $whatsappMainUrl ?>" target="_blank" rel="noopener noreferrer" class="btn-omah-cta">
                        <?= svg_wa('18px', '#ffffff') ?> Konsultasikan Proyek Anda
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- End Tentang Kami -->

    <!-- Start Layanan Kami -->
    <div id="layanan" class="py-5" style="background-color: #F8FAFC; padding-top: 90px !important; padding-bottom: 90px !important;">
        <div class="container">
            <div class="omah-section-title">
                <span class="badge-sub">LAYANAN KAMI</span>
                <h2>Solusi Pengembangan Website & Sistem Terpadu</h2>
                <p>Membantu transformasi digital lembaga pendidikan, pemerintahan, perusahaan, dan UMKM melalui arsitektur software yang andal.</p>
            </div>

            <div class="row g-4">
                <?php if (!empty($services)): ?>
                    <?php foreach ($services as $srv): ?>
                    <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="100ms">
                        <div class="service-card-omah">
                            <div class="icon-box">
                                <i class="<?= e($srv['icon']) ?>"></i>
                            </div>
                            <h3><?= e($srv['title']) ?></h3>
                            <p><?= e($srv['short_desc']) ?></p>
                            <?php 
                                $waServiceLink = get_whatsapp_url("Halo OMAHCODE, saya ingin berkonsultasi mengenai layanan: " . $srv['title']);
                            ?>
                            <a href="<?= $waServiceLink ?>" target="_blank" rel="noopener noreferrer" class="link-consult">
                                Konsultasi Layanan Ini <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- End Layanan Kami -->

    <!-- Start Produk Digital OMAHCODE (HANYA MUNCUL JIKA ADA PRODUK AKTIF) -->
    <?php if ($hasProducts): ?>
    <div id="produk" class="py-5" style="padding-top: 90px !important; padding-bottom: 90px !important;">
        <div class="container">
            <div class="row align-items-end mb-4">
                <div class="col-lg-8">
                    <span class="badge-sub" style="color: var(--omah-cyan); font-weight: 800; letter-spacing: 1.5px; font-size: 13px;">PRODUK DIGITAL OMAHCODE</span>
                    <h2 style="font-size: 34px; font-weight: 800; color: var(--omah-navy); margin-top: 6px;">Katalog Aplikasi & Sistem Siap Pakai</h2>
                    <p class="text-muted mb-0">Platform software dan sistem web inovatif yang siap diimplementasikan untuk percepatan digitalisasi Anda.</p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <a href="<?= $whatsappMainUrl ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary rounded-pill px-4 py-2 font-weight-bold font-size-14">
                        <?= svg_wa('16px', '#25D366') ?> Request Custom Sistem
                    </a>
                </div>
            </div>

            <!-- Filter Navigation -->
            <?php if (!empty($productCategories)): ?>
            <div class="filter-nav-wrap">
                <button class="filter-nav-btn active" data-filter="all">Semua Kategori</button>
                <?php foreach ($productCategories as $cat): ?>
                    <button class="filter-nav-btn" data-filter="<?= e(slugify($cat)) ?>"><?= e($cat) ?></button>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Products Grid -->
            <div class="row g-4" id="products-container">
                <?php foreach ($products as $prod): ?>
                <?php 
                    $catSlug = slugify($prod['category']);
                    $featuresList = array_filter(array_map('trim', explode("\n", $prod['features'] ?? '')));
                    $ctaUrl = !empty($prod['demo_url']) ? $prod['demo_url'] : get_whatsapp_url("Halo OMAHCODE, saya ingin info produk: " . $prod['name']);
                ?>
                <div class="col-xl-4 col-md-6 product-item-col" data-category="<?= e($catSlug) ?>">
                    <div class="product-card-omah">
                        <div class="prod-img-wrap">
                            <?php if (!empty($prod['image'])): ?>
                                <img src="<?= asset($prod['image']) ?>" alt="<?= e($prod['name']) ?>" loading="lazy">
                            <?php else: ?>
                                <img src="assets/img/portfolio/1.jpg" alt="<?= e($prod['name']) ?>" loading="lazy">
                            <?php endif; ?>
                            <span class="product-badge-cat"><?= e($prod['category']) ?></span>
                        </div>
                        <div class="prod-body">
                            <h3 class="prod-title"><?= e($prod['name']) ?></h3>
                            <p class="prod-desc"><?= e($prod['description']) ?></p>

                            <?php if (!empty($featuresList)): ?>
                            <ul class="prod-features-list">
                                <?php foreach (array_slice($featuresList, 0, 4) as $feat): ?>
                                <li><i class="fa-solid fa-circle-check"></i> <?= e($feat) ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <?php endif; ?>

                            <?php if (!empty($prod['target_users'])): ?>
                            <div class="prod-target">
                                <i class="fa-solid fa-users me-1" style="color: var(--omah-cyan);"></i> <strong>Target:</strong> <?= e($prod['target_users']) ?>
                            </div>
                            <?php endif; ?>

                            <a href="<?= e($ctaUrl) ?>" target="_blank" rel="noopener noreferrer" class="btn-prod-action">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i> <?= e($prod['cta_text'] ?? 'Demo Aplikasi') ?>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
    <?php endif; ?>
    <!-- End Produk Digital -->

    <!-- Start Nilai & Keunggulan -->
    <div id="keunggulan" class="py-5 text-light" style="background-color: var(--omah-navy-dark) !important; padding-top: 90px !important; padding-bottom: 90px !important;">
        <div class="container">
            <div class="omah-section-title mb-5">
                <span class="badge-sub text-info">NILAI & KEUNGGULAN</span>
                <h2 class="text-white"><?= e($whyHeadline) ?></h2>
                <p class="text-light opacity-75"><?= e($whySubheadline) ?></p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6 wow fadeInUp">
                    <div class="p-4 rounded-4 h-100" style="background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(0, 180, 216, 0.2);">
                        <div class="fs-2 mb-3" style="color: var(--omah-cyan);"><i class="fa-solid fa-puzzle-piece"></i></div>
                        <h4 class="text-white font-weight-bold mb-2">Solusi Sesuai Kebutuhan</h4>
                        <p class="text-light opacity-75 font-size-14 mb-0">Setiap sistem dirancang secara spesifik mengikuti alur kerja nyata lembaga dan operasional bisnis Anda.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="100ms">
                    <div class="p-4 rounded-4 h-100" style="background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(0, 180, 216, 0.2);">
                        <div class="fs-2 mb-3" style="color: var(--omah-cyan);"><i class="fa-solid fa-mobile-screen-button"></i></div>
                        <h4 class="text-white font-weight-bold mb-2">Desain Modern & Responsif</h4>
                        <p class="text-light opacity-75 font-size-14 mb-0">Tampilan visual elegan dan presisi di berbagai ukuran layar: smartphone, tablet, laptop, dan monitor desktop.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="200ms">
                    <div class="p-4 rounded-4 h-100" style="background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(0, 180, 216, 0.2);">
                        <div class="fs-2 mb-3" style="color: var(--omah-cyan);"><i class="fa-solid fa-cubes"></i></div>
                        <h4 class="text-white font-weight-bold mb-2">Pengembangan Terstruktur</h4>
                        <p class="text-light opacity-75 font-size-14 mb-0">Arsitektur kode bersih, modular, aman dari celah SQL Injection & XSS, serta mudah dikembangkan di masa depan.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="300ms">
                    <div class="p-4 rounded-4 h-100" style="background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(0, 180, 216, 0.2);">
                        <div class="fs-2 mb-3" style="color: var(--omah-cyan);"><i class="fa-solid fa-hand-pointer"></i></div>
                        <h4 class="text-white font-weight-bold mb-2">Kemudahan Penggunaan</h4>
                        <p class="text-light opacity-75 font-size-14 mb-0">Antarmuka pengguna (UI/UX) yang ramah dan intuitif, mempermudah staf maupun pengguna umum tanpa perlu pelatihan rumit.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="400ms">
                    <div class="p-4 rounded-4 h-100" style="background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(0, 180, 216, 0.2);">
                        <div class="fs-2 mb-3" style="color: var(--omah-cyan);"><i class="fa-solid fa-microchip"></i></div>
                        <h4 class="text-white font-weight-bold mb-2">Teknologi yang Relevan</h4>
                        <p class="text-light opacity-75 font-size-14 mb-0">Menggunakan framework dan teknologi web modern yang teruji keandalan, performa Core Web Vitals, dan keamanannya.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="500ms">
                    <div class="p-4 rounded-4 h-100" style="background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(0, 180, 216, 0.2);">
                        <div class="fs-2 mb-3" style="color: var(--omah-cyan);"><i class="fa-solid fa-headset"></i></div>
                        <h4 class="text-white font-weight-bold mb-2">Dukungan Berkelanjutan</h4>
                        <p class="text-light opacity-75 font-size-14 mb-0">Komitmen pendampingan pasca-peluncuran, pemeliharaan bug, update berkala, dan jaminan keamanan sistem.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Nilai & Keunggulan -->

    <!-- Start Portofolio (HANYA MUNCUL JIKA ADA PORTOFOLIO AKTIF) -->
    <?php if ($hasPortfolios): ?>
    <div id="portofolio" class="py-5" style="padding-top: 90px !important; padding-bottom: 90px !important;">
        <div class="container">
            <div class="row align-items-end mb-4">
                <div class="col-lg-8">
                    <span class="badge-sub" style="color: var(--omah-cyan); font-weight: 800; letter-spacing: 1.5px; font-size: 13px;">PORTOFOLIO PROYEK</span>
                    <h2 style="font-size: 34px; font-weight: 800; color: var(--omah-navy); margin-top: 6px;">Proyek & Hasil Karya OMAHCODE</h2>
                    <p class="text-muted mb-0">Dokumentasi sistem informasi dan website resmi yang telah kami kembangkan.</p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <a href="<?= $whatsappMainUrl ?>" target="_blank" rel="noopener noreferrer" class="btn-omah-cta">
                        <?= svg_wa('18px', '#ffffff') ?> Mulai Proyek Anda
                    </a>
                </div>
            </div>

            <div class="row g-4">
                <?php foreach ($portfolios as $port): ?>
                <div class="col-lg-6 col-md-6 wow fadeInUp">
                    <div class="card border rounded-4 overflow-hidden h-100 shadow-sm" style="border-color: var(--omah-border) !important;">
                        <div class="position-relative" style="height: 250px; background: #e2e8f0;">
                            <?php if (!empty($port['image'])): ?>
                                <img src="<?= asset($port['image']) ?>" alt="<?= e($port['title']) ?>" class="w-100 h-100 object-fit-cover" loading="lazy">
                            <?php else: ?>
                                <img src="assets/img/portfolio/5.jpg" alt="<?= e($port['title']) ?>" class="w-100 h-100 object-fit-cover" loading="lazy">
                            <?php endif; ?>
                            <span class="badge position-absolute top-0 end-0 m-3 px-3 py-2 rounded-pill font-size-12" style="background: var(--omah-navy); color: var(--omah-cyan);">
                                <?= e($port['category']) ?>
                            </span>
                        </div>
                        <div class="card-body p-4 d-flex flex-column">
                            <h4 class="card-title font-weight-bold text-dark mb-2"><?= e($port['title']) ?></h4>
                            <?php if (!empty($port['client_name'])): ?>
                                <small class="text-primary font-weight-bold d-block mb-2">
                                    <i class="fa-solid fa-building me-1"></i> <?= e($port['client_name']) ?>
                                </small>
                            <?php endif; ?>
                            <p class="card-text text-muted font-size-14 mb-3 flex-grow-1">
                                <?= e($port['description']) ?>
                            </p>
                            
                            <?php if (!empty($port['tech_stack'])): ?>
                            <div class="mb-3">
                                <?php 
                                    $techList = explode(',', $port['tech_stack']);
                                    foreach ($techList as $tech):
                                ?>
                                    <span class="tech-pill"><?= e(trim($tech)) ?></span>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($port['project_url']) && $port['project_url'] !== '#'): ?>
                                <a href="<?= e($port['project_url']) ?>" target="_blank" rel="noopener noreferrer" class="link-consult font-weight-bold text-primary">
                                    Lihat Detail Proyek <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <!-- End Portofolio -->

    <!-- Start Alur Kerja -->
    <div id="alur-kerja" class="py-5" style="background-color: #F8FAFC; padding-top: 90px !important; padding-bottom: 90px !important;">
        <div class="container">
            <div class="omah-section-title">
                <span class="badge-sub">PROSES KERJA</span>
                <h2><?= e($workflowHeadline) ?></h2>
                <p><?= e($workflowSubheadline) ?></p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6 wow fadeInUp">
                    <div class="process-box-card">
                        <div class="process-number">01</div>
                        <h4 class="font-weight-bold mb-2">Konsultasi Kebutuhan</h4>
                        <p class="text-muted font-size-14 mb-0">Diskusi awal untuk memahami visi, alur kerja operasional, dan ekspektasi sistem yang ingin dibangun.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="100ms">
                    <div class="process-box-card">
                        <div class="process-number">02</div>
                        <h4 class="font-weight-bold mb-2">Analisis & Perencanaan</h4>
                        <p class="text-muted font-size-14 mb-0">Penyusunan arsitektur sistem, struktur database, wireframe UI/UX, serta estimasi timeline pengerjaan yang terukur.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="200ms">
                    <div class="process-box-card">
                        <div class="process-number">03</div>
                        <h4 class="font-weight-bold mb-2">Desain & Pengembangan</h4>
                        <p class="text-muted font-size-14 mb-0">Proses coding front-end dan backend secara agile dengan standar kode bersih, aman, dan berkecepatan tinggi.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="300ms">
                    <div class="process-box-card">
                        <div class="process-number">04</div>
                        <h4 class="font-weight-bold mb-2">Pengujian & Revisi</h4>
                        <p class="text-muted font-size-14 mb-0">Uji coba fungsionalitas, pengujian responsivitas mobile, verifikasi keamanan, dan penyesuaian detail masukan.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="400ms">
                    <div class="process-box-card">
                        <div class="process-number">05</div>
                        <h4 class="font-weight-bold mb-2">Implementasi & Peluncuran</h4>
                        <p class="text-muted font-size-14 mb-0">Deployment ke live server atau cloud, konfigurasi domain & SSL, serta sesi panduan penggunaan bagi pengguna/staf.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="500ms">
                    <div class="process-box-card">
                        <div class="process-number">06</div>
                        <h4 class="font-weight-bold mb-2">Pemeliharaan & Support</h4>
                        <p class="text-muted font-size-14 mb-0">Pendampingan teknis jangka panjang, backup data berkala, serta kesiapan pengembangan fitur baru selanjutnya.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Alur Kerja -->

    <!-- Start Call to Action -->
    <div id="cta" class="py-5 text-light text-center" style="background: linear-gradient(135deg, var(--omah-navy) 0%, #004B73 50%, var(--omah-cyan) 100%); padding-top: 90px !important; padding-bottom: 90px !important;">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-10 mx-auto">
                    <h2 class="text-white mb-3" style="font-size: 38px; font-weight: 800;">
                        <?= e($ctaHeadline) ?>
                    </h2>
                    <p class="text-light opacity-90 mb-4" style="font-size: 18px; line-height: 1.7;">
                        <?= e($ctaDescription) ?>
                    </p>
                    <a href="<?= $whatsappMainUrl ?>" target="_blank" rel="noopener noreferrer" class="btn btn-light rounded-pill px-5 py-3 font-weight-bold shadow-lg" style="color: var(--omah-navy); font-size: 16px;">
                        <?= svg_wa('22px', '#25D366') ?> <span class="ms-1"><?= e($ctaButton) ?></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- End Call to Action -->

    <!-- Start Kontak & Formulir -->
    <div id="kontak" class="py-5" style="padding-top: 90px !important; padding-bottom: 90px !important;">
        <div class="container">
            <div class="omah-section-title">
                <span class="badge-sub">HUBUNGI KAMI</span>
                <h2>Mari Diskusikan Solusi Digital Anda</h2>
                <p>Kirimkan pesan atau pertanyaan kepada kami. Tim OMAHCODE siap memberikan respons cepat dan rekomendasi solusi terbaik.</p>
            </div>

            <div class="row g-5">
                <!-- Info Kontak -->
                <div class="col-lg-5">
                    <div class="p-4 p-md-5 rounded-4 border h-100" style="background-color: #F8FAFC;">
                        <h4 class="font-weight-bold mb-4" style="color: var(--omah-navy);">Informasi Kontak</h4>
                        
                        <div class="d-flex align-items-start gap-3 mb-4">
                            <div class="icon-circle-cyan">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 font-weight-bold text-dark">Alamat Operasional</h6>
                                <p class="text-muted mb-0 font-size-14"><?= e($contactAddress) ?></p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-3 mb-4">
                            <div class="icon-circle-cyan" style="background: #25D366 !important;">
                                <?= svg_wa('22px', '#ffffff') ?>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 font-weight-bold text-dark">WhatsApp Konsultasi</h6>
                                <p class="mb-0 font-size-14">
                                    <a href="<?= $whatsappMainUrl ?>" target="_blank" rel="noopener noreferrer" class="text-decoration-none text-success font-weight-bold">
                                        <?= e($contactPhone) ?>
                                    </a>
                                </p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-3 mb-4">
                            <div class="icon-circle-cyan">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 font-weight-bold text-dark">Email Resmi</h6>
                                <p class="mb-0 font-size-14">
                                    <a href="mailto:<?= e($contactEmail) ?>" class="text-decoration-none text-dark">
                                        <?= e($contactEmail) ?>
                                    </a>
                                </p>
                            </div>
                        </div>

                        <?php if (!empty($contactMaps)): ?>
                        <div class="rounded-3 overflow-hidden mt-4 border" style="height: 200px;">
                            <iframe src="<?= e($contactMaps) ?>" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Form Kirim Pesan -->
                <div class="col-lg-7">
                    <div class="p-4 p-md-5 rounded-4 bg-white border shadow-sm">
                        <h4 class="font-weight-bold mb-2" style="color: var(--omah-navy);">Kirim Pesan Konsultasi</h4>
                        <p class="text-muted font-size-14 mb-4">Isi formulir di bawah ini dan kami akan segera menghubungi Anda kembali.</p>

                        <div id="contact-alert-box" style="display: none;"></div>

                        <form id="omah-contact-form" action="contact_process.php" method="POST">
                            <?= csrf_field() ?>
                            <input type="text" name="website_hp" style="display: none !important;" tabindex="-1" autocomplete="off">

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label font-weight-bold font-size-14 text-dark">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control py-2 px-3 rounded-3" placeholder="Contoh: Budi Santoso" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label font-weight-bold font-size-14 text-dark">Alamat Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control py-2 px-3 rounded-3" placeholder="nama@instansi.com" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label font-weight-bold font-size-14 text-dark">Nomor WhatsApp / HP</label>
                                    <input type="text" name="phone" class="form-control py-2 px-3 rounded-3" placeholder="Contoh: 08123456789">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label font-weight-bold font-size-14 text-dark">Layanan yang Dibutuhkan</label>
                                    <select name="subject" class="form-select py-2 px-3 rounded-3">
                                        <option value="Konsultasi Umum">Konsultasi Umum</option>
                                        <option value="Website Sekolah & Pendidikan">Website Sekolah & Pendidikan</option>
                                        <option value="Website Perusahaan & Bisnis">Website Perusahaan & Bisnis</option>
                                        <option value="Website Instansi Pemerintahan">Website Instansi Pemerintahan</option>
                                        <option value="Website UMKM & E-Commerce">Website UMKM & E-Commerce</option>
                                        <option value="Sistem Informasi Manajemen">Sistem Informasi Manajemen</option>
                                        <option value="Aplikasi Berbasis Web">Aplikasi Berbasis Web</option>
                                        <option value="Digitalisasi Administrasi">Digitalisasi Administrasi</option>
                                        <option value="Custom Web Development">Custom Web Development</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label font-weight-bold font-size-14 text-dark">Pesan / Rincian Kebutuhan <span class="text-danger">*</span></label>
                                    <textarea name="message" rows="4" class="form-control p-3 rounded-3" placeholder="Jelaskan kebutuhan website atau sistem yang ingin Anda kembangkan..." required></textarea>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" id="btn-submit-contact" class="btn-omah-cta w-100 py-3 font-weight-bold justify-content-center" style="background: linear-gradient(135deg, var(--omah-cyan) 0%, var(--omah-blue) 100%);">
                                        <i class="fa-solid fa-paper-plane me-2"></i> Kirim Pesan Sekarang
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Kontak & Formulir -->

    <!-- Start Footer -->
    <footer class="text-light footer-section" style="background-color: var(--omah-navy-dark) !important; padding-top: 60px;">
        <div class="container footer-main-container pb-4 pb-md-5">
            <div class="row g-3 g-md-4">
                <!-- Col 1: Brand & Logo -->
                <div class="col-lg-4 col-md-12 mb-3 mb-lg-0">
                    <div class="mb-3">
                        <img src="<?= asset($siteLogo) ?>" alt="<?= e($siteName) ?>" style="max-height: 40px; width: auto; object-fit: contain;">
                    </div>
                    <p class="text-light opacity-75 font-size-14 mb-2 footer-brand-desc">
                        <?= e($sitePositioning) ?>. <?= e($siteTagline) ?>
                    </p>
                    <p class="text-light opacity-50 font-size-13 mb-3 footer-brand-desc">
                        Transformasi digital profesional untuk sekolah, perusahaan, instansi pemerintahan, dan UMKM.
                    </p>
                    <div class="footer-social-wrapper d-flex gap-2 align-items-center">
                        <?php if ($fb = get_setting('social_facebook')): ?>
                            <a href="<?= e($fb) ?>" target="_blank" rel="noopener noreferrer" class="footer-social-btn" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <?php endif; ?>
                        <?php if ($ig = get_setting('social_instagram')): ?>
                            <a href="<?= e($ig) ?>" target="_blank" rel="noopener noreferrer" class="footer-social-btn" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
                        <?php endif; ?>
                        <?php if ($li = get_setting('social_linkedin')): ?>
                            <a href="<?= e($li) ?>" target="_blank" rel="noopener noreferrer" class="footer-social-btn" title="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                        <?php endif; ?>
                        <?php if ($gh = get_setting('social_github')): ?>
                            <a href="<?= e($gh) ?>" target="_blank" rel="noopener noreferrer" class="footer-social-btn" title="GitHub"><i class="fa-brands fa-github"></i></a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Col 2: Navigasi Cepat (col-6 di mobile agar berdampingan) -->
                <div class="col-6 col-lg-2 col-md-4">
                    <h5 class="text-white font-weight-bold mb-3 footer-col-title">Navigasi</h5>
                    <ul class="list-unstyled font-size-14 footer-nav-list mb-0">
                        <li class="mb-2"><a href="#home" class="text-light opacity-75 text-decoration-none">Beranda</a></li>
                        <li class="mb-2"><a href="#tentang" class="text-light opacity-75 text-decoration-none">Tentang Kami</a></li>
                        <li class="mb-2"><a href="#layanan" class="text-light opacity-75 text-decoration-none">Layanan Kami</a></li>
                        <?php if ($hasProducts): ?>
                            <li class="mb-2"><a href="#produk" class="text-light opacity-75 text-decoration-none">Produk Digital</a></li>
                        <?php endif; ?>
                        <?php if ($hasPortfolios): ?>
                            <li class="mb-2"><a href="#portofolio" class="text-light opacity-75 text-decoration-none">Portofolio</a></li>
                        <?php endif; ?>
                        <li class="mb-2"><a href="#kontak" class="text-light opacity-75 text-decoration-none">Kontak Kami</a></li>
                    </ul>
                </div>

                <!-- Col 3: Layanan Populer (col-6 di mobile agar berdampingan) -->
                <div class="col-6 col-lg-3 col-md-4">
                    <h5 class="text-white font-weight-bold mb-3 footer-col-title">Layanan Utama</h5>
                    <ul class="list-unstyled font-size-14 footer-nav-list mb-0">
                        <li class="mb-2"><a href="#layanan" class="text-light opacity-75 text-decoration-none">Website Sekolah</a></li>
                        <li class="mb-2"><a href="#layanan" class="text-light opacity-75 text-decoration-none">Profil Bisnis</a></li>
                        <li class="mb-2"><a href="#layanan" class="text-light opacity-75 text-decoration-none">Website Instansi</a></li>
                        <li class="mb-2"><a href="#layanan" class="text-light opacity-75 text-decoration-none">Sistem Informasi</a></li>
                        <li class="mb-2"><a href="#layanan" class="text-light opacity-75 text-decoration-none">Administrasi Digital</a></li>
                    </ul>
                </div>

                <!-- Col 4: Kontak & Lokasi -->
                <div class="col-12 col-lg-3 col-md-4 mt-2 mt-md-0">
                    <h5 class="text-white font-weight-bold mb-3 footer-col-title">Kontak & Lokasi</h5>
                    <p class="text-light opacity-75 font-size-14 mb-2 footer-contact-item">
                        <i class="fa-solid fa-location-dot me-2" style="color: var(--omah-cyan);"></i> <?= e($contactAddress) ?>
                    </p>
                    <p class="text-light opacity-75 font-size-14 mb-2 footer-contact-item">
                        <?= svg_wa('16px', '#25D366') ?> <span class="ms-1"><?= e($contactPhone) ?></span>
                    </p>
                    <p class="text-light opacity-75 font-size-14 mb-0 footer-contact-item">
                        <i class="fa-solid fa-envelope me-2" style="color: var(--omah-cyan);"></i> <?= e($contactEmail) ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="border-top py-3" style="border-color: rgba(255, 255, 255, 0.08) !important;">
            <div class="container text-center font-size-13 text-light opacity-75">
                <p class="mb-0">&copy; <?= date('Y') ?> <strong><?= e($siteName) ?></strong>. Seluruh Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>
    <!-- End Footer -->
    <!-- End Footer -->

    <!-- Floating WhatsApp Action Button (Official Authentic SVG) -->
    <a href="<?= $whatsappMainUrl ?>" target="_blank" rel="noopener noreferrer" class="wa-float-btn" aria-label="Konsultasi WhatsApp OMAHCODE">
        <?= svg_wa('28px', '#ffffff') ?>
        <span class="wa-float-tooltip">Konsultasi WhatsApp</span>
    </a>

    <!-- Scripts -->
    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery.appear.js"></script>
    <script src="assets/js/jquery.easing.min.js"></script>
    <script src="assets/js/magnific-popup.min.js"></script>
    <script src="assets/js/swiper-bundle.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/validnavs.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    $(document).ready(function() {
        // Category Filter for Products
        $('.filter-nav-btn').on('click', function() {
            $('.filter-nav-btn').removeClass('active');
            $(this).addClass('active');

            var filter = $(this).attr('data-filter');
            if (filter === 'all') {
                $('.product-item-col').fadeIn(300);
            } else {
                $('.product-item-col').each(function() {
                    if ($(this).attr('data-category') === filter) {
                        $(this).fadeIn(300);
                    } else {
                        $(this).fadeOut(200);
                    }
                });
            }
        });

        // AJAX Form Submit
        $('#omah-contact-form').on('submit', function(e) {
            e.preventDefault();
            var $form = $(this);
            var $btn = $('#btn-submit-contact');
            var $alertBox = $('#contact-alert-box');

            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-2"></i> Mengirimkan pesan...');
            $alertBox.hide().removeClass('alert alert-success alert-danger');

            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
                dataType: 'json',
                success: function(res) {
                    $btn.prop('disabled', false).html('<i class="fa-solid fa-paper-plane me-2"></i> Kirim Pesan Sekarang');
                    if (res.success) {
                        $alertBox.addClass('alert alert-success').html('<i class="fa-solid fa-circle-check me-2"></i> ' + res.message).slideDown();
                        $form[0].reset();
                        Swal.fire({
                            title: 'Pesan Berhasil Terkirim!',
                            text: res.message,
                            icon: 'success',
                            confirmButtonColor: '#00B4D8',
                            confirmButtonText: 'Selesai'
                        });
                    } else {
                        $alertBox.addClass('alert alert-danger').html('<i class="fa-solid fa-triangle-exclamation me-2"></i> ' + res.message).slideDown();
                        Swal.fire({
                            title: 'Perhatian',
                            text: res.message,
                            icon: 'warning',
                            confirmButtonColor: '#00B4D8'
                        });
                    }
                },
                error: function() {
                    $btn.prop('disabled', false).html('<i class="fa-solid fa-paper-plane me-2"></i> Kirim Pesan Sekarang');
                    $alertBox.addClass('alert alert-danger').html('<i class="fa-solid fa-triangle-exclamation me-2"></i> Terjadi kendala saat mengirim. Silakan coba kembali atau hubungi via WhatsApp.').slideDown();
                    Swal.fire({
                        title: 'Kendala Pengiriman',
                        text: 'Terjadi kendala saat mengirim. Silakan coba kembali atau langsung hubungi kami via WhatsApp.',
                        icon: 'error',
                        confirmButtonColor: '#00B4D8'
                    });
                }
            });
        });

        // Mobile Drawer Controller - Reliable Open & Close
        function closeMobileNav() {
            $('.navbar-collapse').removeClass('show active-drawer opened');
            $('.overlay-screen').removeClass('opened active-overlay');
            $('.navbar').removeClass('navbar-responsive');
            $('body').removeClass('side-right drawer-active');
        }

        // Close button inside drawer
        $(document).on('click', '.btn-close-navbar, .btn-close-menu', function(e) {
            e.preventDefault();
            e.stopPropagation();
            closeMobileNav();
        });

        // Click outside on overlay
        $(document).on('click', '.overlay-screen', function(e) {
            e.preventDefault();
            e.stopPropagation();
            closeMobileNav();
        });

        // Smooth scroll & auto-close mobile drawer when any anchor link is clicked
        $(document).on('click', 'a[href^="#"]', function(e) {
            var href = $(this).attr('href');
            if (href === '#' || href === '') return;
            var target = $(href);
            if (target.length) {
                e.preventDefault();
                closeMobileNav();
                $('html, body').stop().animate({
                    scrollTop: target.offset().top - 75
                }, 500);
            }
        });

        // ESC key to close mobile drawer
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' || e.keyCode === 27) {
                closeMobileNav();
            }
        });
    });
    </script>
</body>
</html>
