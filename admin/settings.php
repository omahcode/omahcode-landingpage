<?php
/**
 * OMAHCODE - Admin Website Settings
 */

require_once __DIR__ . '/../config/helpers.php';
require_admin();

$pdo = get_db();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $settingsKeys = [
        'site_name',
        'site_tagline',
        'site_positioning',
        'hero_headline',
        'hero_subheadline',
        'hero_cta_primary',
        'hero_cta_secondary',
        'about_lead',
        'about_description',
        'why_headline',
        'why_subheadline',
        'workflow_headline',
        'workflow_subheadline',
        'cta_headline',
        'cta_description',
        'cta_button',
        'whatsapp_number',
        'whatsapp_message',
        'contact_email',
        'contact_phone',
        'contact_address',
        'contact_maps',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'social_instagram',
        'social_linkedin',
        'social_github',
        'social_facebook'
    ];

    // Handle Logo Upload
    if (!empty($_FILES['site_logo']['name'])) {
        $logoRes = handle_file_upload($_FILES['site_logo'], 'uploads/site');
        if ($logoRes['success']) {
            set_setting('site_logo', $logoRes['path']);
        } else {
            $error = $logoRes['error'];
        }
    }

    // Handle Favicon Upload
    if (!empty($_FILES['site_favicon']['name'])) {
        $favRes = handle_file_upload($_FILES['site_favicon'], 'uploads/site');
        if ($favRes['success']) {
            set_setting('site_favicon', $favRes['path']);
        } else {
            $error = $favRes['error'];
        }
    }

    if (empty($error)) {
        foreach ($settingsKeys as $k) {
            if (isset($_POST[$k])) {
                set_setting($k, trim($_POST[$k]));
            }
        }
        flash_set('success', 'Pengaturan website berhasil disimpan.');
        header("Location: settings.php");
        exit;
    }
}

$pageTitle = 'Pengaturan Website & CMS';
require_once __DIR__ . '/includes/header.php';

// Current values
$sName        = get_setting('site_name', 'OMAHCODE');
$sTagline     = get_setting('site_tagline', 'Solusi Digital untuk Setiap Kebutuhan.');
$sPositioning = get_setting('site_positioning', 'Partner Digitalisasi dan Pengembangan Website Profesional di Cirebon');
$sHeroHead    = get_setting('hero_headline', 'Solusi Digital untuk Mengembangkan Bisnis dan Institusi Anda.');
$sHeroSub     = get_setting('hero_subheadline', 'OMAHCODE membantu sekolah, perusahaan, UMKM, dan instansi pemerintahan...');
$sHeroCta1    = get_setting('hero_cta_primary', 'Konsultasikan Kebutuhan Anda');
$sHeroCta2    = get_setting('hero_cta_secondary', 'Jelajahi Solusi Kami');
$sAboutLead   = get_setting('about_lead', 'Partner Digitalisasi dan Pengembangan Website Profesional di Cirebon.');
$sAboutDesc   = get_setting('about_description', 'OMAHCODE merupakan developer...');
$sWhyHead     = get_setting('why_headline', 'Mengapa Memilih OMAHCODE?');
$sWhySub      = get_setting('why_subheadline', 'Kami mengutamakan kualitas arsitektur...');
$sWorkHead    = get_setting('workflow_headline', 'Alur Kerja Profesional Kami');
$sWorkSub     = get_setting('workflow_subheadline', 'Tahapan terstruktur dari analisis kebutuhan...');
$sCtaHead     = get_setting('cta_headline', 'Siap Mengembangkan Solusi Digital untuk Kebutuhan Anda?');
$sCtaDesc     = get_setting('cta_description', 'Diskusikan kebutuhan website dan sistem...');
$sCtaBtn      = get_setting('cta_button', 'Hubungi OMAHCODE Sekarang');
$sWaNum       = get_setting('whatsapp_number', '6281234567890');
$sWaMsg       = get_setting('whatsapp_message', 'Halo OMAHCODE, saya ingin berkonsultasi...');
$sEmail       = get_setting('contact_email', 'halo@omahcode.com');
$sPhone       = get_setting('contact_phone', '+62 812-3456-7890');
$sAddress     = get_setting('contact_address', 'Jl. Pemuda No. 88, Kesambi, Kota Cirebon, Jawa Barat 45132');
$sMaps        = get_setting('contact_maps', '');
$sMetaTitle   = get_setting('meta_title', 'OMAHCODE | Partner Digitalisasi & Jasa Pembuatan Website Profesional di Cirebon');
$sMetaDesc    = get_setting('meta_description', 'Jasa pembuatan website profesional di Cirebon...');
$sMetaKey     = get_setting('meta_keywords', 'jasa pembuatan website cirebon, developer website cirebon...');
$sIg          = get_setting('social_instagram', 'https://instagram.com/omahcode');
$sLi          = get_setting('social_linkedin', 'https://linkedin.com/company/omahcode');
$sGh          = get_setting('social_github', 'https://github.com/omahcode');
$sFb          = get_setting('social_facebook', 'https://facebook.com/omahcode');
$sLogo        = get_setting('site_logo', 'assets/img/logo.png');
$sFavicon     = get_setting('site_favicon', 'assets/img/favicon.png');
?>

<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="font-weight-bold text-dark mb-1">Pengaturan Informasi Website</h4>
        <p class="text-muted font-size-14 mb-0">Ubah teks hero, kontak WhatsApp, profil OMAHCODE, dan konfigurasi SEO tanpa menyentuh source code.</p>
    </div>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger rounded-3 mb-4">
        <i class="fa-solid fa-triangle-exclamation me-2"></i> <?= e($error) ?>
    </div>
<?php endif; ?>

<form method="POST" action="" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <!-- 1. Identitas Brand & Logo -->
    <div class="admin-card mb-4">
        <h5 class="font-weight-bold text-dark mb-3 border-bottom pb-2">
            <i class="fa-solid fa-id-card text-primary me-2"></i>Identitas Brand & Logo
        </h5>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label font-weight-bold font-size-14">Nama Perusahaan / Brand</label>
                <input type="text" name="site_name" class="form-control" value="<?= e($sName) ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label font-weight-bold font-size-14">Tagline</label>
                <input type="text" name="site_tagline" class="form-control" value="<?= e($sTagline) ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label font-weight-bold font-size-14">Brand Positioning</label>
                <input type="text" name="site_positioning" class="form-control" value="<?= e($sPositioning) ?>">
            </div>

            <div class="col-md-6 mt-3">
                <label class="form-label font-weight-bold font-size-14">Unggah Logo Website</label>
                <input type="file" name="site_logo" class="form-control" accept="image/*">
                <div class="mt-2 p-2 bg-light rounded border d-inline-block">
                    <img src="<?= asset($sLogo) ?>" alt="Logo Saat Ini" style="max-height: 40px;">
                </div>
            </div>

            <div class="col-md-6 mt-3">
                <label class="form-label font-weight-bold font-size-14">Unggah Favicon</label>
                <input type="file" name="site_favicon" class="form-control" accept="image/*">
                <div class="mt-2 p-2 bg-light rounded border d-inline-block">
                    <img src="<?= asset($sFavicon) ?>" alt="Favicon Saat Ini" style="max-height: 32px;">
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Hero Section Content -->
    <div class="admin-card mb-4">
        <h5 class="font-weight-bold text-dark mb-3 border-bottom pb-2">
            <i class="fa-solid fa-bullhorn text-primary me-2"></i>Konten Hero Banner (Halaman Utama)
        </h5>
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label font-weight-bold font-size-14">Headline Utama Hero</label>
                <input type="text" name="hero_headline" class="form-control" value="<?= e($sHeroHead) ?>" required>
            </div>
            <div class="col-12">
                <label class="form-label font-weight-bold font-size-14">Subheadline Hero</label>
                <textarea name="hero_subheadline" rows="3" class="form-control"><?= e($sHeroSub) ?></textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label font-weight-bold font-size-14">Teks Tombol CTA Utama (WhatsApp)</label>
                <input type="text" name="hero_cta_primary" class="form-control" value="<?= e($sHeroCta1) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label font-weight-bold font-size-14">Teks Tombol CTA Sekunder (Katalog Produk)</label>
                <input type="text" name="hero_cta_secondary" class="form-control" value="<?= e($sHeroCta2) ?>">
            </div>
        </div>
    </div>

    <!-- 3. Profil Tentang OMAHCODE & CTA Section -->
    <div class="admin-card mb-4">
        <h5 class="font-weight-bold text-dark mb-3 border-bottom pb-2">
            <i class="fa-solid fa-circle-info text-primary me-2"></i>Tentang OMAHCODE & Call to Action
        </h5>
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label font-weight-bold font-size-14">Judul / Slogan Bagian Tentang Kami</label>
                <input type="text" name="about_lead" class="form-control" value="<?= e($sAboutLead) ?>">
            </div>
            <div class="col-12">
                <label class="form-label font-weight-bold font-size-14">Deskripsi Lengkap Tentang OMAHCODE</label>
                <textarea name="about_description" rows="4" class="form-control"><?= e($sAboutDesc) ?></textarea>
            </div>
            <div class="col-md-8 mt-4">
                <label class="form-label font-weight-bold font-size-14">Headline Call To Action (Bawah Halaman)</label>
                <input type="text" name="cta_headline" class="form-control" value="<?= e($sCtaHead) ?>">
            </div>
            <div class="col-md-4 mt-4">
                <label class="form-label font-weight-bold font-size-14">Teks Tombol Call To Action</label>
                <input type="text" name="cta_button" class="form-control" value="<?= e($sCtaBtn) ?>">
            </div>
            <div class="col-12">
                <label class="form-label font-weight-bold font-size-14">Deskripsi Call To Action</label>
                <textarea name="cta_description" rows="2" class="form-control"><?= e($sCtaDesc) ?></textarea>
            </div>
        </div>
    </div>

    <!-- 4. Kontak & Lokasi Cirebon -->
    <div class="admin-card mb-4">
        <h5 class="font-weight-bold text-dark mb-3 border-bottom pb-2">
            <i class="fa-solid fa-address-book text-primary me-2"></i>Kontak & Lokasi Kantor
        </h5>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label font-weight-bold font-size-14">Nomor WhatsApp Konsultasi (Awali dengan 62)</label>
                <input type="text" name="whatsapp_number" class="form-control" value="<?= e($sWaNum) ?>" placeholder="6281234567890" required>
                <small class="text-muted font-size-12">Digunakan untuk direct link WhatsApp tombol landing page.</small>
            </div>
            <div class="col-md-6">
                <label class="form-label font-weight-bold font-size-14">Teks Pesan Awal WhatsApp</label>
                <input type="text" name="whatsapp_message" class="form-control" value="<?= e($sWaMsg) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label font-weight-bold font-size-14">Nomor Telepon Tampilan</label>
                <input type="text" name="contact_phone" class="form-control" value="<?= e($sPhone) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label font-weight-bold font-size-14">Alamat Email Resmi</label>
                <input type="email" name="contact_email" class="form-control" value="<?= e($sEmail) ?>" required>
            </div>
            <div class="col-12">
                <label class="form-label font-weight-bold font-size-14">Alamat / Lokasi Operasional di Cirebon</label>
                <input type="text" name="contact_address" class="form-control" value="<?= e($sAddress) ?>">
            </div>
            <div class="col-12">
                <label class="form-label font-weight-bold font-size-14">Google Maps Iframe Embed URL</label>
                <input type="text" name="contact_maps" class="form-control" value="<?= e($sMaps) ?>" placeholder="https://www.google.com/maps/embed?...">
            </div>
        </div>
    </div>

    <!-- 5. Media Sosial & SEO -->
    <div class="admin-card mb-4">
        <h5 class="font-weight-bold text-dark mb-3 border-bottom pb-2">
            <i class="fa-solid fa-share-nodes text-primary me-2"></i>Media Sosial & Optimasi SEO
        </h5>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label font-weight-bold font-size-14">Instagram URL</label>
                <input type="url" name="social_instagram" class="form-control" value="<?= e($sIg) ?>" placeholder="https://instagram.com/omahcode">
            </div>
            <div class="col-md-6">
                <label class="form-label font-weight-bold font-size-14">LinkedIn URL</label>
                <input type="url" name="social_linkedin" class="form-control" value="<?= e($sLi) ?>" placeholder="https://linkedin.com/company/omahcode">
            </div>
            <div class="col-md-6">
                <label class="form-label font-weight-bold font-size-14">GitHub URL</label>
                <input type="url" name="social_github" class="form-control" value="<?= e($sGh) ?>" placeholder="https://github.com/omahcode">
            </div>
            <div class="col-md-6">
                <label class="form-label font-weight-bold font-size-14">Facebook URL</label>
                <input type="url" name="social_facebook" class="form-control" value="<?= e($sFb) ?>" placeholder="https://facebook.com/omahcode">
            </div>

            <div class="col-12 mt-4">
                <label class="form-label font-weight-bold font-size-14">SEO Meta Title</label>
                <input type="text" name="meta_title" class="form-control" value="<?= e($sMetaTitle) ?>">
            </div>
            <div class="col-12">
                <label class="form-label font-weight-bold font-size-14">SEO Meta Description</label>
                <textarea name="meta_description" rows="2" class="form-control"><?= e($sMetaDesc) ?></textarea>
            </div>
            <div class="col-12">
                <label class="form-label font-weight-bold font-size-14">SEO Meta Keywords</label>
                <input type="text" name="meta_keywords" class="form-control" value="<?= e($sMetaKey) ?>">
            </div>
        </div>
    </div>

    <!-- Tombol Simpan -->
    <div class="p-3 bg-white rounded-3 border sticky-bottom shadow-sm d-flex justify-content-between align-items-center">
        <span class="text-muted font-size-14">Perubahan langsung aktif di seluruh halaman website.</span>
        <button type="submit" class="btn btn-primary-admin px-5 py-2">
            <i class="fa-solid fa-floppy-disk"></i> Simpan Seluruh Pengaturan
        </button>
    </div>
</form>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

