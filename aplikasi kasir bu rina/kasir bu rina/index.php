<?php
require_once __DIR__ . '/config/koneksi.php';

$totalProduk = (int)$pdo->query("SELECT COUNT(*) FROM produk")->fetchColumn();
$totalTransaksi = (int)$pdo->query("SELECT COUNT(*) FROM transaksi")->fetchColumn();
$penjualanHariIni = (int)$pdo->query("SELECT COALESCE(SUM(total), 0) FROM transaksi WHERE DATE(tanggal) = CURDATE()")->fetchColumn();
$stokMenipis = (int)$pdo->query("SELECT COUNT(*) FROM produk WHERE stok <= 5")->fetchColumn();
$transaksiTerbaru = $pdo->query("SELECT id, tanggal, metode_bayar, total FROM transaksi ORDER BY id DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);

function rupiah($angka) {
    return "Rp " . number_format((float)$angka, 0, ',', '.');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kasir Bu Rina - Dashboard</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="app-shell">
    <aside class="sidebar">
        <div>
            <div class="brand">
                <div class="brand-badge">BR</div>
                <div><strong>Kasir Bu Rina</strong><br><small>Warung & Toko</small></div>
            </div>
            <a href="index.php" class="nav-link active">Dashboard</a>
            <a href="produk/index.php" class="nav-link">Data Produk</a>
            <a href="transaksi/index.php" class="nav-link">Transaksi Kasir</a>
            <a href="riwayat/index.php" class="nav-link">Riwayat Transaksi</a>
        </div>
        <div class="sidebar-note"><strong>Kasir siap digunakan</strong><br>Kelola produk dan catat penjualan dengan mudah.</div>
    </aside>
    <main class="main">
        <div class="hero">
            <small>RINGKASAN TOKO</small>
            <h1>Halo, Bu Rina!</h1>
            <p>Pantau penjualan dan kelola toko dari satu tempat.</p>
        </div>
        <div class="stats-grid">
            <div class="stat-card"><h3>Total Produk</h3><p><?= $totalProduk ?></p></div>
            <div class="stat-card"><h3>Jumlah Transaksi</h3><p><?= $totalTransaksi ?></p></div>
            <div class="stat-card"><h3>Penjualan Hari Ini</h3><p><?= rupiah($penjualanHariIni) ?></p></div>
            <div class="stat-card"><h3>Stok Menipis (&le;5)</h3><p style="color:#dc2626"><?= $stokMenipis ?></p></div>
        </div>
        <div class="panel">
            <div style="display:flex;justify-content:space-between;align-items:center;">
                <h2>Transaksi Terbaru</h2>
                <a href="riwayat/index.php" style="color:#15803d;text-decoration:none;font-weight:600;">Lihat semua &rarr;</a>
            </div>
            <table>
                <thead><tr><th>ID</th><th>Tanggal</th><th>Metode Bayar</th><th>Total</th></tr></thead>
                <tbody>
                <?php if (!$transaksiTerbaru): ?>
                    <tr><td colspan="4">Belum ada transaksi.</td></tr>
                <?php else: foreach ($transaksiTerbaru as $t): ?>
                    <tr>
                        <td>#<?= $t['id'] ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($t['tanggal'])) ?></td>
                        <td><span class="badge"><?= htmlspecialchars($t['metode_bayar']) ?></span></td>
                        <td><strong><?= rupiah($t['total']) ?></strong></td>
                    </tr>
                <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
        <div style="display:flex;gap:12px;">
            <a href="transaksi/index.php" class="btn btn-primary">+ Mulai Transaksi</a>
            <a href="produk/tambah.php" class="btn btn-outline">+ Tambah Produk</a>
        </div>
    </main>
</div>
</body>
</html>