# OMAHCODE - Website Landing Page Profesional & CMS Admin Panel

**Partner Digitalisasi dan Pengembangan Website Profesional di Cirebon**  
*Tagline: "Solusi Digital untuk Setiap Kebutuhan."*

---

## 📌 1. Deskripsi Proyek

Website resmi dan sistem manajemen konten (CMS) untuk **OMAHCODE**, pengembang website dan solusi digital terpercaya di Cirebon, Jawa Barat. Aplikasi ini dibangun dengan standar arsitektur profesional, mengintegrasikan frontend responsif modern berbasis template **Markia**, backend modular PHP 8, dan database fleksibel (SQLite bawaan plug-and-play dan MySQL/MariaDB siap pakai untuk Laragon/cPanel).

Seluruh konten website (produk digital, layanan, portofolio, informasi perusahaan, nomor WhatsApp, email, dan SEO) dapat dikelola langsung melalui Admin Dashboard tanpa perlu mengubah kode sumber (*zero code changes*).

---

## 🚀 2. Fitur Utama

### A. Landing Page Publik (`index.php`)
- **Sticky Navbar & Mobile Menu**: Responsif dengan hamburger menu dan tombol cepat konsultasi WhatsApp.
- **Hero Banner Modern**: Headline representatif, badge positioning Cirebon, tombol konsultasi WhatsApp, dan ilustrasi teknologi digital.
- **Tentang Kami**: Mengulas 5 fokus utama transformasi digital (Website Profesional, Digitalisasi Administrasi, SIM, Solusi Kebutuhan Klien, & Dukungan Berkelanjutan).
- **Layanan Kami**: 8 kategori layanan dalam bentuk modern card yang terhubung ke pesan otomatis WhatsApp per layanan.
- **Katalog Produk Digital Dinamis**: Filter kategori instan (Pendidikan, Administrasi, Pemerintahan, Bisnis & UMKM, Sistem Informasi), badge target pengguna, fitur utama, dan tombol akses/demo aplikasi.
- **Mengapa Memilih OMAHCODE?**: 6 nilai keunggulan arsitektur dan komitmen layanan.
- **Portofolio Proyek**: Showcase proyek dengan teknologi stack, nama instansi, screenshot, dan URL demo.
- **Alur Kerja Terstruktur**: Timeline 6 tahap dari konsultasi kebutuhan hingga implementasi dan pemeliharaan.
- **Formulir Kontak Terintegrasi**: Form inquiry langsung menyimpan ke database admin dengan validasi, proteksi honeypot anti-spam, CSRF token, dan feedback AJAX.
- **Floating WhatsApp Quick Action**: Tombol melayang di pojok kanan bawah dengan tooltip konsultasi.
- **Optimasi SEO & Core Web Vitals**: Meta tags, Open Graph, Twitter Cards, Schema.org LocalBusiness JSON-LD, Sitemap XML, dan Robots.txt.

### B. Admin Dashboard & CMS (`/admin`)
- **Autentikasi Aman**: Login berbasis session, CSRF token, password hashing (`PASSWORD_DEFAULT`), dan proteksi brute-force.
- **Dashboard Overview**: Metrik ringkasan (Total Produk, Layanan, Portofolio, Pesan Masuk), jalan pintas aksi cepat, dan tabel inquiry terbaru.
- **Manajemen Produk Digital**: Tambah, edit, hapus, unggah thumbnail/mockup, atur target pengguna, URL demo, tombol teks aksi, urutan, dan 1-click aktifkan/nonaktifkan status.
- **Manajemen Layanan**: Tambah, ubah, hapus layanan dengan pemilihan icon FontAwesome dan urutan.
- **Manajemen Portofolio**: Upload screenshot hasil karya, tentukan tech stack, URL klien, dan kategori.
- **Manajemen Pesan Masuk**: Filter status pesan (*Baru*, *Sudah Dibaca*, *Ditindaklanjuti*), tombol balas langsung via WhatsApp (pesan terformat otomatis), balas via Email, dan hapus pesan.
- **Pengaturan Website Global**: Ubah nama, logo, favicon, headline hero, deskripsi, alamat Cirebon, Google Maps embed, nomor WhatsApp, email resmi, tautan media sosial, serta meta title/description SEO.
- **Manajemen Akun Admin**: Ganti username, nama, email, dan ganti password dengan verifikasi password lama.

---

## 📂 3. Struktur Direktori Proyek

```text
omahcode/
├── .env                     # Konfigurasi aktif lingkungan aplikasi
├── .env.example             # Contoh template konfigurasi environment
├── .htaccess                # Konfigurasi Apache: routing /admin, proteksi file, gzip & cache
├── contact_process.php      # Handler backend formulir kontak (AJAX & CSRF)
├── index.php                # Landing page utama publik OMAHCODE
├── README.md                # Dokumentasi lengkap proyek
├── robots.txt               # Petunjuk perayap mesin pencari
├── sitemap.xml              # Peta situs SEO XML
├── style.css                # Styling utama template
│
├── admin/                   # Modul Admin Dashboard & CMS
│   ├── includes/
│   │   ├── header.php       # Navigasi atas, sidebar menu, badge counters
│   │   └── footer.php       # Skrip universal, konfirmasi hapus, modal
│   ├── index.php            # Dashboard overview & ringkasan statistik
│   ├── login.php            # Halaman login administrator yang aman
│   ├── logout.php           # Handler logout & penghapusan sesi
│   ├── messages.php         # Kotak masuk pesan & tindak lanjut konsultasi
│   ├── portfolio.php        # Daftar portofolio proyek
│   ├── portfolio_form.php   # Form tambah & edit portofolio (upload gambar)
│   ├── products.php         # Daftar katalog produk digital OMAHCODE
│   ├── product_form.php     # Form tambah & edit produk digital (fitur, link, upload)
│   ├── profile.php          # Pengaturan profil admin & ubah password
│   ├── services.php         # Daftar layanan OMAHCODE
│   ├── service_form.php     # Form tambah & edit layanan (icon selector)
│   └── settings.php         # CMS pengaturan identitas, kontak, hero, & SEO
│
├── assets/                  # Aset statis bawaan template Markia
│   ├── css/                 # Bootstrap, FontAwesome, Swiper, Animations, ValidNavs
│   ├── fonts/               # Webfonts & FontAwesome icons
│   ├── img/                 # Ilustrasi, banner, ikon, shape, mockup
│   │   ├── illustration/    # Ilustrasi digital high-tech
│   │   └── portfolio/       # Gambar placeholder proyek
│   └── js/                  # jQuery, Bootstrap bundle, Isotope, WOW.js, main.js
│
├── config/                  # Konfigurasi & Core Engine
│   ├── database.php         # Koneksi PDO (SQLite + MySQL) & auto-seeding
│   └── helpers.php          # Sanitasi XSS, CSRF, auth guard, upload handler, WA URL
│
├── database/                # Skema Database & Data
│   ├── omahcode.sqlite      # Database SQLite terisi (siap pakai tanpa konfigurasi)
│   ├── schema.sql           # Skema SQL standar (SQLite compatible)
│   └── mysql_schema.sql     # Skema SQL native MySQL/MariaDB (Laragon / phpMyAdmin)
│
├── template/                # Salinan asli Markia v1.0 (arsip aset & dokumentasi)
│
└── uploads/                 # Folder penyimpanan file yang diunggah via CMS
    ├── portfolio/           # Screenshot proyek portofolio
    ├── products/            # Mockup & logo produk digital
    └── site/                # Logo dan favicon kustom
```

---

## 🗄️ 4. Struktur Database & Skema

Database terdiri dari 6 tabel yang dirancang efisien dan terindeks:

1. **`settings`**: Menyimpan seluruh konfigurasi dinamis (hero, kontak WhatsApp, email, alamat Cirebon, SEO, link sosial).
2. **`admins`**: Data administrator terotentikasi dengan password bcrypt.
3. **`products`**: Katalog produk digital (nama, kategori, fitur, target pengguna, demo URL, thumbnail, urutan, status).
4. **`services`**: Daftar layanan kami (judul, ringkasan, deskripsi, icon class, urutan, status).
5. **`portfolio`**: Riwayat proyek (nama proyek, kategori, instansi/klien, tech stack, URL, screenshot).
6. **`messages`**: Pesan inquiry dari landing page (nama, email, no HP, subjek, isi pesan, status tindak lanjut, IP address, waktu).

> **Catatan Driver Database:**
> Aplikasi secara penuh menggunakan **MySQL** (`127.0.0.1:3306`, DB: `omahcode`, User: `root`).
> Database ini langsung terhubung dengan layanan MySQL bawaan Laragon dan seluruh skema + seed data telah aktif.
> File skema SQL native MySQL tersedia di `database/mysql_schema.sql`. (Tersedia juga fallback SQLite di `database/omahcode.sqlite`).

---

## 💻 5. Panduan Instalasi & Menjalankan Aplikasi

### Opsi A: Menggunakan Laragon (Rekomendasi Localhost)
1. Karena folder proyek sudah berada di `C:\laragon\www\omahcode`, buka aplikasi **Laragon**.
2. Klik tombol **"Start All"** di Laragon untuk menyalakan Apache / Nginx dan MySQL.
3. Buka browser dan akses alamat:
   ```text
   http://localhost/omahcode/
   ```
4. Website langsung tampil sempurna dengan seluruh data awal.

### Opsi B: Menggunakan PHP Built-in Server
Jika ingin menjalankan tanpa menyalakan Apache/Laragon, buka PowerShell atau Command Prompt di folder proyek:
```powershell
cd C:\laragon\www\omahcode
php -S localhost:8000
```
Buka browser pada: `http://localhost:8000`

---

## 🔐 6. Panduan Akses Admin Dashboard

1. Akses halaman login admin melalui URL:
   ```text
   http://localhost/omahcode/admin/
   ```
2. Masukkan kredensial login bawaan:
   - **Username**: `admin`
   - **Password**: `admin123`
3. Setelah login, Anda akan diarahkan ke **Dashboard Overview**.
4. Disarankan untuk segera mengganti password di menu **Akun Admin** (`/admin/profile.php`).

---

## 📱 7. Panduan Mengelola Produk Digital OMAHCODE

1. Buka menu **Produk Digital** di panel navigasi admin (`/admin/products.php`).
2. **Menambah Produk Baru**:
   - Klik tombol **"+ Tambah Produk Baru"**.
   - Masukkan **Nama Produk** (contoh: *SIM-Sekolah Terpadu*).
   - Pilih **Kategori** (Pendidikan, Administrasi, Pemerintahan, Bisnis & UMKM, Sistem Informasi).
   - Tuliskan **Deskripsi** singkat mengenai manfaat produk.
   - Pada kolom **Fitur Utama**, masukkan fitur satu baris per poin (otomatis terformat checklist).
   - Masukkan **Target Pengguna** (contoh: *SMA/SMK dan Lembaga Kursus*).
   - Masukkan **URL Demo / Aplikasi** (contoh: *https://demo.omahcode.com/...*). Jika dikosongkan, tombol akan mengarahkan otomatis ke WhatsApp konsultasi.
   - Tentukan **Teks Tombol Aksi** (misal: *Demo Aplikasi*, *Lihat Produk*, *Akses Sistem*).
   - Unggah **Thumbnail / Mockup Gambar** (format JPG/PNG/WEBP).
   - Tentukan **Urutan Tampilan** (angka 1, 2, dst).
   - Centang opsi **Aktifkan**.
   - Klik **"Simpan Produk Digital"**.
3. **Mengubah / Menonaktifkan Produk**:
   - Anda dapat menonaktifkan produk kapan saja dengan sekali klik pada tombol badge status **"Aktif"** tanpa menghapus data.
   - Klik tombol **Edit (ikon pensil)** untuk memperbarui tautan demo atau deskripsi fitur.

---

## 🌐 8. Panduan Deployment ke Live Server (cPanel / VPS)

### Deployment ke Shared Hosting (cPanel):
1. Compress seluruh isi folder `omahcode` (kecuali folder `template/` jika ingin menghemat kapasitas) menjadi file `.zip`.
2. Buka **cPanel** -> **File Manager** -> masuk ke direktori `public_html` (atau subdomain).
3. Upload dan ekstrak file `.zip`.
4. Pastikan file `.env` memiliki izin baca (permission 644) dan folder `uploads/` serta `database/` memiliki izin tulis (permission 755 atau 775).
5. Buka file `.env` di File Manager:
   - Sesuaikan `APP_URL=https://namadomainanda.com`
   - Jika ingin menggunakan MySQL:
     - Buat database dan user baru di cPanel MySQL Databases.
     - Impor file `database/mysql_schema.sql` via **phpMyAdmin**.
     - Ubah di `.env`:
       ```ini
       DB_CONNECTION=mysql
       DB_HOST=localhost
       DB_DATABASE=nama_database_anda
       DB_USERNAME=user_database_anda
       DB_PASSWORD=password_database_anda
       ```
6. Buka domain Anda di browser. Website OMAHCODE telah live dan siap digunakan!

---

## 🛡️ 9. Keamanan & Kepatuhan Teknis
- **Cross-Site Scripting (XSS)**: Seluruh output dinamis dilindungi menggunakan fungsi `e()` (`htmlspecialchars` dengan UTF-8).
- **SQL Injection**: Seluruh query interaksi database menggunakan PDO Prepared Statements dengan parameter binding.
- **Cross-Site Request Forgery (CSRF)**: Semua pengiriman formulir (kontak dan formulir admin) dilindungi verifikasi token acak `csrf_token()`.
- **Anti-Spam Honeypot**: Formulir kontak dilengkapi field tersembunyi untuk menangkal spam bot otomatis.
- **Proteksi Berkas Sensitif**: File `.env`, `.sqlite`, dan folder `config/` diblokir akses langsungnya oleh aturan Apache di `.htaccess`.

