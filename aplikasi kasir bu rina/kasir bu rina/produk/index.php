<?php
require_once __DIR__ . '/../config/koneksi.php';
$produk = $pdo->query("SELECT * FROM produk ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><title>Data Produk</title><link rel="stylesheet" href="../assets/style.css"></head>
<body>
<div class="app-shell">
    <aside class="sidebar">
        <div>
            <div class="brand"><div class="brand-badge">BR</div><div><strong>Kasir Bu Rina</strong></div></div>
            <a href="../index.php" class="nav-link">Dashboard</a>
            <a href="index.php" class="nav-link active">Data Produk</a>
            <a href="../transaksi/index.php" class="nav-link">Transaksi Kasir</a>
            <a href="../riwayat/index.php" class="nav-link">Riwayat Transaksi</a>
        </div>
    </aside>
    <main class="main">
        <div style="display:flex;justify-content:space-between;align-items:center;">
            <h1>Data Produk</h1>
            <a href="tambah.php" class="btn btn-primary">+ Tambah Produk</a>
        </div>
        <div class="panel" style="margin-top:16px;">
            <table>
                <thead><tr><th>Nama Produk</th><th>Kategori</th><th>Harga</th><th>Stok</th><th>Aksi</th></tr></thead>
                <tbody>
                <?php foreach ($produk as $p): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($p['nama_produk']) ?></strong></td>
                        <td><?= htmlspecialchars($p['kategori']) ?></td>
                        <td>Rp <?= number_format($p['harga'],0,',','.') ?></td>
                        <td><?= $p['stok'] ?></td>
                        <td>
                            <a href="edit.php?id=<?= $p['id'] ?>" style="color:#15803d;margin-right:10px;">Edit</a>
                            <a href="hapus.php?id=<?= $p['id'] ?>" onclick="return confirm('Hapus produk?')" style="color:#dc2626;">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>
</html>