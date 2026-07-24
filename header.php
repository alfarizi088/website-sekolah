<?php
// Ambil identitas sekolah untuk ditampilkan di navbar/footer
$q_identitas = mysqli_query($koneksi, "SELECT * FROM identitas_sekolah LIMIT 1");
$identitas = $q_identitas ? mysqli_fetch_assoc($q_identitas) : null;
$nama_sekolah = $identitas['nama_sekolah'] ?? 'Nama Sekolah';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= isset($judul_halaman) ? htmlspecialchars($judul_halaman) . ' - ' . htmlspecialchars($nama_sekolah) : htmlspecialchars($nama_sekolah) ?></title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="navbar">
    <div class="navbar-inner">
        <a href="index.php" class="brand">
            <span class="brand-logo" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.6">
                    <path d="M12 3l9 4.5-9 4.5-9-4.5L12 3z"/>
                    <path d="M6 10.5V16c0 1.5 2.7 3 6 3s6-1.5 6-3v-5.5"/>
                </svg>
            </span>
            <span class="brand-name"><?= htmlspecialchars($nama_sekolah) ?></span>
        </a>

        <button class="nav-toggle" id="navToggle" aria-label="Buka menu" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>

        <nav class="nav-menu" id="navMenu">
            <a href="index.php">Beranda</a>
            <a href="index.php#profile">Profile</a>
            <a href="index.php#bidang">Bidang</a>
            <a href="index.php#prestasi">Prestasi</a>
        </nav>
        <a href="index.php#kontak-form" class="btn-kontak">Kontak</a>
    </div>
</header>
