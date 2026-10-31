<?php
/**
 * OMAHCODE - Admin Add / Edit Product
 */

require_once __DIR__ . '/../config/helpers.php';
require_admin();

$pdo = get_db();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$isEdit = $id > 0;

$product = [
    'name' => '',
    'category' => 'Pendidikan',
    'description' => '',
    'features' => '',
    'target_users' => '',
    'demo_url' => '',
    'cta_text' => 'Demo Aplikasi',
    'image' => '',
    'sort_order' => 0,
    'is_active' => 1
];

if ($isEdit) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $existing = $stmt->fetch();
    if (!$existing) {
        flash_set('danger', 'Produk tidak ditemukan.');
        header("Location: products.php");
        exit;
    }
    $product = $existing;
}

$pageTitle = $isEdit ? 'Edit Produk Digital' : 'Tambah Produk Digital';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $name        = trim($_POST['name'] ?? '');
    $category    = trim($_POST['category'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $features    = trim($_POST['features'] ?? '');
    $targetUsers = trim($_POST['target_users'] ?? '');
    $demoUrl     = trim($_POST['demo_url'] ?? '');
    $ctaText     = trim($_POST['cta_text'] ?? 'Demo Aplikasi');
    $sortOrder   = (int)($_POST['sort_order'] ?? 0);
    $isActive    = isset($_POST['is_active']) ? 1 : 0;
    $imagePath   = $product['image'];

    if (empty($name)) {
        $error = 'Nama produk wajib diisi.';
    } elseif (empty($category)) {
        $error = 'Kategori produk wajib dipilih.';
    } else {
        // Handle file upload if provided
        if (!empty($_FILES['image']['name'])) {
            $uploadRes = handle_file_upload($_FILES['image'], 'uploads/products');
            if ($uploadRes['success']) {
                // Remove old uploaded file if replaced
                if (!empty($product['image']) && str_starts_with($product['image'], 'uploads/')) {
                    @unlink(ROOT_PATH . '/' . $product['image']);
                }
                $imagePath = $uploadRes['path'];
            } else {
                $error = $uploadRes['error'];
            }
        }

        if (empty($error)) {
            $slug = slugify($name);
            if ($isEdit) {
                $sql = "UPDATE products SET name = ?, slug = ?, category = ?, description = ?, features = ?, target_users = ?, demo_url = ?, cta_text = ?, image = ?, sort_order = ?, is_active = ?, updated_at = NOW() WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$name, $slug, $category, $description, $features, $targetUsers, $demoUrl, $ctaText, $imagePath, $sortOrder, $isActive, $id]);
                flash_set('success', 'Produk digital berhasil diperbarui.');
            } else {
                $sql = "INSERT INTO products (name, slug, category, description, features, target_users, demo_url, cta_text, image, sort_order, is_active, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$name, $slug, $category, $description, $features, $targetUsers, $demoUrl, $ctaText, $imagePath, $sortOrder, $isActive]);
                flash_set('success', 'Produk digital baru berhasil ditambahkan.');
            }
            header("Location: products.php");
            exit;
        }
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="font-weight-bold text-dark mb-1"><?= e($pageTitle) ?></h4>
        <p class="text-muted font-size-14 mb-0">Isi atribut produk digital untuk ditampilkan pada katalog landing page.</p>
    </div>
    <a href="products.php" class="btn btn-outline-secondary rounded-3 px-3 py-2 font-weight-bold font-size-14">
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
            <!-- Nama Produk -->
            <div class="col-md-8">
                <label class="form-label font-weight-bold font-size-14">Nama Produk Digital <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" placeholder="Contoh: SIM-Sekolah Terpadu" value="<?= e($product['name']) ?>" required>
            </div>

            <!-- Kategori -->
            <div class="col-md-4">
                <label class="form-label font-weight-bold font-size-14">Kategori <span class="text-danger">*</span></label>
                <select name="category" class="form-select">
                    <?php
                    $categories = ['Pendidikan', 'Administrasi', 'Pemerintahan', 'Bisnis dan UMKM', 'Sistem Informasi', 'Produktivitas', 'Kesehatan', 'Custom'];
                    foreach ($categories as $cat):
                    ?>
                        <option value="<?= e($cat) ?>" <?= $product['category'] === $cat ? 'selected' : '' ?>><?= e($cat) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Deskripsi Singkat -->
            <div class="col-12">
                <label class="form-label font-weight-bold font-size-14">Deskripsi Produk</label>
                <textarea name="description" rows="3" class="form-control" placeholder="Jelaskan gambaran umum dan manfaat produk ini..."><?= e($product['description']) ?></textarea>
            </div>

            <!-- Fitur Utama -->
            <div class="col-md-6">
                <label class="form-label font-weight-bold font-size-14">Fitur Utama (Satu baris per fitur)</label>
                <textarea name="features" rows="5" class="form-control" placeholder="Manajemen Siswa&#10;Cetak Rapor Otomatis&#10;Absensi QR Code"><?= e($product['features']) ?></textarea>
                <small class="text-muted font-size-12">Setiap baris baru akan otomatis ditampilkan sebagai poin checklist di landing page.</small>
            </div>

            <!-- Target Pengguna -->
            <div class="col-md-6">
                <label class="form-label font-weight-bold font-size-14">Target Pengguna</label>
                <input type="text" name="target_users" class="form-control" placeholder="Contoh: SD, SMP, SMA, Yayasan Pendidikan" value="<?= e($product['target_users']) ?>">
                <small class="text-muted font-size-12">Siapa saja pihak atau institusi yang cocok menggunakan sistem ini.</small>

                <div class="mt-4">
                    <label class="form-label font-weight-bold font-size-14">Urutan Tampilan (Sort Order)</label>
                    <input type="number" name="sort_order" class="form-control" value="<?= (int)$product['sort_order'] ?>">
                    <small class="text-muted font-size-12">Angka lebih kecil akan tampil lebih awal di katalog.</small>
                </div>
            </div>

            <!-- URL Demo & Tombol CTA -->
            <div class="col-md-8">
                <label class="form-label font-weight-bold font-size-14">URL Demo / Aplikasi</label>
                <input type="url" name="demo_url" class="form-control" placeholder="https://demo.omahcode.com/nama-aplikasi" value="<?= e($product['demo_url']) ?>">
                <small class="text-muted font-size-12">Kosongkan jika ingin tombol mengarahkan otomatis ke WhatsApp konsultasi.</small>
            </div>

            <div class="col-md-4">
                <label class="form-label font-weight-bold font-size-14">Teks Tombol Aksi</label>
                <input type="text" name="cta_text" class="form-control" placeholder="Demo Aplikasi" value="<?= e($product['cta_text'] ?? 'Demo Aplikasi') ?>">
                <small class="text-muted font-size-12">Contoh: 'Demo Aplikasi', 'Lihat Produk', 'Akses Sistem'.</small>
            </div>

            <!-- Upload Gambar / Screenshot -->
            <div class="col-md-8">
                <label class="form-label font-weight-bold font-size-14">Thumbnail / Mockup Gambar</label>
                <input type="file" name="image" class="form-control" accept="image/*">
                <small class="text-muted font-size-12">Format: JPG, PNG, WEBP (Maksimal 5MB). Rekomendasi rasio 16:9 atau 4:3.</small>
            </div>

            <div class="col-md-4">
                <label class="form-label font-weight-bold font-size-14">Preview Gambar Saat Ini</label>
                <div class="border rounded-3 p-2 bg-light text-center" style="height: 90px; overflow: hidden;">
                    <?php if (!empty($product['image'])): ?>
                        <img src="<?= asset($product['image']) ?>" alt="Thumbnail" class="h-100 object-fit-contain">
                    <?php else: ?>
                        <span class="text-muted font-size-12 d-block pt-3">Belum ada gambar</span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Status Publikasi -->
            <div class="col-12">
                <div class="form-check form-switch fs-5">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" <?= $product['is_active'] ? 'checked' : '' ?>>
                    <label class="form-check-label font-size-15 font-weight-bold ms-2" for="is_active">
                        Aktifkan dan tampilkan di katalog landing page
                    </label>
                </div>
            </div>

            <div class="col-12 border-top pt-4 mt-2">
                <button type="submit" class="btn btn-primary-admin px-4 py-2">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Produk Digital
                </button>
                <a href="products.php" class="btn btn-light border ms-2 px-4 py-2">Batal</a>
            </div>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

