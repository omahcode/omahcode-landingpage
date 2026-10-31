<?php
/**
 * OMAHCODE - Admin Add / Edit Service
 */

require_once __DIR__ . '/../config/helpers.php';
require_admin();

$pdo = get_db();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$isEdit = $id > 0;

$service = [
    'title' => '',
    'category' => 'Layanan Utama',
    'short_desc' => '',
    'full_desc' => '',
    'icon' => 'fa-solid fa-laptop-code',
    'sort_order' => 0,
    'is_active' => 1
];

if ($isEdit) {
    $stmt = $pdo->prepare("SELECT * FROM services WHERE id = ?");
    $stmt->execute([$id]);
    $existing = $stmt->fetch();
    if (!$existing) {
        flash_set('danger', 'Layanan tidak ditemukan.');
        header("Location: services.php");
        exit;
    }
    $service = $existing;
}

$pageTitle = $isEdit ? 'Edit Layanan' : 'Tambah Layanan Baru';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $title      = trim($_POST['title'] ?? '');
    $category   = trim($_POST['category'] ?? '');
    $shortDesc  = trim($_POST['short_desc'] ?? '');
    $fullDesc   = trim($_POST['full_desc'] ?? '');
    $icon       = trim($_POST['icon'] ?? 'fa-solid fa-laptop-code');
    $sortOrder  = (int)($_POST['sort_order'] ?? 0);
    $isActive   = isset($_POST['is_active']) ? 1 : 0;

    if (empty($title)) {
        $error = 'Nama layanan wajib diisi.';
    } else {
        $slug = slugify($title);
        if ($isEdit) {
            $sql = "UPDATE services SET title = ?, slug = ?, category = ?, short_desc = ?, full_desc = ?, icon = ?, sort_order = ?, is_active = ?, updated_at = NOW() WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$title, $slug, $category, $shortDesc, $fullDesc, $icon, $sortOrder, $isActive, $id]);
            flash_set('success', 'Layanan berhasil diperbarui.');
        } else {
            $sql = "INSERT INTO services (title, slug, category, short_desc, full_desc, icon, sort_order, is_active, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$title, $slug, $category, $shortDesc, $fullDesc, $icon, $sortOrder, $isActive]);
            flash_set('success', 'Layanan baru berhasil ditambahkan.');
        }
        header("Location: services.php");
        exit;
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="font-weight-bold text-dark mb-1"><?= e($pageTitle) ?></h4>
        <p class="text-muted font-size-14 mb-0">Kelola detail layanan yang akan ditampilkan di section Layanan Kami.</p>
    </div>
    <a href="services.php" class="btn btn-outline-secondary rounded-3 px-3 py-2 font-weight-bold font-size-14">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar
    </a>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger rounded-3 mb-4">
        <i class="fa-solid fa-triangle-exclamation me-2"></i> <?= e($error) ?>
    </div>
<?php endif; ?>

<div class="admin-card">
    <form method="POST" action="">
        <?= csrf_field() ?>

        <div class="row g-4">
            <!-- Nama Layanan -->
            <div class="col-md-8">
                <label class="form-label font-weight-bold font-size-14">Nama Layanan <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control" placeholder="Contoh: Website Sekolah dan Pendidikan" value="<?= e($service['title']) ?>" required>
            </div>

            <!-- Kategori -->
            <div class="col-md-4">
                <label class="form-label font-weight-bold font-size-14">Kategori Layanan</label>
                <input type="text" name="category" class="form-control" placeholder="Pendidikan / Bisnis / Custom" value="<?= e($service['category']) ?>">
            </div>

            <!-- FontAwesome Icon Class -->
            <div class="col-md-6">
                <label class="form-label font-weight-bold font-size-14">Ikon (FontAwesome Class)</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-primary" id="icon-preview"><i class="<?= e($service['icon']) ?>"></i></span>
                    <input type="text" name="icon" id="icon-input" class="form-control" placeholder="fa-solid fa-laptop-code" value="<?= e($service['icon']) ?>">
                </div>
                <small class="text-muted font-size-12">Contoh: <code>fa-solid fa-graduation-cap</code>, <code>fa-solid fa-building</code>, <code>fa-solid fa-store</code>, <code>fa-solid fa-code</code></small>
            </div>

            <!-- Urutan -->
            <div class="col-md-6">
                <label class="form-label font-weight-bold font-size-14">Urutan Tampilan</label>
                <input type="number" name="sort_order" class="form-control" value="<?= (int)$service['sort_order'] ?>">
            </div>

            <!-- Deskripsi Singkat -->
            <div class="col-12">
                <label class="form-label font-weight-bold font-size-14">Deskripsi Singkat (Tampil pada Card Layanan)</label>
                <textarea name="short_desc" rows="3" class="form-control" placeholder="Jelaskan ringkasan layanan dalam 1-2 kalimat..."><?= e($service['short_desc']) ?></textarea>
            </div>

            <!-- Deskripsi Lengkap -->
            <div class="col-12">
                <label class="form-label font-weight-bold font-size-14">Deskripsi Lengkap / Rincian Tambahan</label>
                <textarea name="full_desc" rows="4" class="form-control" placeholder="Rincian fitur, manfaat, dan cakupan pengerjaan layanan ini..."><?= e($service['full_desc']) ?></textarea>
            </div>

            <!-- Status Aktif -->
            <div class="col-12">
                <div class="form-check form-switch fs-5">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" <?= $service['is_active'] ? 'checked' : '' ?>>
                    <label class="form-check-label font-size-15 font-weight-bold ms-2" for="is_active">
                        Tampilkan layanan ini di website
                    </label>
                </div>
            </div>

            <div class="col-12 border-top pt-4 mt-2">
                <button type="submit" class="btn btn-primary-admin px-4 py-2">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Layanan
                </button>
                <a href="services.php" class="btn btn-light border ms-2 px-4 py-2">Batal</a>
            </div>
        </div>
    </form>
</div>

<script>
document.getElementById('icon-input').addEventListener('input', function() {
    var preview = document.getElementById('icon-preview');
    preview.innerHTML = '<i class="' + this.value + '"></i>';
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

