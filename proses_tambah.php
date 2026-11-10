<?php
require_once __DIR__ . '/config/auth.php'; wajib_login();
require_once __DIR__ . '/config/koneksi.php'; require_once __DIR__ . '/config/upload.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: tambah_buku.php'); exit; }
$judul = trim($_POST['judul'] ?? ''); $kategori = trim($_POST['kategori'] ?? ''); $penulis = trim($_POST['penulis'] ?? '');
$tahun = filter_input(INPUT_POST, 'tahun_terbit', FILTER_VALIDATE_INT); $stok = filter_input(INPUT_POST, 'stok', FILTER_VALIDATE_INT);
if ($judul === '' || $kategori === '' || $penulis === '' || !$tahun || $tahun < 1000 || $tahun > (int)date('Y') || $stok === false || $stok === null || $stok < 0) { header('Location: tambah_buku.php?error=' . urlencode('Periksa kembali semua data yang wajib diisi.')); exit; }
try { $sampul = upload_sampul(); $stmt = $conn->prepare('INSERT INTO buku (judul, kategori, penulis, tahun_terbit, stok, sampul) VALUES (?, ?, ?, ?, ?, ?)'); $stmt->bind_param('sssiis', $judul, $kategori, $penulis, $tahun, $stok, $sampul); $stmt->execute(); header('Location: dashboard.php?pesan=tambah'); exit; }
catch (Throwable $e) { if (!empty($sampul)) hapus_sampul($sampul); header('Location: tambah_buku.php?error=' . urlencode($e->getMessage())); exit; }
