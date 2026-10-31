<?php
/**
 * OMAHCODE - Admin Header Include
 */

require_once __DIR__ . '/../../config/helpers.php';
require_admin();

$adminUser = get_admin_user();
$siteName  = get_setting('site_name', 'OMAHCODE');
$flash     = flash_get();

// Get unread messages count for badge
$pdo = get_db();
$unreadMessagesCount = $pdo->query("SELECT COUNT(*) FROM messages WHERE status = 'new'")->fetchColumn();
$productsCount = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$servicesCount = $pdo->query("SELECT COUNT(*) FROM services")->fetchColumn();
$portfolioCount = $pdo->query("SELECT COUNT(*) FROM portfolio")->fetchColumn();

$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($pageTitle) ? e($pageTitle) . ' | ' : '' ?>OMAHCODE Admin Panel</title>
    <link rel="shortcut icon" href="../assets/img/favicon.png" type="image/x-icon">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/font-awesome.min.css" rel="stylesheet">
    
    <style>
        :root {
            --sidebar-width: 260px;
            --primary: #00B4D8;
            --primary-hover: #0077B6;
            --dark-nav: #0B192C;
            --light-bg: #F8FAFC;
        }

        .fa-shield-halved:before {
            content: "\f2f7";
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--light-bg);
            color: #334155;
            min-height: 100vh;
        }

        /* Sidebar Styling */
        #admin-sidebar {
            width: var(--sidebar-width);
            background-color: var(--dark-nav);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        #admin-sidebar .sidebar-brand {
            padding: 22px 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            justify-content: flex-start;
            text-decoration: none;
            transition: all 0.25s ease;
        }

        #admin-sidebar .sidebar-brand:hover {
            opacity: 0.92;
            transform: translateY(-1px);
        }

        .sidebar-brand-logo {
            height: 38px;
            width: auto;
            max-width: 100%;
            object-fit: contain;
            display: block;
            filter: drop-shadow(0 2px 8px rgba(0, 180, 216, 0.3));
        }

        .sidebar-menu {
            padding: 16px 12px;
            flex-grow: 1;
        }

        .sidebar-menu .nav-link {
            color: #94a3b8;
            padding: 11px 16px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 4px;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .sidebar-menu .nav-link:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.06);
        }

        .sidebar-menu .nav-link.active {
            color: #ffffff;
            background: linear-gradient(135deg, #00B4D8 0%, #0077B6 100%);
            box-shadow: 0 4px 15px rgba(0, 180, 216, 0.35);
        }

        .sidebar-menu .nav-link i {
            width: 20px;
            font-size: 16px;
            text-align: center;
        }

        /* Main Content Layout */
        #admin-main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        .top-navbar {
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 16px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .page-body {
            padding: 28px;
            flex-grow: 1;
        }

        /* Card & UI components */
        .admin-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
            padding: 24px;
            margin-bottom: 24px;
        }

        .btn-primary-admin {
            background-color: #1e3a8a;
            color: #ffffff;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.25s ease;
            text-decoration: none;
        }

        .btn-primary-admin:hover {
            background-color: #2563eb;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(37, 99, 235, 0.25);
        }

        .table-responsive {
            border-radius: 12px;
            overflow: hidden;
        }

        .table th {
            background-color: #f8fafc;
            color: #475569;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 14px 16px;
            border-bottom: 2px solid #e2e8f0;
        }

        .table td {
            padding: 14px 16px;
            vertical-align: middle;
            font-size: 14px;
            border-bottom: 1px solid #f1f5f9;
        }

        /* Responsive layout */
        @media (max-width: 991.98px) {
            #admin-sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }
            #admin-sidebar.show {
                margin-left: 0;
            }
            #admin-main {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<aside id="admin-sidebar">
    <a href="index.php" class="sidebar-brand">
        <img src="../assets/img/omahcode-logo-light.png" alt="OMAHCODE" class="sidebar-brand-logo">
    </a>

    <div class="sidebar-menu">
        <a href="index.php" class="nav-link <?= $currentPage === 'index.php' ? 'active' : '' ?>">
            <i class="fa-solid fa-chart-pie"></i>
            <span>Dashboard</span>
        </a>

        <a href="products.php" class="nav-link <?= in_array($currentPage, ['products.php', 'product_form.php']) ? 'active' : '' ?>">
            <i class="fa-solid fa-shapes"></i>
            <span>Produk Digital</span>
            <span class="badge bg-secondary ms-auto rounded-pill"><?= $productsCount ?></span>
        </a>

        <a href="services.php" class="nav-link <?= in_array($currentPage, ['services.php', 'service_form.php']) ? 'active' : '' ?>">
            <i class="fa-solid fa-briefcase"></i>
            <span>Layanan Kami</span>
            <span class="badge bg-secondary ms-auto rounded-pill"><?= $servicesCount ?></span>
        </a>

        <a href="portfolio.php" class="nav-link <?= in_array($currentPage, ['portfolio.php', 'portfolio_form.php']) ? 'active' : '' ?>">
            <i class="fa-solid fa-folder-open"></i>
            <span>Portofolio Proyek</span>
            <span class="badge bg-secondary ms-auto rounded-pill"><?= $portfolioCount ?></span>
        </a>

        <a href="messages.php" class="nav-link <?= $currentPage === 'messages.php' ? 'active' : '' ?>">
            <i class="fa-solid fa-envelope"></i>
            <span>Pesan Masuk</span>
            <?php if ($unreadMessagesCount > 0): ?>
                <span class="badge bg-danger ms-auto rounded-pill"><?= $unreadMessagesCount ?></span>
            <?php endif; ?>
        </a>

        <hr style="border-color: rgba(255,255,255,0.08); margin: 16px 0;">

        <a href="settings.php" class="nav-link <?= $currentPage === 'settings.php' ? 'active' : '' ?>">
            <i class="fa-solid fa-sliders"></i>
            <span>Pengaturan Website</span>
        </a>

        <a href="profile.php" class="nav-link <?= $currentPage === 'profile.php' ? 'active' : '' ?>">
            <i class="fa-solid fa-user-gear"></i>
            <span>Akun Admin</span>
        </a>

        <a href="../" target="_blank" class="nav-link text-info">
            <i class="fa-solid fa-arrow-up-right-from-square"></i>
            <span>Lihat Website</span>
        </a>
    </div>

    <!-- Sidebar footer -->
    <div class="p-3 border-top" style="border-color: rgba(255,255,255,0.08) !important;">
        <div class="d-flex align-items-center justify-content-between">
            <div class="text-truncate me-2">
                <small class="text-white d-block font-weight-bold"><?= e($adminUser['name']) ?></small>
                <small class="text-muted"><?= e($adminUser['username']) ?></small>
            </div>
            <a href="logout.php" class="btn btn-sm btn-outline-danger btn-confirm-logout" title="Logout">
                <i class="fa-solid fa-right-from-bracket"></i>
            </a>
        </div>
    </div>
</aside>

<!-- Main Wrapper -->
<div id="admin-main">
    <!-- Top Navbar -->
    <div class="top-navbar">
        <div class="d-flex align-items-center gap-3">
            <button type="button" class="btn btn-light d-lg-none" id="toggle-sidebar">
                <i class="fa-solid fa-bars"></i>
            </button>
            <h5 class="mb-0 font-weight-bold text-dark"><?= isset($pageTitle) ? e($pageTitle) : 'Admin Dashboard' ?></h5>
        </div>

        <div class="d-flex align-items-center gap-3">
            <a href="../" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3 d-none d-sm-inline-flex align-items-center gap-2">
                <i class="fa-solid fa-globe"></i> Kunjungi Web
            </a>
            <div class="dropdown">
                <button class="btn btn-light rounded-pill px-3 d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-circle-user text-primary fs-5"></i>
                    <span class="d-none d-md-inline font-weight-bold font-size-14"><?= e($adminUser['username']) ?></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 mt-2">
                    <li><a class="dropdown-item py-2" href="profile.php"><i class="fa-solid fa-user-pen me-2 text-muted"></i> Profil & Ganti Password</a></li>
                    <li><a class="dropdown-item py-2" href="settings.php"><i class="fa-solid fa-gear me-2 text-muted"></i> Pengaturan Website</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item py-2 text-danger btn-confirm-logout" href="logout.php"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Page Body Container -->
    <div class="page-body">
        <?php if ($flash): ?>
            <div class="alert alert-<?= $flash['type'] === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show rounded-3 mb-4" role="alert">
                <i class="fa-solid <?= $flash['type'] === 'success' ? 'fa-circle-check' : 'fa-triangle-exclamation' ?> me-2"></i>
                <?= e($flash['message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

