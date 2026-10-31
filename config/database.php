<?php
/**
 * OMAHCODE - Database Connection & Migration Handler
 * Optimized for MySQL (Laragon / Production) with SQLite compatibility
 */

if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(__DIR__));
}

// Load .env if present
function load_env_file($path) {
    if (!file_exists($path)) {
        return;
    }
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || strpos($line, '#') === 0) {
            continue;
        }
        if (strpos($line, '=') !== false) {
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);
            if ((str_starts_with($value, '"') && str_ends_with($value, '"')) ||
                (str_starts_with($value, "'") && str_ends_with($value, "'"))) {
                $value = substr($value, 1, -1);
            }
            if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                if (function_exists('putenv')) {
                    @putenv(sprintf('%s=%s', $name, $value));
                }
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }
}

load_env_file(ROOT_PATH . '/.env');

function env($key, $default = null) {
    $val = null;
    if (array_key_exists($key, $_ENV)) {
        $val = $_ENV[$key];
    } elseif (array_key_exists($key, $_SERVER)) {
        $val = $_SERVER[$key];
    } elseif (function_exists('getenv')) {
        $g = @getenv($key);
        if ($g !== false) {
            $val = $g;
        }
    }

    if ($val === null || $val === false) {
        return $default;
    }
    if ($val === 'true') return true;
    if ($val === 'false') return false;
    return $val;
}

/**
 * Returns a singleton PDO instance with auto-schema installation and seed.
 */
function get_db() {
    static $pdo = null;
    if ($pdo !== null) {
        return $pdo;
    }

    $driver = strtolower(env('DB_CONNECTION', 'mysql'));

    if ($driver === 'mysql') {
        $host = env('DB_HOST', '127.0.0.1');
        $port = env('DB_PORT', '3306');
        $dbname = env('DB_DATABASE', 'omahcode');
        $user = env('DB_USERNAME', 'root');
        $pass = env('DB_PASSWORD', '');

        try {
            // First connect without dbname to ensure database exists
            $serverDsn = "mysql:host={$host};port={$port};charset=utf8mb4";
            $serverPdo = new PDO($serverDsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            $serverPdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbname}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");

            // Now connect to the database
            $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";
            $pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);

            init_database_tables($pdo, 'mysql');
            return $pdo;
        } catch (PDOException $e) {
            error_log("MySQL connection error: " . $e->getMessage());
            throw new Exception("Koneksi MySQL Gagal: " . $e->getMessage());
        }
    }

    // SQLite Fallback
    $sqliteRelPath = env('DB_SQLITE_PATH', 'database/omahcode.sqlite');
    $sqlitePath = (str_starts_with($sqliteRelPath, '/') || preg_match('/^[A-Za-z]:[\\\\\/]/', $sqliteRelPath))
        ? $sqliteRelPath
        : ROOT_PATH . DIRECTORY_SEPARATOR . $sqliteRelPath;

    $sqliteDir = dirname($sqlitePath);
    if (!is_dir($sqliteDir)) {
        @mkdir($sqliteDir, 0755, true);
    }

    $isNewDb = !file_exists($sqlitePath) || filesize($sqlitePath) === 0;

    $dsn = "sqlite:" . $sqlitePath;
    $pdo = new PDO($dsn, null, null, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    $pdo->exec("PRAGMA foreign_keys = ON;");
    $pdo->exec("PRAGMA journal_mode = WAL;");

    init_database_tables($pdo, 'sqlite', $isNewDb);

    return $pdo;
}

/**
 * Creates tables and seeds default data if tables are not found
 */
function init_database_tables(PDO $pdo, string $driver = 'mysql', bool $forceSeed = false) {
    try {
        $check = false;
        if ($driver === 'mysql') {
            $res = $pdo->query("SHOW TABLES LIKE 'settings'");
            $check = $res && $res->fetch();
        } else {
            $res = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='settings'");
            $check = $res && $res->fetch();
        }

        if (!$check || $forceSeed) {
            $schemaFile = ($driver === 'mysql') 
                ? ROOT_PATH . '/database/mysql_schema.sql' 
                : ROOT_PATH . '/database/schema.sql';

            if (file_exists($schemaFile)) {
                $sql = file_get_contents($schemaFile);
                if ($driver === 'mysql') {
                    $pdo->exec($sql);
                } else {
                    $statements = array_filter(array_map('trim', explode(';', $sql)));
                    foreach ($statements as $stmt) {
                        if (!empty($stmt)) {
                            $pdo->exec($stmt);
                        }
                    }
                }
            }

            seed_default_data($pdo, $driver);
        }
    } catch (Exception $e) {
        error_log("Database initialization error: " . $e->getMessage());
    }
}

/**
 * Seeds default data for OMAHCODE
 */
function seed_default_data(PDO $pdo, string $driver = 'mysql') {
    // 1. Settings with new Official Logo & Icon
    $settings = [
        'site_name' => 'OMAHCODE',
        'site_tagline' => 'Solusi Digital untuk Setiap Kebutuhan.',
        'site_positioning' => 'Partner Digitalisasi & Pengembangan Website Profesional di Cirebon',
        'hero_headline' => 'Solusi Digital untuk Mengembangkan Bisnis dan Institusi Anda.',
        'hero_subheadline' => 'OMAHCODE membantu sekolah, perusahaan, UMKM, dan instansi pemerintahan menghadirkan solusi digital melalui pengembangan website dan aplikasi yang inovatif, fungsional, serta sesuai kebutuhan.',
        'hero_cta_primary' => 'Konsultasikan Kebutuhan Anda',
        'hero_cta_secondary' => 'Jelajahi Solusi Kami',
        'about_title' => 'Tentang OMAHCODE',
        'about_lead' => 'Partner Digitalisasi dan Pengembangan Website Profesional di Cirebon.',
        'about_description' => 'OMAHCODE merupakan developer dan penyedia layanan pengembangan website profesional yang berbasis di Cirebon, Indonesia. Kami hadir mendampingi sekolah, instansi pemerintahan, perusahaan, dan UMKM dalam merancang sistem informasi terstruktur, aplikasi web responsif, dan digitalisasi operasional yang siap mengakselerasi produktivitas kerja.',
        'why_headline' => 'Mengapa Memilih OMAHCODE?',
        'why_subheadline' => 'Kami mengutamakan kualitas arsitektur software, estetika desain modern, kemudahan penggunaan, dan keberlanjutan sistem.',
        'workflow_headline' => 'Alur Kerja Profesional Kami',
        'workflow_subheadline' => 'Tahapan terstruktur dari analisis kebutuhan hingga peluncuran dan pemeliharaan jangka panjang.',
        'cta_headline' => 'Siap Mengembangkan Solusi Digital untuk Kebutuhan Anda?',
        'cta_description' => 'Diskusikan kebutuhan website dan sistem informasi Anda bersama OMAHCODE. Kami siap membantu menemukan solusi teknologi yang tepat.',
        'cta_button' => 'Hubungi OMAHCODE Sekarang',
        'whatsapp_number' => '6281234567890',
        'whatsapp_message' => 'Halo OMAHCODE, saya ingin berkonsultasi mengenai kebutuhan website / sistem aplikasi digital.',
        'contact_email' => 'halo@omahcode.com',
        'contact_phone' => '+62 812-3456-7890',
        'contact_address' => 'Jl. Pemuda No. 88, Kesambi, Kota Cirebon, Jawa Barat 45132',
        'contact_maps' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126748.56347862024!2d108.474272!3d-6.724734!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6ee2649e6e5b47%3A0x301e8f1fc28b8a0!2sKota%20Cirebon%2C%20Jawa%20Barat!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid',
        'site_logo' => 'assets/img/omahcode-logo.png',
        'site_icon' => 'assets/img/omahcode-icon.png',
        'site_favicon' => 'assets/img/favicon.png',
        'meta_title' => 'OMAHCODE | Partner Digitalisasi & Jasa Pembuatan Website Profesional di Cirebon',
        'meta_description' => 'Jasa pembuatan website profesional di Cirebon. OMAHCODE melayani website sekolah, sistem informasi, profil perusahaan, UMKM, dan aplikasi web custom.',
        'meta_keywords' => 'jasa pembuatan website cirebon, developer website cirebon, jasa website sekolah, web sistem informasi, aplikasi web cirebon, omahcode',
        'social_instagram' => 'https://instagram.com/omahcode',
        'social_linkedin' => 'https://linkedin.com/company/omahcode',
        'social_github' => 'https://github.com/omahcode',
        'social_facebook' => 'https://facebook.com/omahcode'
    ];

    if ($driver === 'mysql') {
        $stmt = $pdo->prepare("INSERT INTO settings (`key`, `value`) VALUES (?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`)");
    } else {
        $stmt = $pdo->prepare("INSERT OR REPLACE INTO settings (`key`, `value`) VALUES (?, ?)");
    }

    foreach ($settings as $key => $val) {
        $stmt->execute([$key, $val]);
    }

    // 2. Default Admin
    $adminCount = $pdo->query("SELECT COUNT(*) FROM admins")->fetchColumn();
    if ($adminCount == 0) {
        $now = date('Y-m-d H:i:s');
        $adminStmt = $pdo->prepare("INSERT INTO admins (`username`, `password`, `name`, `email`, `role`, `created_at`) VALUES (?, ?, ?, ?, ?, ?)");
        $defaultPassword = password_hash('admin123', PASSWORD_DEFAULT);
        $adminStmt->execute(['admin', $defaultPassword, 'Administrator OMAHCODE', 'admin@omahcode.com', 'admin', $now]);
    }

    // 3. 8 Layanan Kami
    $servicesCount = $pdo->query("SELECT COUNT(*) FROM services")->fetchColumn();
    if ($servicesCount == 0) {
        $services = [
            [
                'title' => 'Website Sekolah & Pendidikan',
                'slug' => 'website-sekolah-pendidikan',
                'category' => 'Pendidikan',
                'short_desc' => 'Website resmi sekolah, madrasah, dan kampus dengan profil interaktif, PPDB online, galeri kegiatan, dan integrasi pengumuman.',
                'full_desc' => 'Membangun identitas digital lembaga pendidikan yang kredibel dan informatif. Dilengkapi fitur penerimaan peserta didik baru (PPDB), portal berita sekolah, data guru, serta integrasi media sosial.',
                'icon' => 'fa-solid fa-graduation-cap',
                'sort_order' => 1
            ],
            [
                'title' => 'Website Perusahaan & Bisnis',
                'slug' => 'website-perusahaan-profil-bisnis',
                'category' => 'Bisnis',
                'short_desc' => 'Company profile profesional berstandar korporat untuk meningkatkan reputasi brand, kepercayaan klien, dan kredibilitas bisnis.',
                'full_desc' => 'Desain elegan, responsif di seluruh gadget, dilengkapi company background, showcase layanan, portofolio proyek, dan integrasi WhatsApp konsultasi langsung.',
                'icon' => 'fa-solid fa-building',
                'sort_order' => 2
            ],
            [
                'title' => 'Website Instansi Pemerintahan',
                'slug' => 'website-instansi-pemerintahan',
                'category' => 'Pemerintahan',
                'short_desc' => 'Portal informasi publik transparan untuk dinas, kecamatan, kelurahan, dan kantor desa sesuai regulasi keterbukaan informasi.',
                'full_desc' => 'Menyajikan informasi regulasi, publikasi kegiatan kedinasan, layanan pengaduan masyarakat, serta standar aksesibilitas dan keamanan data teruji.',
                'icon' => 'fa-solid fa-landmark',
                'sort_order' => 3
            ],
            [
                'title' => 'Website UMKM & E-Commerce',
                'slug' => 'website-umkm-ecommerce',
                'category' => 'Bisnis dan UMKM',
                'short_desc' => 'Katalog produk digital dan toko online modern yang memudahkan konsumen melihat produk dan memesan langsung via WhatsApp.',
                'full_desc' => 'Membantu pelaku usaha lokal Cirebon dan sekitarnya memperluas pasar, menampilkan katalog foto produk menarik, dan integrasi hitung ongkir serta pembayaran.',
                'icon' => 'fa-solid fa-store',
                'sort_order' => 4
            ],
            [
                'title' => 'Sistem Informasi Manajemen',
                'slug' => 'sistem-informasi-manajemen',
                'category' => 'Sistem Informasi',
                'short_desc' => 'Pengembangan SIM custom untuk pengelolaan data internal, inventaris, absensi, kepegawaian, hingga pelaporan otomatis.',
                'full_desc' => 'Mendukung efisiensi operasional harian perusahaan atau instansi dengan sistem database terpusat, hak akses berjenjang, dan dashboard analitik.',
                'icon' => 'fa-solid fa-network-wired',
                'sort_order' => 5
            ],
            [
                'title' => 'Aplikasi Berbasis Web',
                'slug' => 'aplikasi-berbasis-web',
                'category' => 'Produktivitas',
                'short_desc' => 'Web application modern yang dapat diakses dari browser mana saja dengan kecepatan tinggi, aman, dan tanpa perlu instalasi rumit.',
                'full_desc' => 'Solusi software berbasis cloud untuk kolaborasi tim, workflow approvals, pemrosesan transaksi data, dan otomatisasi tugas berulang.',
                'icon' => 'fa-solid fa-laptop-code',
                'sort_order' => 6
            ],
            [
                'title' => 'Digitalisasi Administrasi',
                'slug' => 'digitalisasi-administrasi',
                'category' => 'Administrasi',
                'short_desc' => 'Transformasi proses administrasi manual menjadi paperless, mulai dari e-arsip surat, formulir digital, hingga verifikasi terpusat.',
                'full_desc' => 'Mengurangi risiko kehilangan dokumen fisik, mempercepat waktu pencarian berkas, dan mempermudah pelacakan disposisi tugas secara real-time.',
                'icon' => 'fa-solid fa-file-invoice',
                'sort_order' => 7
            ],
            [
                'title' => 'Custom Web Development',
                'slug' => 'custom-web-development',
                'category' => 'Custom',
                'short_desc' => 'Pengembangan fitur dan modul website khusus disesuaikan dengan kebutuhan spesifik dan alur bisnis unik institusi Anda.',
                'full_desc' => 'Konsultasikan ide dan arsitektur software Anda. Kami siap merancang dari perancangan skema database, API backend, hingga antarmuka pengguna responsif.',
                'icon' => 'fa-solid fa-code',
                'sort_order' => 8
            ]
        ];

        $now = date('Y-m-d H:i:s');
        $stmtService = $pdo->prepare("INSERT INTO services (`title`, `slug`, `category`, `short_desc`, `full_desc`, `icon`, `sort_order`, `is_active`, `created_at`) VALUES (?, ?, ?, ?, ?, ?, ?, 1, ?)");
        foreach ($services as $s) {
            $stmtService->execute([$s['title'], $s['slug'], $s['category'], $s['short_desc'], $s['full_desc'], $s['icon'], $s['sort_order'], $now]);
        }
    }

    // 4. Dynamic Digital Products Catalog
    $productsCount = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
    if ($productsCount == 0) {
        $now = date('Y-m-d H:i:s');
        $products = [
            [
                'name' => 'SIM-Sekolah Terpadu',
                'slug' => 'sim-sekolah-terpadu',
                'category' => 'Pendidikan',
                'description' => 'Platform terpadu pengelolaan data akademik sekolah, absensi harian siswa dan guru, sistem penilaian rapor digital, serta portal pengumuman.',
                'features' => "Manajemen Data Siswa & Guru\nPenilaian & Cetak Rapor Digital\nAbsensi Digital dengan QR Code\nPortal Berita & Agenda Sekolah",
                'target_users' => 'SD, SMP, SMA/SMK, Madrasah, & Yayasan Pendidikan',
                'demo_url' => 'https://demo.omahcode.com/sim-sekolah',
                'cta_text' => 'Demo Aplikasi',
                'image' => 'assets/img/portfolio/1.jpg',
                'sort_order' => 1
            ],
            [
                'name' => 'E-Arsip & Persuratan Kantor',
                'slug' => 'e-arsip-persuratan-kantor',
                'category' => 'Administrasi',
                'description' => 'Sistem digitalisasi persuratan kantor, disposisi surat masuk & keluar secara online, penomoran otomatis, dan penyimpanan berkas berbasis cloud aman.',
                'features' => "Penomoran Surat Otomatis\nAlur Disposisi Digital Berjenjang\nDigital Signature & Verifikasi Dokumen\nPencarian Berkas Instan & Audit Log",
                'target_users' => 'Instansi Pemerintahan, Kantor Perusahaan, & Lembaga Non-Profit',
                'demo_url' => 'https://demo.omahcode.com/e-arsip',
                'cta_text' => 'Akses Sistem',
                'image' => 'assets/img/portfolio/2.jpg',
                'sort_order' => 2
            ],
            [
                'name' => 'SmartDesa Portal & Pelayanan',
                'slug' => 'smartdesa-portal-pelayanan',
                'category' => 'Pemerintahan',
                'description' => 'Sistem informasi desa modern untuk pelayanan mandiri permohonan surat warga, basis data kependudukan terpadu, dan transparansi publik.',
                'features' => "Permohonan Surat Warga Online\nNotifikasi WhatsApp Status Surat\nDatabase Kependudukan & Bantuan Sosial\nWebsite Profil & Berita Desa Terpadu",
                'target_users' => 'Pemerintah Desa, Kelurahan, & Kantor Kecamatan',
                'demo_url' => 'https://demo.omahcode.com/smartdesa',
                'cta_text' => 'Demo Aplikasi',
                'image' => 'assets/img/portfolio/3.jpg',
                'sort_order' => 3
            ],
            [
                'name' => 'Katalog & Kasir UMKM Pro',
                'slug' => 'katalog-kasir-umkm-pro',
                'category' => 'Bisnis dan UMKM',
                'description' => 'Aplikasi kasir web responsif terintegrasi katalog online. Catat transaksi, stok persediaan, serta terima pesanan pelanggan langsung via WhatsApp.',
                'features' => "Point of Sale (POS) Cepat & Ringan\nKatalog Digital Siap Kirim ke Konsumen\nIntegrasi Pesanan Langsung ke WhatsApp\nLaporan Penjualan & Laba Rugi Otomatis",
                'target_users' => 'Pelaku UMKM, Retail, Kafe, Resto, & Toko Grosir',
                'demo_url' => 'https://demo.omahcode.com/pos-umkm',
                'cta_text' => 'Lihat Produk',
                'image' => 'assets/img/portfolio/4.jpg',
                'sort_order' => 4
            ]
        ];

        $stmtProd = $pdo->prepare("INSERT INTO products (`name`, `slug`, `category`, `description`, `features`, `target_users`, `demo_url`, `cta_text`, `image`, `sort_order`, `is_active`, `created_at`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, ?)");
        foreach ($products as $p) {
            $stmtProd->execute([$p['name'], $p['slug'], $p['category'], $p['description'], $p['features'], $p['target_users'], $p['demo_url'], $p['cta_text'], $p['image'], $p['sort_order'], $now]);
        }
    }

    // 5. Portofolio Proyek
    $portfolioCount = $pdo->query("SELECT COUNT(*) FROM portfolio")->fetchColumn();
    if ($portfolioCount == 0) {
        $now = date('Y-m-d H:i:s');
        $portfolios = [
            [
                'title' => 'Portal Akademik & PPDB Sekolah Terintegrasi',
                'category' => 'Website Sekolah',
                'client_name' => 'Lembaga Pendidikan di Cirebon',
                'description' => 'Pengembangan website resmi sekolah yang mengintegrasikan profil interaktif, pendaftaran siswa baru (PPDB) online, dan sistem pengumuman ujian.',
                'tech_stack' => 'PHP 8, Bootstrap 5, MySQL, jQuery',
                'project_url' => '#',
                'image' => 'assets/img/portfolio/5.jpg',
                'sort_order' => 1
            ],
            [
                'title' => 'Sistem Informasi Manajemen Logistik & Gudang',
                'category' => 'Sistem Informasi',
                'client_name' => 'Perusahaan Distribusi Jawa Barat',
                'description' => 'Aplikasi web internal untuk pelacakan pergerakan stok antar gudang, pembuatan surat jalan digital, dan monitoring inventaris real-time.',
                'tech_stack' => 'PHP, CodeIgniter, MySQL, DataTables',
                'project_url' => '#',
                'image' => 'assets/img/portfolio/6.jpg',
                'sort_order' => 2
            ],
            [
                'title' => 'Website Profil Perusahaan & Katalog Layanan',
                'category' => 'Profil Bisnis',
                'client_name' => 'PT Solusi Rekayasa Teknik',
                'description' => 'Desain dan pengembangan company profile responsif dengan performa cepat, SEO-friendly, dan integrasi WhatsApp konsultasi instan.',
                'tech_stack' => 'HTML5, Bootstrap, CSS3 Animations, PHP',
                'project_url' => '#',
                'image' => 'assets/img/portfolio/7.jpg',
                'sort_order' => 3
            ],
            [
                'title' => 'Platform E-Commerce & Katalog UMKM Kuliner Cirebon',
                'category' => 'Bisnis dan UMKM',
                'client_name' => 'Sentra Oleh-Oleh Khas Cirebon',
                'description' => 'Digitalisasi toko oleh-oleh lokal dengan fitur etalase produk, checkout WhatsApp terformat, dan peta lokasi gerai interaktif.',
                'tech_stack' => 'PHP, Bootstrap 5, SQLite, SwiperJS',
                'project_url' => '#',
                'image' => 'assets/img/portfolio/8.jpg',
                'sort_order' => 4
            ]
        ];

        $stmtPort = $pdo->prepare("INSERT INTO portfolio (`title`, `category`, `client_name`, `description`, `tech_stack`, `project_url`, `image`, `sort_order`, `is_active`, `created_at`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1, ?)");
        foreach ($portfolios as $p) {
            $stmtPort->execute([$p['title'], $p['category'], $p['client_name'], $p['description'], $p['tech_stack'], $p['project_url'], $p['image'], $p['sort_order'], $now]);
        }
    }
}
