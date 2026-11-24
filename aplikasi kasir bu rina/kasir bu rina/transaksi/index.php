<?php
require_once __DIR__ . '/../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $qtyList = $_POST['qty'] ?? [];
    $metode = $_POST['metode_bayar'] ?? 'Tunai';
    $items = [];
    $total = 0;

    foreach ($qtyList as $prodId => $qty) {
        $qty = (int)$qty;
        if ($qty > 0) {
            $stmt = $pdo->prepare("SELECT * FROM produk WHERE id = ?");
            $stmt->execute([$prodId]);
            $p = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($p && $p['stok'] >= $qty) {
                $sub = $p['harga'] * $qty;
                $total += $sub;
                $items[] = ['produk' => $p, 'qty' => $qty, 'subtotal' => $sub];
            }
        }
    }

    if (count($items) > 0) {
        $pdo->beginTransaction();
        $stmt = $pdo->prepare("INSERT INTO transaksi (metode_bayar, total) VALUES (?, ?)");
        $stmt->execute([$metode, $total]);
        $trxId = $pdo->lastInsertId();

        foreach ($items as $it) {
            $pdo->prepare("INSERT INTO detail_transaksi (transaksi_id, produk_id, qty, harga_satuan, subtotal) VALUES (?, ?, ?, ?, ?)")
                ->execute([$trxId, $it['produk']['id'], $it['qty'], $it['produk']['harga'], $it['subtotal']]);
            $pdo->prepare("UPDATE produk SET stok = stok - ? WHERE id = ?")
                ->execute([$it['qty'], $it['produk']['id']]);
        }
        $pdo->commit();
        header("Location: struk.php?id=" . $trxId);
        exit;
    }
}

$produkList = $pdo->query("SELECT * FROM produk WHERE stok > 0 ORDER BY nama_produk ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Transaksi Kasir - Bu Rina</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="app-shell">
    <aside class="sidebar">
        <div>
            <div class="brand"><div class="brand-badge">BR</div><div><strong>Kasir Bu Rina</strong><br><small>Warung & Toko</small></div></div>
            <a href="../index.php" class="nav-link">Dashboard</a>
            <a href="../produk/index.php" class="nav-link">Data Produk</a>
            <a href="index.php" class="nav-link active">Transaksi Kasir</a>
            <a href="../riwayat/index.php" class="nav-link">Riwayat Transaksi</a>
        </div>
    </aside>
    <main class="main">
        <h1>Transaksi Kasir</h1>
        <form method="POST" class="panel" style="margin-top:16px;">
            <h3>Pilih Produk</h3>
            <div class="product-grid">
                <?php foreach ($produkList as $p): ?>
                <div class="product-item">
                    <div>
                        <strong><?= htmlspecialchars($p['nama_produk']) ?></strong><br>
                        <small><?= htmlspecialchars($p['kategori']) ?> &bull; Stok: <?= $p['stok'] ?></small><br>
                        <span style="color:#15803d;font-weight:bold;">Rp <?= number_format($p['harga'],0,',','.') ?></span>
                    </div>
                    <div style="width:90px;">
                        <small>Jumlah</small>
                        <input type="number" name="qty[<?= $p['id'] ?>]" min="0" max="<?= $p['stok'] ?>" value="0" data-harga="<?= $p['harga'] ?>" class="qty-input">
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;margin-top:20px;padding-top:20px;border-top:1px solid #e5e7eb;">
                <div style="width:260px;">
                    <label><strong>Metode Pembayaran</strong></label>
                    <select name="metode_bayar">
                        <option value="Tunai">Tunai</option>
                        <option value="QRIS">QRIS</option>
                        <option value="Transfer">Transfer</option>
                    </select>
                </div>
                <div style="text-align:right;">
                    <small>Perkiraan Total</small>
                    <h2 id="totalText" style="color:#15803d;">Rp 0</h2>
                    <button type="submit" class="btn btn-primary" style="margin-top:8px;">Selesaikan Transaksi &rarr;</button>
                </div>
            </div>
        </form>
    </main>
</div>
<script>
document.querySelectorAll('.qty-input').forEach(inp => {
    inp.addEventListener('input', () => {
        let total = 0;
        document.querySelectorAll('.qty-input').forEach(el => {
            total += (parseInt(el.value) || 0) * parseInt(el.dataset.harga);
        });
        document.getElementById('totalText').innerText = 'Rp ' + total.toLocaleString('id-ID');
    });
});
</script>
</body>
</html>