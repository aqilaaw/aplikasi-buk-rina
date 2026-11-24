<?php
require_once __DIR__ . '/../config/koneksi.php';
$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM transaksi WHERE id = ?");
$stmt->execute([$id]);
$trx = $stmt->fetch(PDO::FETCH_ASSOC);

$stmtDet = $pdo->prepare("SELECT d.*, p.nama_produk FROM detail_transaksi d JOIN produk p ON d.produk_id = p.id WHERE d.transaksi_id = ?");
$stmtDet->execute([$id]);
$details = $stmtDet->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk #<?= $id ?></title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body style="display:flex;justify-content:center;padding:40px;">
<div class="panel" style="width:420px;text-align:center;">
    <div class="brand-badge" style="margin:0 auto 10px;">BR</div>
    <h2>Kasir Bu Rina</h2>
    <p style="font-size:13px;color:#64748b;">Terima kasih telah berbelanja</p>
    <hr style="margin:16px 0;border:none;border-top:1px dashed #cbd5e1;">
    <div style="text-align:left;font-size:13px;margin-bottom:12px;">
        No. Transaksi: <strong>#<?= $trx['id'] ?></strong><br>
        Tanggal: <?= date('d/m/Y H:i', strtotime($trx['tanggal'])) ?><br>
        Metode: <?= htmlspecialchars($trx['metode_bayar']) ?>
    </div>
    <table>
        <thead><tr><th>Produk</th><th>Qty</th><th>Total</th></tr></thead>
        <tbody>
        <?php foreach ($details as $d): ?>
            <tr>
                <td><?= htmlspecialchars($d['nama_produk']) ?></td>
                <td><?= $d['qty'] ?></td>
                <td>Rp <?= number_format($d['subtotal'],0,',','.') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div style="display:flex;justify-content:space-between;font-size:18px;font-weight:bold;margin:18px 0;">
        <span>TOTAL</span>
        <span>Rp <?= number_format($trx['total'],0,',','.') ?></span>
    </div>
    <div class="no-print" style="display:flex;flex-direction:column;gap:8px;">
        <button onclick="window.print()" class="btn btn-primary">Cetak Struk</button>
        <a href="index.php" class="btn btn-outline">Transaksi Baru</a>
        <a href="../index.php" style="font-size:13px;color:#64748b;margin-top:6px;">Dashboard</a>
    </div>
</div>
</body>
</html>