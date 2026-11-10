<?php
require_once __DIR__ . '/config/auth.php'; wajib_login(); require_once __DIR__ . '/config/koneksi.php'; require_once __DIR__ . '/config/upload.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: dashboard.php'); exit; }
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT); $judul = trim($_POST['judul'] ?? ''); $kategori = trim($_POST['kategori'] ?? ''); $penulis = trim($_POST['penulis'] ?? ''); $tahun = filter_input(INPUT_POST, 'tahun_terbit', FILTER_VALIDATE_INT); $stok = filter_input(INPUT_POST, 'stok', FILTER_VALIDATE_INT);
if (!$id || $judul === '' || $kategori === '' || $penulis === '' || !$tahun || $tahun < 1000 || $tahun > (int)date('Y') || $stok === false || $stok === null || $stok < 0) { header('Location: dashboard.php?pesan=gagal'); exit; }
$stmt = $conn->prepare('SELECT sampul FROM buku WHERE id = ?'); $stmt->bind_param('i', $id); $stmt->execute(); $lama = $stmt->get_result()->fetch_assoc(); if (!$lama) { header('Location: dashboard.php'); exit; }
$sampulBaru = null;
try { $sampulBaru = upload_sampul(); $sampul = $sampulBaru ?: $lama['sampul']; $stmt = $conn->prepare('UPDATE buku SET judul=?, kategori=?, penulis=?, tahun_terbit=?, stok=?, sampul=? WHERE id=?'); $stmt->bind_param('sssiisi', $judul, $kategori, $penulis, $tahun, $stok, $sampul, $id); $stmt->execute(); if ($sampulBaru) hapus_sampul($lama['sampul']); header('Location: dashboard.php?pesan=edit'); exit; }
catch (Throwable $e) { if ($sampulBaru) hapus_sampul($sampulBaru); header('Location: edit_buku.php?id=' . $id . '&error=' . urlencode($e->getMessage())); exit; }
