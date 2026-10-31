<?php
/**
 * OMAHCODE - Admin Messages / Inquiries Management
 */

require_once __DIR__ . '/../config/helpers.php';
require_admin();

$pdo = get_db();

// Handle Status Change Action (Before header output)
if (isset($_GET['action']) && $_GET['action'] === 'status' && isset($_GET['id']) && isset($_GET['val'])) {
    $id = (int)$_GET['id'];
    $val = trim($_GET['val']);
    if (in_array($val, ['new', 'read', 'followed_up'])) {
        $up = $pdo->prepare("UPDATE messages SET status = ? WHERE id = ?");
        $up->execute([$val, $id]);
        flash_set('success', 'Status pesan berhasil diperbarui.');
    }
    header("Location: messages.php");
    exit;
}

// Handle Delete Action (Before header output)
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $del = $pdo->prepare("DELETE FROM messages WHERE id = ?");
    $del->execute([$id]);
    flash_set('success', 'Pesan berhasil dihapus.');
    header("Location: messages.php");
    exit;
}

// Filter
$filter = $_GET['filter'] ?? 'all';
$query = "SELECT * FROM messages";
$params = [];
if ($filter === 'new') {
    $query .= " WHERE status = 'new'";
} elseif ($filter === 'read') {
    $query .= " WHERE status = 'read'";
} elseif ($filter === 'followed_up') {
    $query .= " WHERE status = 'followed_up'";
}
$query .= " ORDER BY id DESC";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$messages = $stmt->fetchAll();

// Counts for filter tabs
$countAll = $pdo->query("SELECT COUNT(*) FROM messages")->fetchColumn();
$countNew = $pdo->query("SELECT COUNT(*) FROM messages WHERE status = 'new'")->fetchColumn();
$countRead = $pdo->query("SELECT COUNT(*) FROM messages WHERE status = 'read'")->fetchColumn();
$countFollowed = $pdo->query("SELECT COUNT(*) FROM messages WHERE status = 'followed_up'")->fetchColumn();

$pageTitle = 'Pesan Masuk & Inquiry';
require_once __DIR__ . '/includes/header.php';
?>

<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="font-weight-bold text-dark mb-1">Pesan Masuk dari Formulir Kontak</h4>
        <p class="text-muted font-size-14 mb-0">Kelola dan tindaklanjuti pertanyaan atau kebutuhan konsultasi dari calon klien.</p>
    </div>
</div>

<!-- Filter Tabs -->
<div class="d-flex gap-2 mb-4 flex-wrap">
    <a href="messages.php?filter=all" class="btn btn-sm <?= $filter === 'all' ? 'btn-primary' : 'btn-light border' ?> rounded-pill px-3">
        Semua Pesan (<?= $countAll ?>)
    </a>
    <a href="messages.php?filter=new" class="btn btn-sm <?= $filter === 'new' ? 'btn-danger' : 'btn-light border' ?> rounded-pill px-3">
        Pesan Baru (<?= $countNew ?>)
    </a>
    <a href="messages.php?filter=read" class="btn btn-sm <?= $filter === 'read' ? 'btn-info text-white' : 'btn-light border' ?> rounded-pill px-3">
        Sudah Dibaca (<?= $countRead ?>)
    </a>
    <a href="messages.php?filter=followed_up" class="btn btn-sm <?= $filter === 'followed_up' ? 'btn-success' : 'btn-light border' ?> rounded-pill px-3">
        Ditindaklanjuti (<?= $countFollowed ?>)
    </a>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 220px;">Pengirim</th>
                    <th>Subjek / Layanan</th>
                    <th>Isi Pesan</th>
                    <th style="width: 140px;">Waktu</th>
                    <th style="width: 140px;" class="text-center">Status</th>
                    <th style="width: 160px;" class="text-end">Aksi Tindak Lanjut</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($messages)): ?>
                    <?php foreach ($messages as $m): ?>
                    <?php 
                        $cleanPhone = preg_replace('/[^0-9]/', '', $m['phone'] ?? '');
                        if (str_starts_with($cleanPhone, '08')) {
                            $cleanPhone = '628' . substr($cleanPhone, 2);
                        }
                        $waReplyText = "Halo Bpk/Ibu " . $m['name'] . ", terima kasih telah menghubungi OMAHCODE mengenai " . $m['subject'] . ". Kami siap membantu mendiskusikan kebutuhan solusi digital Anda.";
                        $waReplyUrl = !empty($cleanPhone) ? "https://wa.me/{$cleanPhone}?text=" . urlencode($waReplyText) : null;
                    ?>
                    <tr class="<?= $m['status'] === 'new' ? 'table-warning bg-opacity-25' : '' ?>">
                        <td>
                            <div class="font-weight-bold text-dark"><?= e($m['name']) ?></div>
                            <div class="font-size-13 text-muted">
                                <i class="fa-solid fa-envelope me-1"></i> <a href="mailto:<?= e($m['email']) ?>" class="text-muted text-decoration-none"><?= e($m['email']) ?></a>
                            </div>
                            <?php if (!empty($m['phone'])): ?>
                                <div class="font-size-13 text-success font-weight-bold mt-1">
                                    <?= svg_wa(14, '#25D366', 'me-1') ?> <?= e($m['phone']) ?>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border font-size-13"><?= e($m['subject']) ?></span>
                        </td>
                        <td>
                            <p class="font-size-14 text-dark mb-0" style="white-space: pre-line; max-height: 80px; overflow-y: auto;">
                                <?= e($m['message']) ?>
                            </p>
                        </td>
                        <td>
                            <small class="text-muted d-block"><?= date('d M Y', strtotime($m['created_at'])) ?></small>
                            <small class="text-muted"><?= date('H:i', strtotime($m['created_at'])) ?> WIB</small>
                        </td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light border dropdown-toggle rounded-pill px-3 font-size-12" data-bs-toggle="dropdown">
                                    <?php if ($m['status'] === 'new'): ?>
                                        <span class="text-danger font-weight-bold"><i class="fa-solid fa-circle-dot me-1"></i> Baru</span>
                                    <?php elseif ($m['status'] === 'read'): ?>
                                        <span class="text-info font-weight-bold"><i class="fa-solid fa-check me-1"></i> Dibaca</span>
                                    <?php else: ?>
                                        <span class="text-success font-weight-bold"><i class="fa-solid fa-check-double me-1"></i> Ditindaklanjuti</span>
                                    <?php endif; ?>
                                </button>
                                <ul class="dropdown-menu shadow-sm border-0 rounded-3">
                                    <li><a class="dropdown-item py-2" href="messages.php?action=status&id=<?= $m['id'] ?>&val=new">Tandai Baru</a></li>
                                    <li><a class="dropdown-item py-2" href="messages.php?action=status&id=<?= $m['id'] ?>&val=read">Tandai Dibaca</a></li>
                                    <li><a class="dropdown-item py-2" href="messages.php?action=status&id=<?= $m['id'] ?>&val=followed_up">Tandai Ditindaklanjuti</a></li>
                                </ul>
                            </div>
                        </td>
                        <td class="text-end">
                            <div class="btn-group">
                                <?php if ($waReplyUrl): ?>
                                    <a href="<?= $waReplyUrl ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-success text-white d-inline-flex align-items-center justify-content-center" title="Balas via WhatsApp" style="width: 32px; height: 31px;">
                                        <?= svg_wa(14, '#ffffff') ?>
                                    </a>
                                <?php endif; ?>
                                <a href="mailto:<?= e($m['email']) ?>?subject=<?= urlencode('Tanggapan OMAHCODE: ' . $m['subject']) ?>" class="btn btn-sm btn-outline-primary" title="Balas via Email">
                                    <i class="fa-solid fa-reply"></i>
                                </a>
                                <a href="messages.php?action=delete&id=<?= $m['id'] ?>" class="btn btn-sm btn-outline-danger btn-confirm-delete" data-name="pesan dari <?= e($m['name']) ?>" title="Hapus Pesan">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-envelope-open fs-2 mb-2 d-block"></i>
                            Tidak ada pesan dalam kategori ini.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
