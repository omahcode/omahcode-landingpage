<?php
/**
 * OMAHCODE - Contact Form Submission Handler
 * Compatible with MySQL and SQLite
 */

require_once __DIR__ . '/config/helpers.php';

init_session();

$isAjax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') ||
          (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false);

function respond($success, $message, $isAjax, $redirectAnchor = 'kontak') {
    if ($isAjax) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success' => $success,
            'message' => $message
        ]);
        exit;
    } else {
        flash_set($success ? 'success' : 'danger', $message);
        header("Location: " . base_url('#' . $redirectAnchor));
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond(false, 'Metode pengiriman formulir tidak valid.', $isAjax);
}

// 1. Anti-spam honeypot check
if (!empty($_POST['website_hp'])) {
    respond(false, 'Terjadi kesalahan sistem pengiriman.', $isAjax);
}

// 2. CSRF Token verification
$token = $_POST['csrf_token'] ?? '';
if (empty($token) || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
    respond(false, 'Sesi formulir kadaluarsa. Silakan refresh halaman dan coba kirim kembali.', $isAjax);
}

// 3. Extract and sanitize inputs
$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$phone   = trim($_POST['phone'] ?? '');
$subject = trim($_POST['subject'] ?? 'Pertanyaan dari Website OMAHCODE');
$message = trim($_POST['message'] ?? '');
$ip      = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

// 4. Validations
if (empty($name) || mb_strlen($name) < 2) {
    respond(false, 'Silakan masukkan nama lengkap Anda (minimal 2 karakter).', $isAjax);
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    respond(false, 'Silakan masukkan alamat email yang valid.', $isAjax);
}

if (empty($message) || mb_strlen($message) < 5) {
    respond(false, 'Silakan tuliskan pesan atau rincian kebutuhan Anda (minimal 5 karakter).', $isAjax);
}

// 5. Rate limiting: 1 message per 30 seconds per IP (Universal PHP timestamp)
$pdo = get_db();
$cutoff = date('Y-m-d H:i:s', time() - 30);
$checkRate = $pdo->prepare("SELECT COUNT(*) FROM messages WHERE ip_address = ? AND created_at > ?");
$checkRate->execute([$ip, $cutoff]);
if ($checkRate->fetchColumn() > 0) {
    respond(false, 'Anda telah mengirim pesan baru-baru ini. Mohon tunggu beberapa detik sebelum mengirim kembali.', $isAjax);
}

// 6. Save message to database
try {
    $now = date('Y-m-d H:i:s');
    $stmt = $pdo->prepare("INSERT INTO messages (`name`, `email`, `phone`, `subject`, `message`, `status`, `ip_address`, `created_at`) VALUES (?, ?, ?, ?, ?, 'new', ?, ?)");
    $stmt->execute([$name, $email, $phone, $subject, $message, $ip, $now]);

    respond(true, 'Terima kasih telah menghubungi OMAHCODE! Pesan Anda berhasil terkirim. Tim kami akan segera menindaklanjuti pesan Anda.', $isAjax);
} catch (Exception $e) {
    error_log("Contact form error: " . $e->getMessage());
    respond(false, 'Maaf, terjadi kendala saat menyimpan pesan Anda. Silakan hubungi kami langsung via WhatsApp.', $isAjax);
}
