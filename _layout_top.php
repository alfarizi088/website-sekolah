<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($judul_halaman ?? 'Admin') ?></title>
<link rel="stylesheet" href="../css/style.css">
<style>
  body{background:var(--bg-page);}
  .admin-topbar{background:var(--navy-900);color:#fff;padding:14px 24px;display:flex;justify-content:space-between;align-items:center;}
  .admin-topbar a{color:#fff;}
  .admin-topbar .logout{background:var(--blue-600);padding:8px 16px;border-radius:8px;font-size:13px;font-weight:600;}
  .admin-wrap{max-width:1000px;margin:32px auto;padding:0 24px;}
  .admin-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius-md);padding:24px;box-shadow:var(--shadow-card);}
  table{width:100%;border-collapse:collapse;font-size:13.5px;}
  th,td{padding:10px 8px;border-bottom:1px solid var(--border);text-align:left;vertical-align:top;}
  th{color:var(--text-600);font-size:12.5px;text-transform:uppercase;letter-spacing:.03em;}
  .btn{display:inline-block;padding:7px 14px;border-radius:7px;font-size:12.5px;font-weight:600;border:none;cursor:pointer;}
  .btn-primary{background:var(--blue-600);color:#fff;}
  .btn-danger{background:#fdecea;color:#b3261e;}
  .btn-outline{background:#fff;border:1px solid var(--border);color:var(--text-900);}
  .field{margin-bottom:16px;}
  .field label{display:block;font-size:13px;font-weight:600;margin-bottom:6px;}
  .field input,.field select,.field textarea{width:100%;padding:10px 12px;border:1px solid var(--border);border-radius:8px;font-size:14px;font-family:inherit;}
  .field textarea{min-height:140px;resize:vertical;}
  .row-actions{display:flex;gap:8px;}
  .alert-success{background:#e9f8ef;color:#1a7f4b;padding:10px 12px;border-radius:8px;font-size:13px;margin-bottom:16px;}
</style>
</head>
<body>
<div class="admin-topbar">
  <div>Panel Admin &mdash; <?= htmlspecialchars($_SESSION['admin_nama'] ?? '') ?></div>
  <div>
    <a href="dashboard.php">Artikel</a> &nbsp;|&nbsp;
    <a href="pesan.php">Pesan Kontak<?php
      $jml_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) c FROM pesan_kontak WHERE dibaca = 0"))['c'] ?? 0;
      if ($jml_baru > 0) echo ' (' . (int)$jml_baru . ')';
    ?></a> &nbsp;|&nbsp;
    <a href="../index.php" target="_blank">Lihat Situs</a> &nbsp;|&nbsp;
    <a class="logout" href="logout.php">Keluar</a>
  </div>
</div>
<div class="admin-wrap">
