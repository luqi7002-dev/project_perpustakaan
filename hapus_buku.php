<?php
require_once __DIR__ . '/config/auth.php'; wajib_login(); require_once __DIR__ . '/config/koneksi.php'; require_once __DIR__ . '/config/upload.php';
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); if (!$id) { header('Location: dashboard.php'); exit; }
$stmt = $conn->prepare('SELECT sampul FROM buku WHERE id = ?'); $stmt->bind_param('i', $id); $stmt->execute(); $data = $stmt->get_result()->fetch_assoc();
if ($data) { $stmt = $conn->prepare('DELETE FROM buku WHERE id = ?'); $stmt->bind_param('i', $id); if ($stmt->execute()) hapus_sampul($data['sampul']); }
header('Location: dashboard.php?pesan=hapus'); exit;
