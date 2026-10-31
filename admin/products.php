<?php
/**
 * OMAHCODE - Admin Digital Products Management
 */

require_once __DIR__ . '/../config/helpers.php';
require_admin();

$pdo = get_db();

// Handle Status Toggle Action (Before header output)
if (isset($_GET['action']) && $_GET['action'] === 'toggle' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $current = $pdo->prepare("SELECT is_active FROM products WHERE id = ?");
    $current->execute([$id]);
    $val = $current->fetchColumn();
    if ($val !== false) {
        $newVal = $val ? 0 : 1;
        $up = $pdo->prepare("UPDATE products SET is_active = ?, updated_at = NOW() WHERE id = ?");
        $up->execute([$newVal, $id]);
        flash_set('success', 'Status produk berhasil diperbarui.');
    }
    header("Location: products.php");
    exit;
}

// Handle Delete Action (Before header output)
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $imgStmt = $pdo->prepare("SELECT image FROM products WHERE id = ?");
    $imgStmt->execute([$id]);
    $img = $imgStmt->fetchColumn();
    if ($img && str_starts_with($img, 'uploads/')) {
        @unlink(ROOT_PATH . '/' . $img);
    }

    $del = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $del->execute([$id]);
    flash_set('success', 'Produk berhasil dihapus dari sistem.');
    header("Location: products.php");
    exit;
}

// Fetch all products ordered by sort_order
$stmt = $pdo->query("SELECT * FROM products ORDER BY sort_order ASC, id DESC");
$products = $stmt->fetchAll();

$pageTitle = 'Manajemen Produk Digital';
require_once __DIR__ . '/includes/header.php';
?>

<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="font-weight-bold text-dark mb-1">Katalog Produk Digital</h4>
        <p class="text-muted font-size-14 mb-0">Kelola aplikasi web dan sistem digital OMAHCODE yang tampil di halaman depan.</p>
    </div>
    <a href="product_form.php" class="btn btn-primary-admin">
        <i class="fa-solid fa-plus"></i> Tambah Produk Baru
    </a>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 80px;">Thumbnail</th>
                    <th>Nama & Kategori</th>
                    <th>Target Pengguna</th>
                    <th>URL Demo / Akses</th>
                    <th style="width: 80px;" class="text-center">Urutan</th>
                    <th style="width: 120px;" class="text-center">Status</th>
                    <th style="width: 150px;" class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $p): ?>
                    <tr>
                        <td>
                            <div class="rounded-3 overflow-hidden border" style="width: 60px; height: 60px; background: #f1f5f9;">
                                <?php if (!empty($p['image'])): ?>
                                    <img src="<?= asset($p['image']) ?>" alt="<?= e($p['name']) ?>" class="w-100 h-100 object-fit-cover">
                                <?php else: ?>
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted">
                                        <i class="fa-solid fa-shapes"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td>
                            <div class="font-weight-bold text-dark font-size-15"><?= e($p['name']) ?></div>
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill mt-1">
                                <?= e($p['category']) ?>
                            </span>
                        </td>
                        <td>
                            <span class="text-muted font-size-13"><?= e($p['target_users'] ?? '-') ?></span>
                        </td>
                        <td>
                            <?php if (!empty($p['demo_url'])): ?>
                                <a href="<?= e($p['demo_url']) ?>" target="_blank" class="text-decoration-none font-size-13 text-primary d-inline-flex align-items-center gap-1">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i> <?= e($p['cta_text'] ?? 'Buka Demo') ?>
                                </a>
                            <?php else: ?>
                                <span class="text-muted font-size-13">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center font-weight-bold">
                            <?= $p['sort_order'] ?>
                        </td>
                        <td class="text-center">
                            <a href="products.php?action=toggle&id=<?= $p['id'] ?>" class="text-decoration-none" title="Klik untuk ubah status">
                                <?php if ($p['is_active']): ?>
                                    <span class="badge bg-success rounded-pill px-3 py-2"><i class="fa-solid fa-check me-1"></i> Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary rounded-pill px-3 py-2"><i class="fa-solid fa-ban me-1"></i> Nonaktif</span>
                                <?php endif; ?>
                            </a>
                        </td>
                        <td class="text-end">
                            <div class="btn-group">
                                <a href="product_form.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit Produk">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="products.php?action=delete&id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-danger btn-confirm-delete" data-name="<?= e($p['name']) ?>" title="Hapus Produk">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-box-open fs-2 mb-2 d-block"></i>
                            Belum ada produk digital. Klik tombol <strong>Tambah Produk Baru</strong> di atas untuk menambahkan.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
