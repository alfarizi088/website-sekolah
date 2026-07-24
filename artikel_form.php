<?php
require_once __DIR__ . '/auth.php';
cek_login();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$data = ['judul'=>'','slug'=>'','kategori_id'=>'','ringkasan'=>'','konten'=>'','gambar'=>null,'penulis'=>'Admin Sekolah','tanggal_terbit'=>date('Y-m-d')];
$error = '';

if ($id) {
    $stmt = mysqli_prepare($koneksi, "SELECT * FROM artikel WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $hasil = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($hasil);
    if ($row) $data = $row;
}

$kategori_list = [];
$qk = mysqli_query($koneksi, "SELECT * FROM kategori");
while ($k = mysqli_fetch_assoc($qk)) { $kategori_list[] = $k; }

function buat_slug($teks) {
    $teks = strtolower(trim($teks));
    $teks = preg_replace('/[^a-z0-9]+/', '-', $teks);
    return trim($teks, '-');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = trim($_POST['judul'] ?? '');
    $kategori_id = $_POST['kategori_id'] ?: null;
    $ringkasan = trim($_POST['ringkasan'] ?? '');
    $konten = trim($_POST['konten'] ?? '');
    $penulis = trim($_POST['penulis'] ?? 'Admin Sekolah');
    $tanggal_terbit = $_POST['tanggal_terbit'] ?? date('Y-m-d');
    $slug = buat_slug($judul) ?: 'artikel-' . time();
    $namaGambar = $data['gambar'];

    if ($judul === '' || $konten === '') {
        $error = 'Judul dan konten wajib diisi.';
    } else {
        // Upload gambar jika ada (opsional -- boleh dikosongkan / pakai placeholder)
        if (!empty($_FILES['gambar']['name'])) {
            $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg','jpeg','png','webp'];
            if (in_array($ext, $allowed)) {
                $namaGambar = 'artikel-' . time() . '.' . $ext;
                move_uploaded_file($_FILES['gambar']['tmp_name'], __DIR__ . '/../uploads/' . $namaGambar);
            }
        }

        if ($id) {
            $stmt = mysqli_prepare($koneksi, "UPDATE artikel SET kategori_id=?, judul=?, slug=?, ringkasan=?, konten=?, gambar=?, penulis=?, tanggal_terbit=? WHERE id=?");
            mysqli_stmt_bind_param($stmt, 'isssssssi', $kategori_id, $judul, $slug, $ringkasan, $konten, $namaGambar, $penulis, $tanggal_terbit, $id);
        } else {
            $stmt = mysqli_prepare($koneksi, "INSERT INTO artikel (kategori_id, judul, slug, ringkasan, konten, gambar, penulis, tanggal_terbit) VALUES (?,?,?,?,?,?,?,?)");
            mysqli_stmt_bind_param($stmt, 'isssssss', $kategori_id, $judul, $slug, $ringkasan, $konten, $namaGambar, $penulis, $tanggal_terbit);
        }
        mysqli_stmt_execute($stmt);
        header('Location: dashboard.php?pesan=disimpan');
        exit;
    }
}

$judul_halaman = $id ? 'Edit Artikel' : 'Tambah Artikel';
require_once __DIR__ . '/_layout_top.php';
?>

<div class="admin-card">
  <h1 style="font-size:19px;margin-bottom:18px;"><?= $id ? 'Edit Artikel' : 'Tambah Artikel Baru' ?></h1>

  <?php if ($error): ?><div class="alert-success" style="background:#fdecea;color:#b3261e;"><?= htmlspecialchars($error) ?></div><?php endif; ?>

  <form method="post" enctype="multipart/form-data">
    <div class="field">
      <label>Judul Artikel</label>
      <input type="text" name="judul" value="<?= htmlspecialchars($data['judul']) ?>" required>
    </div>
    <div class="field">
      <label>Kategori</label>
      <select name="kategori_id">
        <option value="">- Pilih kategori -</option>
        <?php foreach ($kategori_list as $k): ?>
          <option value="<?= $k['id'] ?>" <?= ($data['kategori_id'] == $k['id']) ? 'selected' : '' ?>><?= htmlspecialchars($k['nama_kategori']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="field">
      <label>Ringkasan Singkat</label>
      <input type="text" name="ringkasan" value="<?= htmlspecialchars($data['ringkasan']) ?>">
    </div>
    <div class="field">
      <label>Konten Artikel (pisahkan paragraf dengan baris kosong)</label>
      <textarea name="konten" required><?= htmlspecialchars($data['konten']) ?></textarea>
    </div>
    <div class="field">
      <label>Gambar Artikel (opsional &mdash; kosongkan jika belum ada, akan tampil placeholder)</label>
      <input type="file" name="gambar" accept=".jpg,.jpeg,.png,.webp">
      <?php if (!empty($data['gambar'])): ?>
        <p style="font-size:12px;color:var(--text-400);margin-top:6px;">Gambar saat ini: <?= htmlspecialchars($data['gambar']) ?></p>
      <?php endif; ?>
    </div>
    <div class="field">
      <label>Penulis</label>
      <input type="text" name="penulis" value="<?= htmlspecialchars($data['penulis']) ?>">
    </div>
    <div class="field">
      <label>Tanggal Terbit</label>
      <input type="date" name="tanggal_terbit" value="<?= htmlspecialchars($data['tanggal_terbit']) ?>">
    </div>

    <button class="btn btn-primary" type="submit">Simpan Artikel</button>
    <a class="btn btn-outline" href="dashboard.php">Batal</a>
  </form>
</div>

<?php require_once __DIR__ . '/_layout_bottom.php'; ?>
