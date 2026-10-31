<?php
/**
 * OMAHCODE - Admin Dashboard Overview
 */

$pageTitle = 'Dashboard Overview';
require_once __DIR__ . '/includes/header.php';

$pdo = get_db();

// Counts
$totalProducts = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$activeProducts = $pdo->query("SELECT COUNT(*) FROM products WHERE is_active = 1")->fetchColumn();

$totalServices = $pdo->query("SELECT COUNT(*) FROM services")->fetchColumn();
$activeServices = $pdo->query("SELECT COUNT(*) FROM services WHERE is_active = 1")->fetchColumn();

$totalPortfolio = $pdo->query("SELECT COUNT(*) FROM portfolio")->fetchColumn();
$activePortfolio = $pdo->query("SELECT COUNT(*) FROM portfolio WHERE is_active = 1")->fetchColumn();

$totalMessages = $pdo->query("SELECT COUNT(*) FROM messages")->fetchColumn();
$newMessages = $pdo->query("SELECT COUNT(*) FROM messages WHERE status = 'new'")->fetchColumn();

// Recent inquiries
$recentMessages = $pdo->query("SELECT * FROM messages ORDER BY id DESC LIMIT 5")->fetchAll();
?>

<!-- Metric Cards Grid -->
<div class="row g-4 mb-4">
    <!-- Card 1: Produk Digital -->
    <div class="col-xl-3 col-sm-6">
        <div class="admin-card mb-0 h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="text-muted font-weight-bold font-size-13 text-uppercase">Produk Digital</span>
                <div class="p-2 rounded-3 bg-primary bg-opacity-10 text-primary">
                    <i class="fa-solid fa-shapes fs-5"></i>
                </div>
            </div>
            <h3 class="font-weight-bold text-dark mb-1"><?= $totalProducts ?></h3>
            <div class="d-flex align-items-center justify-content-between font-size-13">
                <span class="text-success font-weight-bold"><?= $activeProducts ?> Aktif</span>
                <a href="products.php" class="text-decoration-none text-primary">Kelola &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Card 2: Layanan Kami -->
    <div class="col-xl-3 col-sm-6">
        <div class="admin-card mb-0 h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="text-muted font-weight-bold font-size-13 text-uppercase">Layanan Kami</span>
                <div class="p-2 rounded-3 bg-info bg-opacity-10 text-info">
                    <i class="fa-solid fa-briefcase fs-5"></i>
                </div>
            </div>
            <h3 class="font-weight-bold text-dark mb-1"><?= $totalServices ?></h3>
            <div class="d-flex align-items-center justify-content-between font-size-13">
                <span class="text-success font-weight-bold"><?= $activeServices ?> Aktif</span>
                <a href="services.php" class="text-decoration-none text-primary">Kelola &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Card 3: Portofolio Proyek -->
    <div class="col-xl-3 col-sm-6">
        <div class="admin-card mb-0 h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="text-muted font-weight-bold font-size-13 text-uppercase">Portofolio</span>
                <div class="p-2 rounded-3 bg-warning bg-opacity-10 text-warning">
                    <i class="fa-solid fa-folder-open fs-5"></i>
                </div>
            </div>
            <h3 class="font-weight-bold text-dark mb-1"><?= $totalPortfolio ?></h3>
            <div class="d-flex align-items-center justify-content-between font-size-13">
                <span class="text-success font-weight-bold"><?= $activePortfolio ?> Ditampilkan</span>
                <a href="portfolio.php" class="text-decoration-none text-primary">Kelola &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Card 4: Pesan Masuk -->
    <div class="col-xl-3 col-sm-6">
        <div class="admin-card mb-0 h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="text-muted font-weight-bold font-size-13 text-uppercase">Pesan Masuk</span>
                <div class="p-2 rounded-3 bg-danger bg-opacity-10 text-danger">
                    <i class="fa-solid fa-envelope fs-5"></i>
                </div>
            </div>
            <h3 class="font-weight-bold text-dark mb-1"><?= $totalMessages ?></h3>
            <div class="d-flex align-items-center justify-content-between font-size-13">
                <span class="text-danger font-weight-bold"><?= $newMessages ?> Pesan Baru</span>
                <a href="messages.php" class="text-decoration-none text-primary">Buka Inbox &rarr;</a>
            </div>
        </div>
    </div>
</div>

<!-- Quick Shortcuts -->
<div class="admin-card mb-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h6 class="font-weight-bold text-dark mb-0"><i class="fa-solid fa-bolt text-warning me-2"></i>Aksi Cepat</h6>
    </div>
    <div class="d-flex flex-wrap gap-2">
        <a href="product_form.php" class="btn btn-primary-admin">
            <i class="fa-solid fa-plus"></i> Tambah Produk Digital
        </a>
        <a href="service_form.php" class="btn btn-outline-primary rounded-3 px-3 py-2 font-weight-bold font-size-14 d-inline-flex align-items-center gap-2">
            <i class="fa-solid fa-plus"></i> Tambah Layanan
        </a>
        <a href="portfolio_form.php" class="btn btn-outline-primary rounded-3 px-3 py-2 font-weight-bold font-size-14 d-inline-flex align-items-center gap-2">
            <i class="fa-solid fa-plus"></i> Tambah Portofolio
        </a>
        <a href="settings.php" class="btn btn-outline-secondary rounded-3 px-3 py-2 font-weight-bold font-size-14 d-inline-flex align-items-center gap-2">
            <i class="fa-solid fa-sliders"></i> Edit Informasi Website
        </a>
        <a href="../" target="_blank" class="btn btn-light border rounded-3 px-3 py-2 font-weight-bold font-size-14 d-inline-flex align-items-center gap-2 ms-auto">
            <i class="fa-solid fa-external-link"></i> Buka Website Live
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Left: Recent Messages -->
    <div class="col-lg-8">
        <div class="admin-card mb-0">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h5 class="font-weight-bold text-dark mb-1">Pesan Konsultasi Terbaru</h5>
                    <small class="text-muted">Inquiry masuk dari formulir kontak website</small>
                </div>
                <a href="messages.php" class="btn btn-sm btn-outline-primary rounded-pill px-3">Lihat Semua</a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Pengirim</th>
                            <th>Layanan/Subjek</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($recentMessages)): ?>
                            <?php foreach ($recentMessages as $msg): ?>
                            <tr>
                                <td>
                                    <div class="font-weight-bold text-dark"><?= e($msg['name']) ?></div>
                                    <small class="text-muted"><?= e($msg['email']) ?></small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border"><?= e($msg['subject'] ?? 'Konsultasi') ?></span>
                                </td>
                                <td>
                                    <small class="text-muted"><?= date('d M Y, H:i', strtotime($msg['created_at'])) ?></small>
                                </td>
                                <td>
                                    <?php if ($msg['status'] === 'new'): ?>
                                        <span class="badge bg-danger rounded-pill">Baru</span>
                                    <?php elseif ($msg['status'] === 'read'): ?>
                                        <span class="badge bg-info text-dark rounded-pill">Dibaca</span>
                                    <?php else: ?>
                                        <span class="badge bg-success rounded-pill">Ditindaklanjuti</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <a href="messages.php?id=<?= $msg['id'] ?>" class="btn btn-sm btn-light border" title="Lihat Rincian">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    Belum ada pesan masuk dari pengunjung.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right: System & Brand Information -->
    <div class="col-lg-4">
        <div class="admin-card mb-4">
            <h6 class="font-weight-bold text-dark mb-3">Informasi Sistem & Server</h6>
            <ul class="list-group list-group-flush font-size-14">
                <li class="list-group-item d-flex justify-content-between px-0 py-2">
                    <span class="text-muted">Aplikasi</span>
                    <strong>OMAHCODE CMS v1.0</strong>
                </li>
                <li class="list-group-item d-flex justify-content-between px-0 py-2">
                    <span class="text-muted">Database</span>
                    <strong class="text-success text-uppercase"><?= e(env('DB_CONNECTION', 'sqlite')) ?></strong>
                </li>
                <li class="list-group-item d-flex justify-content-between px-0 py-2">
                    <span class="text-muted">Versi PHP</span>
                    <strong><?= phpversion() ?></strong>
                </li>
                <li class="list-group-item d-flex justify-content-between px-0 py-2">
                    <span class="text-muted">Lokasi Server</span>
                    <strong>Kota Cirebon, ID</strong>
                </li>
            </ul>
        </div>

        <div class="admin-card bg-light border-0">
            <h6 class="font-weight-bold text-dark mb-2">Partner Digitalisasi Cirebon</h6>
            <p class="text-muted font-size-13 mb-3">
                Gunakan CMS ini untuk memperbarui katalog produk digital, menambahkan portofolio baru, dan mengelola pesan konsultasi dari klien secara real-time.
            </p>
            <a href="settings.php" class="btn btn-sm btn-outline-primary w-100 rounded-3">
                <i class="fa-solid fa-gear me-1"></i> Buka Pengaturan Brand
            </a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

