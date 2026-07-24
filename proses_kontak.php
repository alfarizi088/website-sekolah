<?php
require_once __DIR__ . '/config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$nama = trim($_POST['nama'] ?? '');
$email = trim($_POST['email'] ?? '');
$pesan = trim($_POST['pesan'] ?? '');

if ($nama === '' || $email === '' || $pesan === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: index.php?kontak=gagal#kontak-form');
    exit;
}

$stmt = mysqli_prepare($koneksi, "INSERT INTO pesan_kontak (nama, email, pesan) VALUES (?, ?, ?)");
mysqli_stmt_bind_param($stmt, 'sss', $nama, $email, $pesan);
mysqli_stmt_execute($stmt);

header('Location: index.php?kontak=sukses#kontak-form');
exit;
