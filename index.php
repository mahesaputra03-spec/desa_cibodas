<?php
require_once 'config.php';
require_login();

$pdo = db();
$total = (int)$pdo->query("SELECT COUNT(*) FROM penduduk")->fetchColumn();
$datang = (int)$pdo->query("SELECT COUNT(*) FROM penduduk_datang")->fetchColumn();
$pindah = (int)$pdo->query("SELECT COUNT(*) FROM penduduk_pindah")->fetchColumn();
$meninggal = (int)$pdo->query("SELECT COUNT(*) FROM penduduk_meninggal")->fetchColumn();
$lahir = (int)$pdo->query("SELECT COUNT(*) FROM penduduk_lahir")->fetchColumn();
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Dashboard Data Kependudukan Desa Cibodas</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="app">
<aside class="sidebar">
  <div class="brand"><div class="logo">DC</div><div><b>Desa Cibodas</b><small>Sistem Kependudukan</small></div></div>
  <nav>
    <a class="active" href="index.php">Dashboard</a>
    <a href="penduduk.php">Data Penduduk</a>
    <a href="mutasi.php?jenis=datang">Penduduk Datang</a>
    <a href="mutasi.php?jenis=pindah">Penduduk Pindah</a>
    <a href="mutasi.php?jenis=meninggal">Penduduk Meninggal</a>
    <a href="mutasi.php?jenis=lahir">Penduduk Baru Lahir</a>
  </nav>
  <a class="logout" href="logout.php">Keluar</a>
</aside>
<main class="main">
<header class="topbar"><div><h1>Dashboard Data Kependudukan Desa Cibodas</h1><p>Kelola data kependudukan desa secara terpusat.</p></div><div class="user">👤 <?=e($_SESSION['username'] ?? 'Admin')?></div></header>
<section class="cards">
  <div class="card"><span>Total Penduduk</span><strong><?=$total?></strong><a href="penduduk.php">Lihat data →</a></div>
  <div class="card"><span>Penduduk Datang</span><strong><?=$datang?></strong><a href="mutasi.php?jenis=datang">Lihat data →</a></div>
  <div class="card"><span>Penduduk Pindah</span><strong><?=$pindah?></strong><a href="mutasi.php?jenis=pindah">Lihat data →</a></div>
  <div class="card"><span>Meninggal</span><strong><?=$meninggal?></strong><a href="mutasi.php?jenis=meninggal">Lihat data →</a></div>
  <div class="card"><span>Baru Lahir</span><strong><?=$lahir?></strong><a href="mutasi.php?jenis=lahir">Lihat data →</a></div>
</section>
<section class="panel">
<h2>Fitur Utama</h2>
<div class="quick">
<a href="penduduk.php?action=add">➕ Tambah penduduk</a>
<a href="penduduk.php?pdf=1" target="_blank">📄 Download PDF penduduk</a>
<a href="penduduk.php">🔎 Cari & kelola data</a>
</div>
</section>
<section class="notice"><b>Catatan keamanan:</b> data NIK dan KK adalah data pribadi. Batasi akses hanya untuk perangkat/petugas desa yang berwenang dan gunakan HTTPS bila sistem dipasang online.</section>
</main></div>
</body></html>
