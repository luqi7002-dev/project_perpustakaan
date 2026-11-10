<?php
require_once __DIR__ . '/config/auth.php'; wajib_login();
require_once __DIR__ . '/config/koneksi.php';
$cari = trim($_GET['cari'] ?? '');
if ($cari !== '') {
    $like = '%' . $cari . '%';
    $stmt = $conn->prepare('SELECT * FROM buku WHERE judul LIKE ? OR penulis LIKE ? OR kategori LIKE ? ORDER BY id DESC');
    $stmt->bind_param('sss', $like, $like, $like);
} else { $stmt = $conn->prepare('SELECT * FROM buku ORDER BY id DESC'); }
$stmt->execute(); $buku = $stmt->get_result();
$total = $conn->query('SELECT COUNT(*) AS jumlah FROM buku')->fetch_assoc()['jumlah'];
$tersedia = $conn->query('SELECT COUNT(*) AS jumlah FROM buku WHERE stok > 0')->fetch_assoc()['jumlah'];
$dipinjam = $conn->query('SELECT COUNT(*) AS jumlah FROM buku WHERE stok = 0')->fetch_assoc()['jumlah'];
$pesan = $_GET['pesan'] ?? '';
?>
<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Dashboard - Mini Digital Library</title><link rel="stylesheet" href="assets/style.css"></head><body>
<header class="topbar"><a class="brand" href="dashboard.php">📚 Mini Digital Library</a><div class="user-area">Halo, <?= e($_SESSION['nama']) ?> <a class="btn btn-light btn-small" href="logout.php">Logout</a></div></header>
<main class="container"><div class="page-heading"><div><p class="eyebrow">PANEL ADMINISTRATOR</p><h1>Dashboard Perpustakaan</h1><p class="muted">Kelola koleksi buku perpustakaan digital mini.</p></div><a href="tambah_buku.php" class="btn">＋ Tambah Buku</a></div>
<?php if ($pesan === 'tambah'): ?><div class="alert success">Data buku berhasil ditambahkan.</div><?php elseif ($pesan === 'edit'): ?><div class="alert success">Data buku berhasil diperbarui.</div><?php elseif ($pesan === 'hapus'): ?><div class="alert success">Data buku berhasil dihapus.</div><?php elseif ($pesan === 'gagal'): ?><div class="alert error">Terjadi kesalahan saat memproses data.</div><?php endif; ?>
<section class="stats"><div class="stat-card"><span>Total Koleksi</span><strong><?= e($total) ?></strong><small>Data buku terdaftar</small></div><div class="stat-card"><span>Buku Tersedia</span><strong><?= e($tersedia) ?></strong><small>Stok lebih dari 0</small></div><div class="stat-card"><span>Stok Habis</span><strong><?= e($dipinjam) ?></strong><small>Status dipinjam</small></div></section>
<section class="panel"><div class="panel-head"><div><h2>Daftar Buku</h2><p class="muted">Daftar seluruh koleksi buku.</p></div><form class="search" method="GET"><input type="search" name="cari" placeholder="Cari judul, penulis, kategori..." value="<?= e($cari) ?>"><button class="btn" type="submit">Cari</button></form></div>
<div class="table-wrap"><table><thead><tr><th>Sampul</th><th>Judul Buku</th><th>Kategori</th><th>Penulis</th><th>Tahun</th><th>Stok</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
<?php if ($buku->num_rows === 0): ?><tr><td colspan="8" class="empty">Belum ada data buku. Klik Tambah Buku untuk memulai.</td></tr><?php else: while ($row = $buku->fetch_assoc()): $status = ((int)$row['stok'] > 0) ? 'Tersedia' : 'Dipinjam'; ?>
<tr><td><?php if ($row['sampul']): ?><img class="cover-thumb" src="uploads/<?= e($row['sampul']) ?>" alt="Sampul buku"><?php else: ?><div class="no-cover">📖</div><?php endif; ?></td><td class="book-title"><?= e($row['judul']) ?></td><td><?= e($row['kategori']) ?></td><td><?= e($row['penulis']) ?></td><td><?= e($row['tahun_terbit']) ?></td><td><?= e($row['stok']) ?></td><td><span class="status <?= $status === 'Tersedia' ? 'available' : 'borrowed' ?>"><?= $status ?></span></td><td><div class="actions"><a class="btn btn-small" href="edit_buku.php?id=<?= (int)$row['id'] ?>">Edit</a><a class="btn btn-danger btn-small" href="hapus_buku.php?id=<?= (int)$row['id'] ?>" onclick="return confirm('Yakin ingin menghapus buku ini?')">Hapus</a></div></td></tr>
<?php endwhile; endif; ?></tbody></table></div></section><p class="footer-note">© <?= date('Y') ?> Mini Digital Library · Sistem Informasi Perpustakaan</p></main></body></html>
