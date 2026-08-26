<?php
require_once 'config.php';
if (!empty($_SESSION['user_id'])) { header('Location: index.php'); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = db()->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: index.php'); exit;
    }
    $error = 'Username atau password salah.';
}
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Login - Desa Cibodas</title><link rel="stylesheet" href="assets/style.css"></head>
<body class="login-page"><div class="login-card"><div class="logo big">DC</div><h1>Desa Cibodas</h1><p>Login Sistem Data Kependudukan</p>
<?php if($error): ?><div class="error"><?=e($error)?></div><?php endif; ?>
<form method="post"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>">
<label>Username</label><input name="username" autocomplete="username" required>
<label>Password</label><input type="password" name="password" autocomplete="current-password" required>
<button type="submit">Masuk</button></form>
<small>Gunakan akun perangkat desa yang telah diberikan administrator.</small></div></body></html>
