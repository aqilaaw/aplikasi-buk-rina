<?php
require_once __DIR__ . '/../config/koneksi.php';
$list = $pdo->query("SELECT * FROM transaksi ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><title>Riwayat Transaksi</title><link rel="stylesheet" href="../assets/style.css"></head>
<body>
<div class="app-shell">
    <aside class="sidebar">
        <div>
            <div class="brand"><div class="brand-badge">BR</div><div><strong>Kasir Bu Rina</strong></div></div>
            <a href="../index.php" class="nav-link">Dashboard</a>
            <a href="../produk/index.php" class="nav-link">Data Produk</a>
            <a href="../transaksi/index.php" class="nav-link">Transaksi Kasir</a>
            <a href="index.php" class="nav-link active">Riwayat Transaksi</a>
        </div>
    </aside>
    <main class="main">
        <h1>Riwayat Transaksi</h1>
        <div class="panel" style="margin-top:16px;">
            <table>
                <thead><tr><th>ID</th><th>Tanggal</th><th>Metode</th><th>Total</th><th>Detail</th></tr></thead>
                <tbody>
                <?php foreach ($list as $t): ?>
                    <tr>
                        <td>#<?= $t['id'] ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($t['tanggal'])) ?></td>
                        <td><span class="badge"><?= htmlspecialchars($t['metode_bayar']) ?></span></td>
                        <td><strong>Rp <?= number_format($t['total'],0,',','.') ?></strong></td>
                        <td><a href="../transaksi/struk.php?id=<?= $t['id'] ?>" style="color:#15803d;font-weight:600;">Lihat Struk</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>
</html>