<?php
require_once __DIR__ . '/auth.php';
cek_login();

// Tandai sudah dibaca
if (isset($_GET['baca'])) {
    $id = (int)$_GET['baca'];
    mysqli_query($koneksi, "UPDATE pesan_kontak SET dibaca = 1 WHERE id = $id");
    header('Location: pesan.php');
    exit;
}

// Hapus pesan
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM pesan_kontak WHERE id = $id");
    header('Location: pesan.php?pesan=dihapus');
    exit;
}

$notif = $_GET['pesan'] ?? '';

$daftar = [];
$q = mysqli_query($koneksi, "SELECT * FROM pesan_kontak ORDER BY dikirim_pada DESC");
if ($q) { while ($row = mysqli_fetch_assoc($q)) { $daftar[] = $row; } }

$judul_halaman = 'Pesan Kontak';
require_once __DIR__ . '/_layout_top.php';
?>

<div class="admin-card">
  <h1 style="font-size:19px;margin-bottom:18px;">Pesan Masuk dari Form Kontak</h1>

  <?php if ($notif === 'dihapus'): ?>
    <div class="alert-success">Pesan berhasil dihapus.</div>
  <?php endif; ?>

  <?php if (empty($daftar)): ?>
    <p>Belum ada pesan masuk.</p>
  <?php else: ?>
    <table>
      <thead>
        <tr><th>Status</th><th>Nama</th><th>Email</th><th>Pesan</th><th>Tanggal</th><th>Aksi</th></tr>
      </thead>
      <tbody>
        <?php foreach ($daftar as $p): ?>
          <tr style="<?= $p['dibaca'] ? '' : 'background:#f4f7ff;' ?>">
            <td><?= $p['dibaca'] ? 'Sudah dibaca' : '<strong>Baru</strong>' ?></td>
            <td><?= htmlspecialchars($p['nama']) ?></td>
            <td><?= htmlspecialchars($p['email']) ?></td>
            <td style="max-width:280px;"><?= nl2br(htmlspecialchars($p['pesan'])) ?></td>
            <td><?= date('d/m/Y H:i', strtotime($p['dikirim_pada'])) ?></td>
            <td>
              <div class="row-actions">
                <?php if (!$p['dibaca']): ?>
                  <a class="btn btn-outline" href="pesan.php?baca=<?= $p['id'] ?>">Tandai dibaca</a>
                <?php endif; ?>
                <a class="btn btn-danger" href="pesan.php?hapus=<?= $p['id'] ?>" onclick="return confirm('Hapus pesan ini?');">Hapus</a>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/_layout_bottom.php'; ?>
