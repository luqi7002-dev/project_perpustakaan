# Mini Digital Library — PHP Native & MySQL

Aplikasi CRUD data buku dengan login, session, cookie Remember Me, dan upload sampul JPG/PNG maksimal 2 MB.

## Kebutuhan
- XAMPP (Apache dan MySQL)
- PHP 8+ dengan ekstensi mysqli dan fileinfo
- Browser dan editor kode (misalnya VS Code)

## Cara menjalankan
1. Salin folder `project_perpustakaan` ke `C:/xampp/htdocs/`.
2. Buka XAMPP Control Panel, jalankan **Apache** dan **MySQL**.
3. Buka `http://localhost/phpmyadmin`.
4. Pilih menu **Import**, pilih file `db_perpustakaan.sql`, lalu klik **Import/Go**. File ini membuat database dan tabel `users` serta `buku`.
5. Buka `http://localhost/project_perpustakaan/setup_admin.php` satu kali untuk membuat akun awal.
6. Login melalui `http://localhost/project_perpustakaan/`.

## Akun awal
- Username: `admin`
- Password: `admin123`

Segera ubah password akun awal pada lingkungan produksi. Setelah akun admin berhasil dibuat, hapus `setup_admin.php` dari folder project.

## Struktur database
### Tabel users
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | INT | Primary key, auto increment |
| nama | VARCHAR(100) | Nama pengguna |
| username | VARCHAR(50) | Username unik |
| password | VARCHAR(255) | Password hash |
| dibuat_pada | TIMESTAMP | Waktu pembuatan |

### Tabel buku
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | INT | Primary key, auto increment |
| judul | VARCHAR(150) | Judul buku |
| kategori | VARCHAR(80) | Kategori buku |
| penulis | VARCHAR(100) | Nama penulis |
| tahun_terbit | YEAR | Tahun terbit |
| stok | INT | Jumlah stok buku |
| sampul | VARCHAR(255) | Nama file sampul |
| dibuat_pada | TIMESTAMP | Waktu data dibuat |

## Logika status
- Stok lebih dari 0: **Tersedia**.
- Stok 0: **Dipinjam** (mengikuti contoh logika pada instruksi tugas).

## Fitur
- Login menggunakan POST dan `password_verify()`.
- Session untuk membatasi halaman dashboard dan proses CRUD.
- Remember Me menyimpan username di cookie selama 30 hari, bukan password.
- Logout menghapus session dan cookie.
- CRUD memakai prepared statement mysqli.
- Upload memeriksa MIME file dan ukuran maksimal 2 MB.
- Edit dapat mengganti sampul; hapus buku juga menghapus file sampul.

## Catatan
Aplikasi ini adalah modul pengelolaan data buku sesuai tugas. Modul transaksi peminjaman anggota belum dibuat karena tidak tercantum sebagai fitur wajib dalam rincian tugas.
