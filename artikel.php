<?php
require_once __DIR__ . '/config/database.php';

$slug = $_GET['slug'] ?? '';
$stmt = mysqli_prepare($koneksi, "SELECT a.*, k.nama_kategori FROM artikel a
                                   LEFT JOIN kategori k ON a.kategori_id = k.id
                                   WHERE a.slug = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, 's', $slug);
mysqli_stmt_execute($stmt);
$hasil = mysqli_stmt_get_result($stmt);
$a = $hasil ? mysqli_fetch_assoc($hasil) : null;

if (!$a) {
    require_once __DIR__ . '/config/database.php';
    $judul_halaman = 'Artikel tidak ditemukan';
    require_once __DIR__ . '/includes/header.php';
    echo '<div class="container section"><p>Artikel yang kamu cari tidak ditemukan. <a href="index.php">Kembali ke beranda</a>.</p></div>';
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

// Tambah jumlah dilihat
mysqli_query($koneksi, "UPDATE artikel SET dilihat = dilihat + 1 WHERE id = " . (int)$a['id']);

// Artikel terkait (kategori sama, kecuali artikel ini sendiri)
$terkait = [];
$stmt2 = mysqli_prepare($koneksi, "SELECT * FROM artikel WHERE id != ? ORDER BY tanggal_terbit DESC LIMIT 2");
mysqli_stmt_bind_param($stmt2, 'i', $a['id']);
mysqli_stmt_execute($stmt2);
$hasil2 = mysqli_stmt_get_result($stmt2);
while ($row = mysqli_fetch_assoc($hasil2)) { $terkait[] = $row; }

$judul_halaman = $a['judul'];
require_once __DIR__ . '/includes/header.php';
?>

<div class="container section">
  <div class="breadcrumb">
    <a href="index.php">Beranda</a><span>&gt;</span>
    <a href="index.php#artikel">Artikel &amp; Blog</a><span>&gt;</span>
    <?= htmlspecialchars($a['judul']) ?>
  </div>

  <article class="artikel-detail">
    <span class="badge-berita"><?= htmlspecialchars($a['nama_kategori'] ?? 'Berita') ?></span>
    <h1><?= htmlspecialchars($a['judul']) ?></h1>
    <div class="artikel-meta">
      <span>&#128197; <?= date('d F Y', strtotime($a['tanggal_terbit'])) ?></span>
      <span>&#128100; <?= htmlspecialchars($a['penulis']) ?></span>
      <span>&#128065; <?= (int)$a['dilihat'] ?> dilihat</span>
    </div>

    <div class="thumb-detail">
      <?php tampilkan_gambar($a['gambar'], $a['judul']); ?>
    </div>

    <div class="artikel-content">
      <?php foreach (explode("\n\n", $a['konten']) as $paragraf): ?>
        <?php if (trim($paragraf) !== ''): ?>
          <p><?= nl2br(htmlspecialchars($paragraf)) ?></p>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </article>

  <?php if (!empty($terkait)): ?>
    <h3 class="related-title">Artikel Terkait</h3>
    <div class="related-grid">
      <?php foreach ($terkait as $t): ?>
        <a class="artikel-card" href="artikel.php?slug=<?= urlencode($t['slug']) ?>">
          <div class="thumb"><?php tampilkan_gambar($t['gambar'], $t['judul']); ?></div>
          <div class="body">
            <h3><?= htmlspecialchars($t['judul']) ?></h3>
            <div class="meta">
              <span>&#128197; <?= date('d F Y', strtotime($t['tanggal_terbit'])) ?></span>
              <span>&#128065; <?= (int)$t['dilihat'] ?></span>
            </div>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
