<?php
require_once __DIR__ . '/../config/koneksi.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo->prepare("INSERT INTO produk (nama_produk, kategori, harga, stok) VALUES (?, ?, ?, ?)")
        ->execute([$_POST['nama_produk'], $_POST['kategori'], (int)$_POST['harga'], (int)$_POST['stok']]);
    header("Location: index.php?sukses=1");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><title>Tambah Produk</title><link rel="stylesheet" href="../assets/style.css"></head>
<body style="padding:40px;max-width:520px;margin:auto;">
<div class="panel">
    <h2>Tambah Produk</h2>
    <form method="POST" style="margin-top:16px;display:flex;flex-direction:column;gap:12px;">
        <div><label>Nama Produk</label><input type="text" name="nama_produk" required></div>
        <div><label>Kategori</label><input type="text" name="kategori" required></div>
        <div><label>Harga (Rp)</label><input type="number" name="harga" required></div>
        <div><label>Stok</label><input type="number" name="stok" required></div>
        <button type="submit" class="btn btn-primary">Simpan Produk</button>
        <a href="index.php" class="btn btn-outline" style="text-align:center;">Kembali</a>
    </form>
</div>
</body>
</html>