<?php
session_start();
if (!empty($_SESSION['user_id'])) { header('Location: dashboard.php'); exit; }
$ingat = $_COOKIE['remember_username'] ?? '';
$pesan = $_GET['pesan'] ?? '';
?>
<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Login - Mini Digital Library</title><link rel="stylesheet" href="assets/style.css"></head>
<body class="login-page"><main class="login-card"><div class="brand-icon">📚</div><h1>Mini Digital Library</h1><p class="muted">Masuk untuk mengelola koleksi buku</p>
<?php if ($pesan === 'logout'): ?><div class="alert success">Kamu berhasil logout.</div><?php elseif ($pesan === 'akses'): ?><div class="alert error">Silakan login terlebih dahulu.</div><?php endif; ?>
<?php if (!empty($_GET['error'])): ?><div class="alert error">Username atau password salah.</div><?php endif; ?>
<form action="proses_login.php" method="POST"><label>Username</label><input type="text" name="username" placeholder="Masukkan username" value="<?= htmlspecialchars($ingat, ENT_QUOTES, 'UTF-8') ?>" required autofocus><label>Password</label><input type="password" name="password" placeholder="Masukkan password" required><label class="check"><input type="checkbox" name="remember" value="1" <?= $ingat ? 'checked' : '' ?>> Ingat saya (Remember Me)</label><button class="btn full" type="submit">Login</button></form><p class="login-note">Mini Digital Library · PHP Native & MySQL</p></main></body></html>
