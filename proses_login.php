<?php
session_start();
require_once __DIR__ . '/config/koneksi.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: index.php'); exit; }
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$stmt = $conn->prepare('SELECT id, nama, username, password FROM users WHERE username = ? LIMIT 1');
$stmt->bind_param('s', $username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
if ($user && password_verify($password, $user['password'])) {
    session_regenerate_id(true);
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nama'] = $user['nama'];
    if (!empty($_POST['remember'])) {
        setcookie('remember_username', $user['username'], ['expires' => time() + (30 * 24 * 60 * 60), 'path' => '/', 'httponly' => true, 'samesite' => 'Lax']);
    } else {
        setcookie('remember_username', '', ['expires' => time() - 3600, 'path' => '/', 'httponly' => true, 'samesite' => 'Lax']);
    }
    header('Location: dashboard.php'); exit;
}
header('Location: index.php?error=1'); exit;
