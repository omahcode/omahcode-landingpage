<?php
/**
 * OMAHCODE - General Helpers & Security Functions
 */

require_once __DIR__ . '/database.php';

function init_session() {
    if (!ob_get_level()) {
        ob_start();
    }
    if (session_status() === PHP_SESSION_NONE) {
        // Secure session parameters
        ini_set('session.cookie_httponly', '1');
        ini_set('session.use_only_cookies', '1');
        session_start();
    }
}

/**
 * Escape HTML output for XSS prevention
 */
function e($value) {
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
}

/**
 * Base URL detection
 */
function base_url($path = '') {
    $envUrl = env('APP_URL');
    if ($envUrl) {
        $base = rtrim($envUrl, '/');
    } else {
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $script = $_SERVER['SCRIPT_NAME'] ?? '';
        $dir = str_replace('\\', '/', dirname($script));
        // Remove /admin if running inside admin subfolder
        $dir = preg_replace('#/admin.*$#', '', $dir);
        $dir = rtrim($dir, '/');
        $base = $scheme . '://' . $host . $dir;
    }
    
    $path = ltrim($path, '/');
    return $path !== '' ? $base . '/' . $path : $base;
}

/**
 * Asset URL helper
 */
function asset($path) {
    return base_url($path);
}

/**
 * Settings cache and getter
 */
function get_setting($key, $default = '') {
    static $settingsCache = null;
    if ($settingsCache === null) {
        $settingsCache = [];
        try {
            $pdo = get_db();
            $stmt = $pdo->query("SELECT `key`, `value` FROM settings");
            while ($row = $stmt->fetch()) {
                $settingsCache[$row['key']] = $row['value'];
            }
        } catch (Exception $e) {
            error_log("Failed to load settings: " . $e->getMessage());
        }
    }
    return $settingsCache[$key] ?? $default;
}

/**
 * Set a setting in DB and refresh cache
 */
function set_setting($key, $value) {
    $pdo = get_db();
    $stmt = $pdo->prepare("REPLACE INTO settings (`key`, `value`) VALUES (?, ?)");
    $stmt->execute([$key, $value]);
}

/**
 * WhatsApp URL Generator
 */
function get_whatsapp_url($customMessage = null) {
    $phone = get_setting('whatsapp_number', '6281234567890');
    // Sanitize phone: keep only numbers
    $phone = preg_replace('/[^0-9]/', '', $phone);
    // If starts with 08..., convert to 628...
    if (str_starts_with($phone, '08')) {
        $phone = '628' . substr($phone, 2);
    }

    $message = $customMessage ?? get_setting('whatsapp_message', 'Halo OMAHCODE, saya ingin berkonsultasi mengenai solusi website dan aplikasi digital.');
    return "https://wa.me/{$phone}?text=" . urlencode($message);
}

/**
 * Authentic Official WhatsApp SVG Icon (Guaranteed not flipped/inverted)
 */
function svg_wa($size = '20px', $color = 'currentColor', $class = '') {
    if (is_numeric($size)) {
        $size = $size . 'px';
    }
    return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="' . $size . '" height="' . $size . '" fill="' . $color . '" class="' . $class . '" style="vertical-align: -0.2em; display: inline-block;"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.414-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>';
}

/**
 * CSRF Protection
 */
function csrf_token() {
    init_session();
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field() {
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function verify_csrf() {
    init_session();
    $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
    if (empty($token) || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        http_response_code(403);
        die("Invalid CSRF token. Silakan refresh halaman dan coba kembali.");
    }
}

/**
 * Flash messaging
 */
function flash_set($type, $message) {
    init_session();
    $_SESSION['flash'] = [
        'type' => $type, // success, danger, warning, info
        'message' => $message
    ];
}

function flash_get() {
    init_session();
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

/**
 * Auth Helpers
 */
function is_admin_logged_in() {
    init_session();
    return !empty($_SESSION['admin_logged_in']) && !empty($_SESSION['admin_id']);
}

function require_admin() {
    if (!is_admin_logged_in()) {
        header("Location: " . base_url('admin/login.php'));
        exit;
    }
}

function get_admin_user() {
    if (!is_admin_logged_in()) {
        return null;
    }
    return [
        'id' => $_SESSION['admin_id'] ?? null,
        'username' => $_SESSION['admin_username'] ?? '',
        'name' => $_SESSION['admin_name'] ?? 'Admin',
        'email' => $_SESSION['admin_email'] ?? '',
        'role' => $_SESSION['admin_role'] ?? 'admin'
    ];
}

/**
 * Secure file upload helper
 */
function handle_file_upload($fileArray, $subfolder = 'uploads', $allowedExts = ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif', 'ico']) {
    if (!isset($fileArray['error']) || $fileArray['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'error' => 'Tidak ada file yang diunggah atau terjadi kesalahan upload.'];
    }

    // Limit size: 5MB
    $maxSize = 5 * 1024 * 1024;
    if ($fileArray['size'] > $maxSize) {
        return ['success' => false, 'error' => 'Ukuran file melebihi batas maksimal (5MB).'];
    }

    $ext = strtolower(pathinfo($fileArray['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExts)) {
        return ['success' => false, 'error' => 'Format file tidak didukung. Gunakan JPG, PNG, WEBP, atau SVG.'];
    }

    // Check MIME type
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($fileArray['tmp_name']);
    $validMimes = [
        'image/jpeg', 'image/png', 'image/webp', 'image/svg+xml', 'image/gif', 
        'image/x-icon', 'image/vnd.microsoft.icon', 'text/plain', 'text/xml'
    ];

    if (!in_array($mime, $validMimes) && $ext !== 'ico') {
        return ['success' => false, 'error' => 'Tipe MIME file tidak valid.'];
    }

    $targetDir = ROOT_PATH . '/' . trim($subfolder, '/');
    if (!is_dir($targetDir)) {
        @mkdir($targetDir, 0755, true);
    }

    $newFileName = uniqid('omah_', true) . '.' . $ext;
    $targetPath = $targetDir . '/' . $newFileName;

    if (move_uploaded_file($fileArray['tmp_name'], $targetPath)) {
        $relativePath = trim($subfolder, '/') . '/' . $newFileName;
        return ['success' => true, 'path' => $relativePath, 'filename' => $newFileName];
    }

    return ['success' => false, 'error' => 'Gagal memindahkan file yang diunggah. Periksa permission folder.'];
}

/**
 * Generate slug
 */
function slugify($text) {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    return empty($text) ? 'n-a' : $text;
}

