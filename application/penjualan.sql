-- Jalankan script ini di database `sistem_inventaris`
-- Contoh: gunakan SQL ini melalui phpMyAdmin

USE sistem_inventaris;

-- Tabel barang (dipakai oleh fitur CRUD barang & transaksi)
CREATE TABLE IF NOT EXISTS barang (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(255) NOT NULL,
  harga DECIMAL(15,2) NOT NULL DEFAULT 0,
  stok_barang INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel transaksi (1 baris = 1 transaksi penjualan 1 barang)
CREATE TABLE IF NOT EXISTS transaksi (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_barang INT NOT NULL,
  harga DECIMAL(15,2) NOT NULL,
  jumlah_beli INT NOT NULL,
  total DECIMAL(15,2) NOT NULL,
  diskon DECIMAL(5,2) NOT NULL DEFAULT 0, -- diskon dalam persen (contoh: 20 berarti 20%)
  total_bayar DECIMAL(15,2) NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_transaksi_barang (id_barang)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

