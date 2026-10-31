<?php
/**
 * OMAHCODE - Admin Services Management
 */

require_once __DIR__ . '/../config/helpers.php';
require_admin();

$pdo = get_db();

// Handle Status Toggle Action (Before header output)
if (isset($_GET['action']) && $_GET['action'] === 'toggle' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $current = $pdo->prepare("SELECT is_active FROM services WHERE id = ?");
    $current->execute([$id]);
    $val = $current->fetchColumn();
    if ($val !== false) {
        $newVal = $val ? 0 : 1;
        $up = $pdo->prepare("UPDATE services SET is_active = ?, updated_at = NOW() WHERE id = ?");
        $up->execute([$newVal, $id]);
        flash_set('success', 'Status layanan berhasil diperbarui.');
    }
    header("Location: services.php");
    exit;
}

// Handle Delete Action (Before header output)
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $del = $pdo->prepare("DELETE FROM services WHERE id = ?");
    $del->execute([$id]);
    flash_set('success', 'Layanan berhasil dihapus.');
    header("Location: services.php");
    exit;
}

// Fetch all services
$stmt = $pdo->query("SELECT * FROM services ORDER BY sort_order ASC, id ASC");
$services = $stmt->fetchAll();

$pageTitle = 'Manajemen Layanan';
require_once __DIR__ . '/includes/header.php';
?>

<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="font-weight-bold text-dark mb-1">Daftar Layanan OMAHCODE</h4>
        <p class="text-muted font-size-14 mb-0">Kelola kategori dan paket layanan yang ditawarkan kepada klien.</p>
    </div>
    <a href="service_form.php" class="btn btn-primary-admin">
        <i class="fa-solid fa-plus"></i> Tambah Layanan Baru
    </a>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 70px;">Ikon</th>
                    <th>Nama Layanan</th>
                    <th>Kategori</th>
                    <th>Deskripsi Singkat</th>
                    <th style="width: 80px;" class="text-center">Urutan</th>
                    <th style="width: 120px;" class="text-center">Status</th>
                    <th style="width: 130px;" class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($services)): ?>
                    <?php foreach ($services as $s): ?>
                    <tr>
                        <td>
                            <div class="rounded-3 p-2 bg-primary bg-opacity-10 text-primary text-center" style="width: 44px; height: 44px; display: flex; align-items: center; justify-content: center;">
                                <i class="<?= e($s['icon']) ?> fs-5"></i>
                            </div>
                        </td>
                        <td>
                            <div class="font-weight-bold text-dark"><?= e($s['title']) ?></div>
                            <small class="text-muted"><?= e($s['slug']) ?></small>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border"><?= e($s['category'] ?? 'Layanan') ?></span>
                        </td>
                        <td>
                            <span class="text-muted font-size-13 text-truncate d-inline-block" style="max-width: 320px;">
                                <?= e($s['short_desc']) ?>
                            </span>
                        </td>
                        <td class="text-center font-weight-bold">
                            <?= $s['sort_order'] ?>
                        </td>
                        <td class="text-center">
                            <a href="services.php?action=toggle&id=<?= $s['id'] ?>" class="text-decoration-none">
                                <?php if ($s['is_active']): ?>
                                    <span class="badge bg-success rounded-pill px-3 py-2">Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary rounded-pill px-3 py-2">Nonaktif</span>
                                <?php endif; ?>
                            </a>
                        </td>
                        <td class="text-end">
                            <div class="btn-group">
                                <a href="service_form.php?id=<?= $s['id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit Layanan">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="services.php?action=delete&id=<?= $s['id'] ?>" class="btn btn-sm btn-outline-danger btn-confirm-delete" data-name="<?= e($s['title']) ?>" title="Hapus Layanan">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            Belum ada layanan yang ditambahkan.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
