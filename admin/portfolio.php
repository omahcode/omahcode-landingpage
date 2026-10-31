<?php
/**
 * OMAHCODE - Admin Portfolio Management
 */

require_once __DIR__ . '/../config/helpers.php';
require_admin();

$pdo = get_db();

// Handle Status Toggle Action (Before header output)
if (isset($_GET['action']) && $_GET['action'] === 'toggle' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $current = $pdo->prepare("SELECT is_active FROM portfolio WHERE id = ?");
    $current->execute([$id]);
    $val = $current->fetchColumn();
    if ($val !== false) {
        $newVal = $val ? 0 : 1;
        $up = $pdo->prepare("UPDATE portfolio SET is_active = ?, updated_at = NOW() WHERE id = ?");
        $up->execute([$newVal, $id]);
        flash_set('success', 'Status portofolio berhasil diperbarui.');
    }
    header("Location: portfolio.php");
    exit;
}

// Handle Delete Action (Before header output)
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $imgStmt = $pdo->prepare("SELECT image FROM portfolio WHERE id = ?");
    $imgStmt->execute([$id]);
    $img = $imgStmt->fetchColumn();
    if ($img && str_starts_with($img, 'uploads/')) {
        @unlink(ROOT_PATH . '/' . $img);
    }

    $del = $pdo->prepare("DELETE FROM portfolio WHERE id = ?");
    $del->execute([$id]);
    flash_set('success', 'Proyek portofolio berhasil dihapus.');
    header("Location: portfolio.php");
    exit;
}

// Fetch all portfolio items
$stmt = $pdo->query("SELECT * FROM portfolio ORDER BY sort_order ASC, id DESC");
$portfolios = $stmt->fetchAll();

$pageTitle = 'Manajemen Portofolio';
require_once __DIR__ . '/includes/header.php';
?>

<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="font-weight-bold text-dark mb-1">Portofolio & Rekam Proyek</h4>
        <p class="text-muted font-size-14 mb-0">Kelola dokumentasi hasil karya dan implementasi sistem yang telah diselesaikan.</p>
    </div>
    <a href="portfolio_form.php" class="btn btn-primary-admin">
        <i class="fa-solid fa-plus"></i> Tambah Proyek Baru
    </a>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 80px;">Screenshot</th>
                    <th>Judul Proyek & Kategori</th>
                    <th>Klien / Lembaga</th>
                    <th>Tech Stack</th>
                    <th style="width: 80px;" class="text-center">Urutan</th>
                    <th style="width: 120px;" class="text-center">Status</th>
                    <th style="width: 130px;" class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($portfolios)): ?>
                    <?php foreach ($portfolios as $p): ?>
                    <tr>
                        <td>
                            <div class="rounded-3 overflow-hidden border" style="width: 60px; height: 60px; background: #f1f5f9;">
                                <?php if (!empty($p['image'])): ?>
                                    <img src="<?= asset($p['image']) ?>" alt="<?= e($p['title']) ?>" class="w-100 h-100 object-fit-cover">
                                <?php else: ?>
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted">
                                        <i class="fa-solid fa-image"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td>
                            <div class="font-weight-bold text-dark font-size-15"><?= e($p['title']) ?></div>
                            <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 rounded-pill mt-1">
                                <?= e($p['category']) ?>
                            </span>
                        </td>
                        <td>
                            <span class="text-muted font-size-13"><?= e($p['client_name'] ?? '-') ?></span>
                        </td>
                        <td>
                            <span class="text-muted font-size-13"><?= e($p['tech_stack'] ?? '-') ?></span>
                        </td>
                        <td class="text-center font-weight-bold">
                            <?= $p['sort_order'] ?>
                        </td>
                        <td class="text-center">
                            <a href="portfolio.php?action=toggle&id=<?= $p['id'] ?>" class="text-decoration-none">
                                <?php if ($p['is_active']): ?>
                                    <span class="badge bg-success rounded-pill px-3 py-2">Tampil</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary rounded-pill px-3 py-2">Disembunyikan</span>
                                <?php endif; ?>
                            </a>
                        </td>
                        <td class="text-end">
                            <div class="btn-group">
                                <a href="portfolio_form.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit Portofolio">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="portfolio.php?action=delete&id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-danger btn-confirm-delete" data-name="<?= e($p['title']) ?>" title="Hapus Portofolio">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            Belum ada proyek portofolio yang ditambahkan.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
