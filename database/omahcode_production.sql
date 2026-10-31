-- OMAHCODE Full Database Dump for aaPanel Production
SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `settings` (`key`, `value`, `updated_at`) VALUES ('about_description', 'OMAHCODE merupakan developer dan penyedia layanan pengembangan website profesional yang berbasis di Cirebon, Indonesia. Kami hadir mendampingi sekolah, instansi pemerintahan, perusahaan, dan UMKM dalam merancang sistem informasi terstruktur, aplikasi web responsif, dan digitalisasi operasional yang siap mengakselerasi produktivitas kerja.', '2026-10-31 08:43:29');
INSERT INTO `settings` (`key`, `value`, `updated_at`) VALUES ('about_lead', 'Partner Digitalisasi dan Pengembangan Website Profesional di Cirebon.', '2026-10-31 08:43:29');
INSERT INTO `settings` (`key`, `value`, `updated_at`) VALUES ('about_title', 'Tentang OMAHCODE', '2026-10-31 08:43:29');
INSERT INTO `settings` (`key`, `value`, `updated_at`) VALUES ('contact_address', 'Jl. Pemuda No. 88, Kesambi, Kota Cirebon, Jawa Barat 45132', '2026-10-31 08:43:29');
INSERT INTO `settings` (`key`, `value`, `updated_at`) VALUES ('contact_email', 'halo@omahcode.com', '2026-10-31 08:43:29');
INSERT INTO `settings` (`key`, `value`, `updated_at`) VALUES ('contact_maps', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126748.56347862024!2d108.474272!3d-6.724734!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6ee2649e6e5b47%3A0x301e8f1fc28b8a0!2sKota%20Cirebon%2C%20Jawa%20Barat!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid', '2026-10-31 08:43:29');
INSERT INTO `settings` (`key`, `value`, `updated_at`) VALUES ('contact_phone', '+62 812-3456-7890', '2026-10-31 08:43:29');
INSERT INTO `settings` (`key`, `value`, `updated_at`) VALUES ('cta_button', 'Hubungi OMAHCODE Sekarang', '2026-10-31 08:43:29');
INSERT INTO `settings` (`key`, `value`, `updated_at`) VALUES ('cta_description', 'Diskusikan kebutuhan website dan sistem informasi Anda bersama OMAHCODE. Kami siap membantu menemukan solusi teknologi yang tepat.', '2026-10-31 08:43:29');
INSERT INTO `settings` (`key`, `value`, `updated_at`) VALUES ('cta_headline', 'Siap Mengembangkan Solusi Digital untuk Kebutuhan Anda?', '2026-10-31 08:43:29');
INSERT INTO `settings` (`key`, `value`, `updated_at`) VALUES ('hero_cta_primary', 'Konsultasikan Kebutuhan Anda', '2026-10-31 08:43:29');
INSERT INTO `settings` (`key`, `value`, `updated_at`) VALUES ('hero_cta_secondary', 'Jelajahi Solusi Kami', '2026-10-31 08:43:29');
INSERT INTO `settings` (`key`, `value`, `updated_at`) VALUES ('hero_headline', 'Solusi Digital untuk Mengembangkan Bisnis dan Institusi Anda.', '2026-10-31 08:43:29');
INSERT INTO `settings` (`key`, `value`, `updated_at`) VALUES ('hero_subheadline', 'OMAHCODE membantu sekolah, perusahaan, UMKM, dan instansi pemerintahan menghadirkan solusi digital melalui pengembangan website dan aplikasi yang inovatif, fungsional, serta sesuai kebutuhan.', '2026-10-31 08:43:29');
INSERT INTO `settings` (`key`, `value`, `updated_at`) VALUES ('meta_description', 'Jasa pembuatan website profesional di Cirebon. OMAHCODE melayani website sekolah, sistem informasi, profil perusahaan, UMKM, dan aplikasi web custom.', '2026-10-31 08:43:29');
INSERT INTO `settings` (`key`, `value`, `updated_at`) VALUES ('meta_keywords', 'jasa pembuatan website cirebon, developer website cirebon, jasa website sekolah, web sistem informasi, aplikasi web cirebon, omahcode', '2026-10-31 08:43:29');
INSERT INTO `settings` (`key`, `value`, `updated_at`) VALUES ('meta_title', 'OMAHCODE | Partner Digitalisasi & Jasa Pembuatan Website Profesional di Cirebon', '2026-10-31 08:43:29');
INSERT INTO `settings` (`key`, `value`, `updated_at`) VALUES ('site_favicon', 'assets/img/favicon.png', '2026-10-31 08:44:18');
INSERT INTO `settings` (`key`, `value`, `updated_at`) VALUES ('site_icon', 'assets/img/omahcode-icon.png', '2026-10-31 08:44:18');
INSERT INTO `settings` (`key`, `value`, `updated_at`) VALUES ('site_logo', 'assets/img/omahcode-logo.png', '2026-10-31 08:44:18');
INSERT INTO `settings` (`key`, `value`, `updated_at`) VALUES ('site_name', 'OMAHCODE', '2026-10-31 08:43:29');
INSERT INTO `settings` (`key`, `value`, `updated_at`) VALUES ('site_positioning', 'Partner Digitalisasi & Pengembangan Website Profesional di Cirebon', '2026-10-31 08:43:29');
INSERT INTO `settings` (`key`, `value`, `updated_at`) VALUES ('site_tagline', 'Solusi Digital untuk Setiap Kebutuhan.', '2026-10-31 08:43:29');
INSERT INTO `settings` (`key`, `value`, `updated_at`) VALUES ('social_facebook', 'https://facebook.com/omahcode', '2026-10-31 08:43:29');
INSERT INTO `settings` (`key`, `value`, `updated_at`) VALUES ('social_github', 'https://github.com/omahcode', '2026-10-31 08:43:29');
INSERT INTO `settings` (`key`, `value`, `updated_at`) VALUES ('social_instagram', 'https://instagram.com/omahcode', '2026-10-31 08:43:29');
INSERT INTO `settings` (`key`, `value`, `updated_at`) VALUES ('social_linkedin', 'https://linkedin.com/company/omahcode', '2026-10-31 08:43:29');
INSERT INTO `settings` (`key`, `value`, `updated_at`) VALUES ('whatsapp_message', 'Halo OMAHCODE, saya ingin berkonsultasi mengenai kebutuhan website / sistem aplikasi digital.', '2026-10-31 08:43:29');
INSERT INTO `settings` (`key`, `value`, `updated_at`) VALUES ('whatsapp_number', '6281234567890', '2026-10-31 08:43:29');
INSERT INTO `settings` (`key`, `value`, `updated_at`) VALUES ('why_headline', 'Mengapa Memilih OMAHCODE?', '2026-10-31 08:43:29');
INSERT INTO `settings` (`key`, `value`, `updated_at`) VALUES ('why_subheadline', 'Kami mengutamakan kualitas arsitektur software, estetika desain modern, kemudahan penggunaan, dan keberlanjutan sistem.', '2026-10-31 08:43:29');
INSERT INTO `settings` (`key`, `value`, `updated_at`) VALUES ('workflow_headline', 'Alur Kerja Profesional Kami', '2026-10-31 08:43:29');
INSERT INTO `settings` (`key`, `value`, `updated_at`) VALUES ('workflow_subheadline', 'Tahapan terstruktur dari analisis kebutuhan hingga peluncuran dan pemeliharaan jangka panjang.', '2026-10-31 08:43:29');

DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'admin',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `admins` (`id`, `username`, `password`, `name`, `email`, `role`, `created_at`, `updated_at`) VALUES ('1', 'admin', '$2y$10$0qHoMTHCeIfdqPm3U34WQulX1osuynq0xtFcE9GEVo7NX9JLO50XC', 'Administrator OMAHCODE', 'admin@omahcode.com', 'admin', '2026-10-31 01:43:29', '2026-10-31 10:19:43');

DROP TABLE IF EXISTS `services`;
CREATE TABLE `services` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_desc` text COLLATE utf8mb4_unicode_ci,
  `full_desc` longtext COLLATE utf8mb4_unicode_ci,
  `icon` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT 'fa-solid fa-laptop-code',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `services` (`id`, `title`, `slug`, `category`, `short_desc`, `full_desc`, `icon`, `image`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('2', 'Website Perusahaan & Bisnis', 'website-perusahaan-profil-bisnis', 'Bisnis', 'Company profile profesional berstandar korporat untuk meningkatkan reputasi brand, kepercayaan klien, dan kredibilitas bisnis.', 'Desain elegan, responsif di seluruh gadget, dilengkapi company background, showcase layanan, portofolio proyek, dan integrasi WhatsApp konsultasi langsung.', 'fa-solid fa-building', NULL, '2', '1', '2026-10-31 01:43:29', '2026-10-31 08:52:39');
INSERT INTO `services` (`id`, `title`, `slug`, `category`, `short_desc`, `full_desc`, `icon`, `image`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('3', 'Website Instansi Pemerintahan', 'website-instansi-pemerintahan', 'Pemerintahan', 'Portal informasi publik transparan untuk dinas, kecamatan, kelurahan, dan kantor desa sesuai regulasi keterbukaan informasi.', 'Menyajikan informasi regulasi, publikasi kegiatan kedinasan, layanan pengaduan masyarakat, serta standar aksesibilitas dan keamanan data teruji.', 'fa-solid fa-landmark', NULL, '3', '1', '2026-10-31 01:43:29', '2026-10-31 08:43:29');
INSERT INTO `services` (`id`, `title`, `slug`, `category`, `short_desc`, `full_desc`, `icon`, `image`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('4', 'Website UMKM & E-Commerce', 'website-umkm-ecommerce', 'Bisnis dan UMKM', 'Katalog produk digital dan toko online modern yang memudahkan konsumen melihat produk dan memesan langsung via WhatsApp.', 'Membantu pelaku usaha lokal Cirebon dan sekitarnya memperluas pasar, menampilkan katalog foto produk menarik, dan integrasi hitung ongkir serta pembayaran.', 'fa-solid fa-store', NULL, '4', '1', '2026-10-31 01:43:29', '2026-10-31 08:43:29');
INSERT INTO `services` (`id`, `title`, `slug`, `category`, `short_desc`, `full_desc`, `icon`, `image`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('5', 'Sistem Informasi Manajemen', 'sistem-informasi-manajemen', 'Sistem Informasi', 'Pengembangan SIM custom untuk pengelolaan data internal, inventaris, absensi, kepegawaian, hingga pelaporan otomatis.', 'Mendukung efisiensi operasional harian perusahaan atau instansi dengan sistem database terpusat, hak akses berjenjang, dan dashboard analitik.', 'fa-solid fa-network-wired', NULL, '5', '1', '2026-10-31 01:43:29', '2026-10-31 08:43:29');
INSERT INTO `services` (`id`, `title`, `slug`, `category`, `short_desc`, `full_desc`, `icon`, `image`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('6', 'Aplikasi Berbasis Web', 'aplikasi-berbasis-web', 'Produktivitas', 'Web application modern yang dapat diakses dari browser mana saja dengan kecepatan tinggi, aman, dan tanpa perlu instalasi rumit.', 'Solusi software berbasis cloud untuk kolaborasi tim, workflow approvals, pemrosesan transaksi data, dan otomatisasi tugas berulang.', 'fa-solid fa-laptop-code', NULL, '6', '1', '2026-10-31 01:43:29', '2026-10-31 08:43:29');
INSERT INTO `services` (`id`, `title`, `slug`, `category`, `short_desc`, `full_desc`, `icon`, `image`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('7', 'Digitalisasi Administrasi', 'digitalisasi-administrasi', 'Administrasi', 'Transformasi proses administrasi manual menjadi paperless, mulai dari e-arsip surat, formulir digital, hingga verifikasi terpusat.', 'Mengurangi risiko kehilangan dokumen fisik, mempercepat waktu pencarian berkas, dan mempermudah pelacakan disposisi tugas secara real-time.', 'fa-solid fa-file-invoice', NULL, '7', '1', '2026-10-31 01:43:29', '2026-10-31 08:43:29');

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `features` longtext COLLATE utf8mb4_unicode_ci,
  `target_users` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `demo_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cta_text` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'Demo Aplikasi',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `portfolio`;
CREATE TABLE `portfolio` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_name` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `tech_stack` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'new',
  `ip_address` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


SET FOREIGN_KEY_CHECKS=1;
