<?php
require_once __DIR__ . '/auth.php';
cek_login();

// Hapus artikel jika ada permintaan hapus
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM artikel WHERE id = $id");
    header('Location: dashboard.php?pesan=dihapus');
    exit;
}

$pesan = $_GET['pesan'] ?? '';

$artikel = [];
$q = mysqli_query($koneksi, "SELECT a.*, k.nama_kategori FROM artikel a
                              LEFT JOIN kategori k ON a.kategori_id = k.id
                              ORDER BY a.tanggal_terbit DESC");
if ($q) { while ($row = mysqli_fetch_assoc($q)) { $artikel[] = $row; } }

$judul_halaman = 'Kelola Artikel';
require_once __DIR__ . '/_layout_top.php';
?>

<div class="admin-card">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;">
    <h1 style="font-size:19px;">Daftar Artikel &amp; Blog</h1>
    <a class="btn btn-primary" href="artikel_form.php">+ Tambah Artikel</a>
  </div>

  <?php if ($pesan === 'dihapus'): ?>
    <div class="alert-success">Artikel berhasil dihapus.</div>
  <?php elseif ($pesan === 'disimpan'): ?>
    <div class="alert-success">Artikel berhasil disimpan.</div>
  <?php endif; ?>

  <table>
    <thead>
      <tr><th>Judul</th><th>Kategori</th><th>Tanggal</th><th>Dilihat</th><th>Aksi</th></tr>
    </thead>
    <tbody>
      <?php if (empty($artikel)): ?>
        <tr><td colspan="5">Belum ada artikel.</td></tr>
      <?php else: foreach ($artikel as $a): ?>
        <tr>
          <td><?= htmlspecialchars($a['judul']) ?></td>
          <td><?= htmlspecialchars($a['nama_kategori'] ?? '-') ?></td>
          <td><?= date('d/m/Y', strtotime($a['tanggal_terbit'])) ?></td>
          <td><?= (int)$a['dilihat'] ?></td>
          <td>
            <div class="row-actions">
              <a class="btn btn-outline" href="artikel_form.php?id=<?= $a['id'] ?>">Edit</a>
              <a class="btn btn-danger" href="dashboard.php?hapus=<?= $a['id'] ?>" onclick="return confirm('Hapus artikel ini?');">Hapus</a>
            </div>
          </td>
        </tr>
      <?php endforeach; endif; ?>
    </tbody>
  </table>
</div>

<?php require_once __DIR__ . '/_layout_bottom.php'; ?>
