<?php
session_start();
require_once __DIR__ . '/../config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = mysqli_prepare($koneksi, "SELECT * FROM admin WHERE username = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $hasil = mysqli_stmt_get_result($stmt);
    $admin = $hasil ? mysqli_fetch_assoc($hasil) : null;

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_nama'] = $admin['nama_lengkap'];
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Username atau password salah.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Admin</title>
<link rel="stylesheet" href="../css/style.css">
<style>
  body{display:flex;align-items:center;justify-content:center;min-height:100vh;background:var(--navy-900);}
  .login-box{background:#fff;padding:36px 32px;border-radius:var(--radius-lg);width:100%;max-width:360px;box-shadow:var(--shadow-card);}
  .login-box h1{font-size:20px;margin-bottom:4px;}
  .login-box p{color:var(--text-600);font-size:13px;margin-bottom:22px;}
  .field{margin-bottom:16px;}
  .field label{display:block;font-size:13px;font-weight:600;margin-bottom:6px;}
  .field input{width:100%;padding:10px 12px;border:1px solid var(--border);border-radius:8px;font-size:14px;}
  .btn-submit{width:100%;padding:11px;border:none;border-radius:8px;background:var(--blue-600);color:#fff;font-weight:700;font-size:14px;cursor:pointer;}
  .alert-error{background:#fdecea;color:#b3261e;padding:10px 12px;border-radius:8px;font-size:13px;margin-bottom:16px;}
</style>
</head>
<body>
  <form class="login-box" method="post">
    <h1>Login Admin</h1>
    <p>Masuk untuk mengelola konten website sekolah.</p>
    <?php if ($error): ?><div class="alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <div class="field">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" required autofocus>
    </div>
    <div class="field">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>
    </div>
    <button class="btn-submit" type="submit">Masuk</button>
    <p style="margin-top:16px;font-size:12px;color:var(--text-400);">Default: admin / admin123</p>
  </form>
</body>
</html>
