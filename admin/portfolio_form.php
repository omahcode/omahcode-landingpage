<?php
/**
 * OMAHCODE - Admin Add / Edit Portfolio Item
 */

require_once __DIR__ . '/../config/helpers.php';
require_admin();

$pdo = get_db();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$isEdit = $id > 0;

$portfolio = [
    'title' => '',
    'category' => 'Website Sekolah',
    'client_name' => '',
    'description' => '',
    'tech_stack' => '',
    'project_url' => '',
    'image' => '',
    'sort_order' => 0,
    'is_active' => 1
];

if ($isEdit) {
    $stmt = $pdo->prepare("SELECT * FROM portfolio WHERE id = ?");
    $stmt->execute([$id]);
    $existing = $stmt->fetch();
    if (!$existing) {
        flash_set('danger', 'Proyek portofolio tidak ditemukan.');
        header("Location: portfolio.php");
        exit;
    }
    $portfolio = $existing;
}

$pageTitle = $isEdit ? 'Edit Portofolio Proyek' : 'Tambah Portofolio Proyek';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $title       = trim($_POST['title'] ?? '');
    $category    = trim($_POST['category'] ?? '');
    $clientName  = trim($_POST['client_name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $techStack   = trim($_POST['tech_stack'] ?? '');
    $projectUrl  = trim($_POST['project_url'] ?? '');
    $sortOrder   = (int)($_POST['sort_order'] ?? 0);
    $isActive    = isset($_POST['is_active']) ? 1 : 0;
    $imagePath   = $portfolio['image'];

    if (empty($title)) {
        $error = 'Judul proyek wajib diisi.';
    } elseif (empty($category)) {
        $error = 'Kategori proyek wajib dipilih.';
    } else {
        if (!empty($_FILES['image']['name'])) {
            $uploadRes = handle_file_upload($_FILES['image'], 'uploads/portfolio');
            if ($uploadRes['success']) {
                if (!empty($portfolio['image']) && str_starts_with($portfolio['image'], 'uploads/')) {
                    @unlink(ROOT_PATH . '/' . $portfolio['image']);
                }
                $imagePath = $uploadRes['path'];
            } else {
                $error = $uploadRes['error'];
            }
        }

        if (empty($error)) {
            if ($isEdit) {
                $sql = "UPDATE portfolio SET title = ?, category = ?, client_name = ?, description = ?, tech_stack = ?, project_url = ?, image = ?, sort_order = ?, is_active = ?, updated_at = NOW() WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$title, $category, $clientName, $description, $techStack, $projectUrl, $imagePath, $sortOrder, $isActive, $id]);
                flash_set('success', 'Portofolio proyek berhasil diperbarui.');
            } else {
                $sql = "INSERT INTO portfolio (title, category, client_name, description, tech_stack, project_url, image, sort_order, is_active, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$title, $category, $clientName, $description, $techStack, $projectUrl, $imagePath, $sortOrder, $isActive]);
                flash_set('success', 'Proyek portofolio baru berhasil ditambahkan.');
            }
            header("Location: portfolio.php");
            exit;
        }
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="font-weight-bold text-dark mb-1"><?= e($pageTitle) ?></h4>
        <p class="text-muted font-size-14 mb-0">Dokumentasikan proyek yang telah selesai untuk membangun kepercayaan calon klien.</p>
    </div>
    <a href="portfolio.php" class="btn btn-outline-secondary rounded-3 px-3 py-2 font-weight-bold font-size-14">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar
    </a>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger rounded-3 mb-4">
        <i class="fa-solid fa-triangle-exclamation me-2"></i> <?= e($error) ?>
    </div>
<?php endif; ?>

<div class="admin-card">
    <form method="POST" action="" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="row g-4">
            <!-- Judul Proyek -->
            <div class="col-md-8">
                <label class="form-label font-weight-bold font-size-14">Judul Proyek / Aplikasi <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control" placeholder="Contoh: Website Resmi & Portal Akademik SMA 1" value="<?= e($portfolio['title']) ?>" required>
            </div>

            <!-- Kategori -->
            <div class="col-md-4">
                <label class="form-label font-weight-bold font-size-14">Kategori Proyek <span class="text-danger">*</span></label>
                <select name="category" class="form-select">
                    <?php
                    $categories = ['Website Sekolah', 'Profil Bisnis', 'Instansi Pemerintah', 'Bisnis dan UMKM', 'Sistem Informasi', 'Custom Web'];
                    foreach ($categories as $cat):
                    ?>
                        <option value="<?= e($cat) ?>" <?= $portfolio['category'] === $cat ? 'selected' : '' ?>><?= e($cat) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Klien & Tech Stack -->
            <div class="col-md-6">
                <label class="form-label font-weight-bold font-size-14">Nama Klien / Lembaga</label>
                <input type="text" name="client_name" class="form-control" placeholder="Contoh: Dinas / Perusahaan / Yayasan" value="<?= e($portfolio['client_name']) ?>">
            </div>

            <div class="col-md-6">
                <label class="form-label font-weight-bold font-size-14">Teknologi yang Digunakan (Pisahkan dengan koma)</label>
                <input type="text" name="tech_stack" class="form-control" placeholder="PHP 8, Bootstrap 5, MySQL, jQuery" value="<?= e($portfolio['tech_stack']) ?>">
            </div>

            <!-- Deskripsi Proyek -->
            <div class="col-12">
                <label class="form-label font-weight-bold font-size-14">Deskripsi Proyek</label>
                <textarea name="description" rows="3" class="form-control" placeholder="Jelaskan ruang lingkup pengerjaan, masalah yang diselesaikan, dan hasil implementasi..."><?= e($portfolio['description']) ?></textarea>
            </div>

            <!-- URL Proyek & Urutan -->
            <div class="col-md-8">
                <label class="form-label font-weight-bold font-size-14">URL Website / Proyek Live</label>
                <input type="url" name="project_url" class="form-control" placeholder="https://contohproyek.com" value="<?= e($portfolio['project_url']) ?>">
                <small class="text-muted font-size-12">Tautan ke website live yang telah online (jika publik).</small>
            </div>

            <div class="col-md-4">
                <label class="form-label font-weight-bold font-size-14">Urutan Tampilan</label>
                <input type="number" name="sort_order" class="form-control" value="<?= (int)$portfolio['sort_order'] ?>">
            </div>

            <!-- Upload Screenshot -->
            <div class="col-md-8">
                <label class="form-label font-weight-bold font-size-14">Unggah Screenshot / Dokumentasi Proyek</label>
                <input type="file" name="image" class="form-control" accept="image/*">
                <small class="text-muted font-size-12">Format: JPG, PNG, WEBP (Maksimal 5MB). Rekomendasi rasio 16:9.</small>
            </div>

            <div class="col-md-4">
                <label class="form-label font-weight-bold font-size-14">Preview Gambar Saat Ini</label>
                <div class="border rounded-3 p-2 bg-light text-center" style="height: 90px; overflow: hidden;">
                    <?php if (!empty($portfolio['image'])): ?>
                        <img src="<?= asset($portfolio['image']) ?>" alt="Screenshot" class="h-100 object-fit-contain">
                    <?php else: ?>
                        <span class="text-muted font-size-12 d-block pt-3">Belum ada gambar</span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Status Tampil -->
            <div class="col-12">
                <div class="form-check form-switch fs-5">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" <?= $portfolio['is_active'] ? 'checked' : '' ?>>
                    <label class="form-check-label font-size-15 font-weight-bold ms-2" for="is_active">
                        Tampilkan proyek ini pada halaman portofolio
                    </label>
                </div>
            </div>

            <div class="col-12 border-top pt-4 mt-2">
                <button type="submit" class="btn btn-primary-admin px-4 py-2">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Portofolio
                </button>
                <a href="portfolio.php" class="btn btn-light border ms-2 px-4 py-2">Batal</a>
            </div>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

