<?php
/**
 * OMAHCODE - Admin Login Page
 */

require_once __DIR__ . '/../config/helpers.php';

init_session();

// Redirect if already logged in
if (is_admin_logged_in()) {
    header("Location: index.php");
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'Silakan isi username dan password.';
    } else {
        $pdo = get_db();
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            session_regenerate_id(true);
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            $_SESSION['admin_name'] = $admin['name'];
            $_SESSION['admin_email'] = $admin['email'];
            $_SESSION['admin_role'] = $admin['role'];

            header("Location: index.php");
            exit;
        } else {
            $error = 'Username atau password yang Anda masukkan salah.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Administrator | OMAHCODE CMS</title>
    <link rel="shortcut icon" href="../assets/img/favicon.png" type="image/x-icon">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #070D18 0%, #0B192C 60%, #003049 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.45);
            width: 100%;
            max-width: 440px;
            padding: 40px;
            border: 1px solid rgba(0, 180, 216, 0.25);
        }
        .form-control {
            border-radius: 12px;
            padding: 12px 16px;
            border: 1px solid #cbd5e1;
            font-size: 15px;
        }
        .form-control:focus {
            border-color: #00B4D8;
            box-shadow: 0 0 0 3px rgba(0, 180, 216, 0.15);
        }
        .btn-login {
            background: linear-gradient(135deg, #00B4D8 0%, #0077B6 100%);
            color: #ffffff;
            border-radius: 12px;
            padding: 13px;
            font-weight: 700;
            font-size: 15px;
            width: 100%;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            box-shadow: 0 10px 20px rgba(0, 180, 216, 0.35);
            transform: translateY(-2px);
            color: #ffffff;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="text-center mb-4">
        <img src="../assets/img/omahcode-logo.png" alt="OMAHCODE" style="max-height: 48px; width: auto; object-fit: contain;" class="mb-2">
        <p class="text-muted font-size-14 mb-0">Sistem Manajemen Konten & Admin Panel</p>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger py-2 px-3 rounded-3 font-size-14 mb-3">
            <i class="fa-solid fa-triangle-exclamation me-1"></i> <?= e($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label class="form-label font-weight-bold font-size-14 text-dark">Username</label>
            <div class="input-group">
                <span class="input-group-text bg-light text-muted border-end-0 rounded-start-3"><i class="fa-solid fa-user"></i></span>
                <input type="text" name="username" class="form-control border-start-0" placeholder="Masukkan username" value="<?= e($_POST['username'] ?? '') ?>" required autofocus>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label font-weight-bold font-size-14 text-dark">Password</label>
            <div class="input-group">
                <span class="input-group-text bg-light text-muted border-end-0 rounded-start-3"><i class="fa-solid fa-lock"></i></span>
                <input type="password" name="password" class="form-control border-start-0" placeholder="Masukkan password" required>
            </div>
        </div>

        <button type="submit" class="btn-login mb-3">
            <i class="fa-solid fa-right-to-bracket me-2"></i> Masuk ke Dashboard
        </button>

        <div class="text-center mt-3">
            <a href="../" class="text-decoration-none text-muted font-size-14">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Website
            </a>
        </div>
    </form>
</div>

</body>
</html>
