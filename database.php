<?php
/**
 * File koneksi database.
 * Sesuaikan DB_HOST, DB_USER, DB_PASS, DB_NAME dengan konfigurasi server kamu.
 */

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'db_sekolah');

// Membuat koneksi menggunakan mysqli
$koneksi = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$koneksi) {
    die('Koneksi database gagal: ' . mysqli_connect_error());
}

mysqli_set_charset($koneksi, 'utf8mb4');

/**
 * Helper untuk menampilkan gambar.
 * Jika kolom gambar kosong/NULL, tampilkan placeholder bertanda "Gambar belum tersedia".
 */
function tampilkan_gambar($namaFile, $altText = 'Gambar', $class = '') {
    if (!empty($namaFile) && file_exists(__DIR__ . '/../uploads/' . $namaFile)) {
        echo '<img src="uploads/' . htmlspecialchars($namaFile) . '" alt="' . htmlspecialchars($altText) . '" class="' . $class . '">';
    } else {
        echo '<div class="img-placeholder ' . $class . '">
                <svg viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.5">
                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                    <circle cx="8.5" cy="8.5" r="1.5"/>
                    <path d="M21 15l-5-5L5 21"/>
                </svg>
                <span>Gambar belum tersedia</span>
              </div>';
    }
}
