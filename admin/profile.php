<?php
/**
 * OMAHCODE - Admin Profile & Password Management
 */

require_once __DIR__ . '/../config/helpers.php';
require_admin();

$pdo = get_db();
$adminId = $_SESSION['admin_id'];

$stmt = $pdo->prepare("SELECT * FROM admins WHERE id = ?");
$stmt->execute([$adminId]);
$admin = $stmt->fetch();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $action = $_POST['action'] ?? '';

    if ($action === 'update_profile') {
        $name     = trim($_POST['name'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $email    = trim($_POST['email'] ?? '');

        if (empty($name) || empty($username)) {
            $error = 'Nama dan username wajib diisi.';
        } else {
            // Check username uniqueness
            $checkUser = $pdo->prepare("SELECT COUNT(*) FROM admins WHERE username = ? AND id != ?");
            $checkUser->execute([$username, $adminId]);
            if ($checkUser->fetchColumn() > 0) {
                $error = 'Username sudah digunakan oleh akun lain.';
            } else {
                $up = $pdo->prepare("UPDATE admins SET name = ?, username = ?, email = ?, updated_at = NOW() WHERE id = ?");
                $up->execute([$name, $username, $email, $adminId]);

                $_SESSION['admin_name'] = $name;
                $_SESSION['admin_username'] = $username;
                $_SESSION['admin_email'] = $email;

                flash_set('success', 'Profil administrator berhasil diperbarui.');
                header("Location: profile.php");
                exit;
            }
        }
    } elseif ($action === 'change_password') {
        $currentPass = $_POST['current_password'] ?? '';
        $newPass     = $_POST['new_password'] ?? '';
        $confirmPass = $_POST['confirm_password'] ?? '';

        if (empty($currentPass) || empty($newPass) || empty($confirmPass)) {
            $error = 'Semua bidang password wajib diisi.';
        } elseif (!password_verify($currentPass, $admin['password'])) {
            $error = 'Password saat ini yang Anda masukkan salah.';
        } elseif (strlen($newPass) < 6) {
            $error = 'Password baru minimal harus 6 karakter.';
        } elseif ($newPass !== $confirmPass) {
            $error = 'Konfirmasi password baru tidak cocok.';
        } else {
            $newHashed = password_hash($newPass, PASSWORD_DEFAULT);
            $up = $pdo->prepare("UPDATE admins SET password = ?, updated_at = NOW() WHERE id = ?");
            $up->execute([$newHashed, $adminId]);

            flash_set('success', 'Password administrator berhasil diubah.');
            header("Location: profile.php");
            exit;
        }
    }
}

$pageTitle = 'Akun Administrator';
require_once __DIR__ . '/includes/header.php';
?>

<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="font-weight-bold text-dark mb-1">Pengaturan Akun Administrator</h4>
        <p class="text-muted font-size-14 mb-0">Kelola informasi profil admin dan perbarui kredensial keamanan akun.</p>
    </div>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger rounded-3 mb-4">
        <i class="fa-solid fa-triangle-exclamation me-2"></i> <?= e($error) ?>
    </div>
<?php endif; ?>

<div class="row g-4">
    <!-- Edit Profil Admin -->
    <div class="col-lg-6">
        <div class="admin-card h-100">
            <h5 class="font-weight-bold text-dark mb-3 border-bottom pb-2">
                <i class="fa-solid fa-user text-primary me-2"></i>Informasi Profil
            </h5>
            <form method="POST" action="">
                <?= csrf_field() ?>
                <input type="hidden" name="action" value="update_profile">

                <div class="mb-3">
                    <label class="form-label font-weight-bold font-size-14">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" value="<?= e($admin['name']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label font-weight-bold font-size-14">Username</label>
                    <input type="text" name="username" class="form-control" value="<?= e($admin['username']) ?>" required>
                </div>

                <div class="mb-4">
                    <label class="form-label font-weight-bold font-size-14">Alamat Email</label>
                    <input type="email" name="email" class="form-control" value="<?= e($admin['email']) ?>">
                </div>

                <button type="submit" class="btn btn-primary-admin px-4 py-2">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan Profil
                </button>
            </form>
        </div>
    </div>

    <!-- Ganti Password -->
    <div class="col-lg-6">
        <div class="admin-card h-100">
            <h5 class="font-weight-bold text-dark mb-3 border-bottom pb-2">
                <i class="fa-solid fa-key text-warning me-2"></i>Ganti Password
            </h5>
            <form method="POST" action="">
                <?= csrf_field() ?>
                <input type="hidden" name="action" value="change_password">

                <div class="mb-3">
                    <label class="form-label font-weight-bold font-size-14">Password Saat Ini</label>
                    <input type="password" name="current_password" class="form-control" placeholder="Masukkan password lama" required>
                </div>

                <div class="mb-3">
                    <label class="form-label font-weight-bold font-size-14">Password Baru</label>
                    <input type="password" name="new_password" class="form-control" placeholder="Minimal 6 karakter" required>
                </div>

                <div class="mb-4">
                    <label class="form-label font-weight-bold font-size-14">Konfirmasi Password Baru</label>
                    <input type="password" name="confirm_password" class="form-control" placeholder="Ulangi password baru" required>
                </div>

                <button type="submit" class="btn btn-warning text-dark font-weight-bold px-4 py-2 rounded-3">
                    <i class="fa-solid fa-shield-check me-1"></i> Perbarui Password
                </button>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

