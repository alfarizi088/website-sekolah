<?php
require_once __DIR__ . '/config/database.php';
$judul_halaman = 'Beranda';

// Ambil data artikel terbaru
$artikel = [];
$q = mysqli_query($koneksi, "SELECT a.*, k.nama_kategori FROM artikel a
                              LEFT JOIN kategori k ON a.kategori_id = k.id
                              ORDER BY a.tanggal_terbit DESC LIMIT 6");
if ($q) { while ($row = mysqli_fetch_assoc($q)) { $artikel[] = $row; } }

// Ambil data prestasi
$prestasi = [];
$q2 = mysqli_query($koneksi, "SELECT * FROM prestasi ORDER BY peringkat ASC LIMIT 3");
if ($q2) { while ($row = mysqli_fetch_assoc($q2)) { $prestasi[] = $row; } }

// Ambil data fasilitas
$fasilitas = [];
$q3 = mysqli_query($koneksi, "SELECT * FROM fasilitas");
if ($q3) { while ($row = mysqli_fetch_assoc($q3)) { $fasilitas[] = $row; } }

$icon_svg = [
  'computer'  => '<rect x="3" y="4" width="18" height="12" rx="1.5"/><path d="M8 20h8M12 16v4"/>',
  'book'      => '<path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v15H6.5A2.5 2.5 0 0 0 4 20.5v-15z"/><path d="M20 18H6.5A2.5 2.5 0 0 0 4 20.5"/>',
  'classroom' => '<rect x="3" y="4" width="18" height="14" rx="1.5"/><path d="M7 8h4M7 12h6"/>',
  'field'     => '<rect x="3" y="6" width="18" height="12" rx="1.5"/><path d="M12 6v12M3 12h18"/>',
];
$rank_class = [1=>'r1', 2=>'r2', 3=>'r3'];

require_once __DIR__ . '/includes/header.php';
?>

<section class="hero">
  <div class="hero-inner">
    <div>
      <div class="hero-eyebrow">Pendidikan Berkualitas</div>
      <h1>Tempat Tumbuhnya Prestasi Dan Akhlak</h1>
      <p>Lingkungan belajar yang nyaman, guru profesional, dan kurikulum terbaik mendukung setiap siswa untuk berkembang secara optimal.</p>
    </div>
   <div class="hero-illustration" aria-hidden="true">
  <img src="uploads/Teacher&Student.png" alt="Ilustrasi Sekolah" style="width:100%;height:100%;object-fit:fill;border-radius:16px;">
</div>
  </div>
</section>

<section class="section container" id="profile">
  <div class="sambutan">
    <div>
      <div class="sambutan-photo" style="aspect-ratio:4/5;border-radius:var(--radius-lg);overflow:hidden;">
  <img src="uploads/The Future of Teacher Skill Assessment.jpg" alt="Kepala Sekolah" style="width:100%;height:100%;object-fit:cover;">
</div>
    </div>
    <div>
      <div class="section-eyebrow">Sambutan</div>
      <h2 class="section-title">SAMBUTAN KEPALA SEKOLAH</h2>
      <span class="sambutan-name">Kepala Sekolah</span>
      <p>Pendidikan bukan hanya tentang meraih ilmu, tetapi juga membentuk karakter, kreativitas, dan rasa tanggung jawab. Sekolah menjadi tempat bagi siswa untuk berkembang, berprestasi, serta mempersiapkan diri menghadapi masa depan.</p>
      <p>Kami berharap seluruh siswa dapat belajar dengan semangat, saling menghargai, dan berani mengembangkan potensi terbaiknya. Bersama-sama, kita wujudkan lingkungan sekolah yang nyaman, aktif, dan inspiratif.</p>
    </div>
  </div>
</section>

<section class="section container" id="artikel">
  <div class="section-eyebrow">Artikel &amp; Blog</div>
  <h2 class="section-title" style="margin-bottom:22px;">Berita Sekolah</h2>

  <div class="artikel-wrap">
    <div class="artikel-slider">
      <button class="slider-btn prev" id="sliderPrev" aria-label="Sebelumnya">&#8249;</button>
      <div class="artikel-track" id="artikelTrack">
        <?php if (empty($artikel)): ?>
          <p>Belum ada artikel.</p>
        <?php else: foreach ($artikel as $a): ?>
          <a class="artikel-card" href="artikel.php?slug=<?= urlencode($a['slug']) ?>">
            <div class="thumb"><?php tampilkan_gambar($a['gambar'], $a['judul']); ?></div>
            <div class="body">
              <span class="kategori-badge"><?= htmlspecialchars($a['nama_kategori'] ?? 'Berita') ?></span>
              <h3><?= htmlspecialchars($a['judul']) ?></h3>
              <div class="meta">
                <span>&#128197; <?= date('d F Y', strtotime($a['tanggal_terbit'])) ?></span>
                <span>&#128065; <?= (int)$a['dilihat'] ?></span>
              </div>
            </div>
          </a>
        <?php endforeach; endif; ?>
      </div>
      <button class="slider-btn next" id="sliderNext" aria-label="Berikutnya">&#8250;</button>
    </div>

    <aside class="prestasi-box" id="prestasi">
      <div class="head">
        <span class="icon">
          <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.6">
            <path d="M8 21h8M12 17v4M6 4h12v4a6 6 0 0 1-12 0V4z"/><path d="M6 6H4a2 2 0 0 0 2 3M18 6h2a2 2 0 0 1-2 3"/>
          </svg>
        </span>
        <div>
          <h4>Prestasi Sekolah</h4>
          <p>Berbagai prestasi yang telah diraih siswa/siswi dalam bidang akademik/non-akademik.</p>
        </div>
      </div>

      <?php foreach ($prestasi as $p): ?>
        <div class="prestasi-item">
          <span class="rank <?= $rank_class[$p['peringkat']] ?? 'r3' ?>"><?= (int)$p['peringkat'] ?></span>
          <div>
            <h5><?= htmlspecialchars($p['judul']) ?></h5>
            <p><?= htmlspecialchars($p['keterangan']) ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </aside>
  </div>
</section>

<section class="section container" id="bidang">
  <div class="section-eyebrow" style="text-align:center;">------ ------</div>
  <h2 class="section-title" style="text-align:center;margin-bottom:6px;">Fasilitas Sekolah</h2>
  <p class="section-sub" style="margin:0 auto 28px;text-align:center;">Fasilitas pendukung untuk menciptakan kegiatan belajar yang nyaman, aktif, dan berkualitas.</p>

  <div class="fasilitas-grid">
    <?php foreach ($fasilitas as $f): ?>
      <div class="fasilitas-card">
        <div class="icon">
          <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.6">
            <?= $icon_svg[$f['icon']] ?? $icon_svg['classroom'] ?>
          </svg>
        </div>
        <h4><?= htmlspecialchars($f['nama']) ?></h4>
        <p><?= htmlspecialchars($f['deskripsi']) ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<section class="section container" id="kontak-form">
  <div class="section-eyebrow" style="text-align:center;">Hubungi Kami</div>
  <h2 class="section-title" style="text-align:center;margin-bottom:6px;">Kirim Pesan</h2>
  <p class="section-sub" style="margin:0 auto 28px;text-align:center;">Ada pertanyaan tentang sekolah kami? Kirimkan pesan, kami akan segera merespon.</p>

  <div class="kontak-box">
    <?php if (($_GET['kontak'] ?? '') === 'sukses'): ?>
      <div class="alert-success-form">Pesan kamu berhasil dikirim. Terima kasih!</div>
    <?php elseif (($_GET['kontak'] ?? '') === 'gagal'): ?>
      <div class="alert-error-form">Nama, email, dan pesan wajib diisi. Silakan coba lagi.</div>
    <?php endif; ?>

    <form action="proses_kontak.php" method="post" class="form-kontak">
      <div class="field-grid">
        <div class="field">
          <label for="nama">Nama</label>
          <input type="text" id="nama" name="nama" required>
        </div>
        <div class="field">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" required>
        </div>
      </div>
      <div class="field">
        <label for="pesan">Pesan</label>
        <textarea id="pesan" name="pesan" required></textarea>
      </div>
      <button type="submit" class="btn-submit-kontak">Kirim Pesan</button>
    </form>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
