<?php
require_once __DIR__ . '/../config/koneksi.php';
$id = (int)($_GET['id'] ?? 0);
$pdo->prepare("DELETE FROM produk WHERE id=?")->execute([$id]);
header("Location: index.php?sukses=1");
exit;