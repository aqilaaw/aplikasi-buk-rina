<?php
require_once __DIR__ . '/../config/koneksi.php';
$id = (int)($_GET['id'] ?? 0);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo->prepare("UPDATE produk SET nama_produk=?, kategori=?, harga=?, stok=? WHERE id=?")
        ->execute([$_POST['nama_produk'], $_POST['kategori'], (int)$_POST['harga'], (int)$_POST['stok'], $id]);
    header("Location: index.php?sukses=1");
    exit;
}
$stmt = $pdo->prepare("SELECT * FROM produk WHERE id=?");
$stmt->execute([$id]);
$p = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><title>Edit Produk</title><link rel="stylesheet" href="../assets/style.css"></head>
<body style="padding:40px;max-width:520px;margin:auto;">
<div class="panel">
    <h2>Edit Produk</h2>
    <form method="POST" style="margin-top:16px;display:flex;flex-direction:column;gap:12px;">
        <div><label>Nama Produk</label><input type="text" name="nama_produk" value="<?= htmlspecialchars($p['nama_produk']) ?>" required></div>
        <div><label>Kategori</label><input type="text" name="kategori" value="<?= htmlspecialchars($p['kategori']) ?>" required></div>
        <div><label>Harga (Rp)</label><input type="number" name="harga" value="<?= $p['harga'] ?>" required></div>
        <div><label>Stok</label><input type="number" name="stok" value="<?= $p['stok'] ?>" required></div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="index.php" class="btn btn-outline" style="text-align:center;">Kembali</a>
    </form>
</div>
</body>
</html>