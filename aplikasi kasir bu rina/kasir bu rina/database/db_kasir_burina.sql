CREATE DATABASE IF NOT EXISTS db_kasir_burina;
USE db_kasir_burina;

CREATE TABLE produk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_produk VARCHAR(100) NOT NULL,
    kategori VARCHAR(50) NOT NULL,
    harga INT NOT NULL,
    stok INT NOT NULL
);

CREATE TABLE transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tanggal DATETIME DEFAULT CURRENT_TIMESTAMP,
    metode_bayar VARCHAR(30) NOT NULL,
    total INT NOT NULL
);

CREATE TABLE detail_transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    transaksi_id INT NOT NULL,
    produk_id INT NOT NULL,
    qty INT NOT NULL,
    harga_satuan INT NOT NULL,
    subtotal INT NOT NULL,
    FOREIGN KEY (transaksi_id) REFERENCES transaksi(id) ON DELETE CASCADE
);

INSERT INTO produk (nama_produk, kategori, harga, stok) VALUES
('Air Mineral', 'Minuman', 4000, 25),
('Keripik Singkong', 'Camilan', 1000, 30),
('Mi Instan', 'Makanan', 3500, 35),
('Roti Cokelat', 'Makanan', 6000, 15),
('Susu Kotak', 'Minuman', 7000, 4),
('Teh Botol', 'Minuman', 5000, 25);