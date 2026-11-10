<?php
function upload_sampul(string $field = 'sampul'): ?string {
    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) return null;
    $file = $_FILES[$field];
    if ($file['error'] !== UPLOAD_ERR_OK) throw new RuntimeException('Upload gagal. Periksa kembali file yang dipilih.');
    if ($file['size'] > 2 * 1024 * 1024) throw new RuntimeException('Ukuran sampul maksimal 2 MB.');
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png'];
    if (!isset($allowed[$mime])) throw new RuntimeException('Format sampul harus JPG atau PNG.');
    $nama = bin2hex(random_bytes(16)) . '.' . $allowed[$mime];
    $tujuan = __DIR__ . '/../uploads/' . $nama;
    if (!move_uploaded_file($file['tmp_name'], $tujuan)) throw new RuntimeException('Gagal menyimpan file sampul.');
    return $nama;
}
function hapus_sampul(?string $nama): void {
    if ($nama) {
        $path = __DIR__ . '/../uploads/' . basename($nama);
        if (is_file($path)) unlink($path);
    }
}
