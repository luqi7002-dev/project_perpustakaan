<?php
require_once __DIR__ . '/config/koneksi.php';

$username = 'admin';
$password = 'admin123';
$nama = 'Administrator';

$stmt = $conn->prepare('SELECT id FROM users WHERE username = ?');
$stmt->bind_param('s', $username);
$stmt->execute();
$hasil = $stmt->get_result();
if ($hasil->num_rows > 0) {
    echo 'Akun admin sudah tersedia. Username: admin';
    exit;
}

$hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = $conn->prepare('INSERT INTO users (nama, username, password) VALUES (?, ?, ?)');
$stmt->bind_param('sss', $nama, $username, $hash);
if ($stmt->execute()) {
    echo 'Admin berhasil dibuat. Username: <b>admin</b> | Password: <b>admin123</b><br>Hapus file setup_admin.php setelah berhasil digunakan.';
} else {
    echo 'Gagal membuat admin: ' . e($stmt->error);
}
