CREATE DATABASE IF NOT EXISTS `project_simulator`;
USE `project_simulator`;

CREATE TABLE IF NOT EXISTS `users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` VARCHAR(100) NOT NULL,
  `email` VARCHAR(120) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('buyer','seller','admin') NOT NULL DEFAULT 'buyer',
  `status_akun` ENUM('pending','active','blocked') NOT NULL DEFAULT 'active',
  `api_token` VARCHAR(128) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_users_email` (`email`),
  UNIQUE KEY `uk_users_api_token` (`api_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `toko` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED NOT NULL,
  `nama_toko` VARCHAR(120) NOT NULL,
  `alamat_toko` TEXT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_toko_user_id` (`user_id`),
  CONSTRAINT `fk_toko_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `produk` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `toko_id` INT UNSIGNED NOT NULL,
  `nama_produk` VARCHAR(150) NOT NULL,
  `harga` INT NOT NULL DEFAULT 0,
  `stok` INT NOT NULL DEFAULT 0,
  `foto` VARCHAR(255) DEFAULT NULL,
  `deskripsi` TEXT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_produk_toko_id` (`toko_id`),
  CONSTRAINT `fk_produk_toko` FOREIGN KEY (`toko_id`) REFERENCES `toko` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `keranjang` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED NOT NULL,
  `produk_id` INT UNSIGNED NOT NULL,
  `jumlah` INT NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_keranjang_user_produk` (`user_id`, `produk_id`),
  KEY `idx_keranjang_produk_id` (`produk_id`),
  CONSTRAINT `fk_keranjang_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_keranjang_produk` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `pesanan` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `buyer_id` INT UNSIGNED NOT NULL,
  `total_bayar` INT NOT NULL DEFAULT 0,
  `status` ENUM('belum_bayar','dibayar','dikirim','selesai') NOT NULL DEFAULT 'dibayar',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_pesanan_buyer_id` (`buyer_id`),
  CONSTRAINT `fk_pesanan_buyer` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `detail_pesanan` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `pesanan_id` INT UNSIGNED NOT NULL,
  `produk_id` INT UNSIGNED NOT NULL,
  `jumlah` INT NOT NULL DEFAULT 1,
  `harga_satuan` INT NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_detail_pesanan_id` (`pesanan_id`),
  KEY `idx_detail_produk_id` (`produk_id`),
  CONSTRAINT `fk_detail_pesanan` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_detail_produk` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `saldo` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED NOT NULL,
  `jumlah_saldo` INT NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_saldo_user_id` (`user_id`),
  CONSTRAINT `fk_saldo_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`nama`, `email`, `password`, `role`, `status_akun`)
VALUES
('Admin', 'admin@simulator.test', '$2y$10$uQh9wPjaQ4A4fQ0Mbc8fH.5iFOovM0jI7ZfR4mPjD0qPG8g8eWkzu', 'admin', 'active'),
('Seller Demo', 'seller@simulator.test', '$2y$10$uQh9wPjaQ4A4fQ0Mbc8fH.5iFOovM0jI7ZfR4mPjD0qPG8g8eWkzu', 'seller', 'active'),
('Buyer Demo', 'buyer@simulator.test', '$2y$10$uQh9wPjaQ4A4fQ0Mbc8fH.5iFOovM0jI7ZfR4mPjD0qPG8g8eWkzu', 'buyer', 'active')
ON DUPLICATE KEY UPDATE `nama` = VALUES(`nama`);

INSERT INTO `toko` (`user_id`, `nama_toko`, `alamat_toko`)
SELECT u.id, 'Toko Demo', 'Alamat Demo'
FROM users u
WHERE u.email = 'seller@simulator.test'
AND NOT EXISTS (
  SELECT 1 FROM toko t WHERE t.user_id = u.id
);

INSERT INTO `saldo` (`user_id`, `jumlah_saldo`)
SELECT id, 1000000 FROM users
ON DUPLICATE KEY UPDATE `jumlah_saldo` = VALUES(`jumlah_saldo`);

INSERT INTO `produk` (`toko_id`, `nama_produk`, `harga`, `stok`, `foto`, `deskripsi`)
SELECT t.id, 'Sepatu Running', 250000, 20, 'sepatu.jpg', 'Sepatu nyaman untuk olahraga harian.'
FROM toko t
JOIN users u ON u.id = t.user_id
WHERE u.email = 'seller@simulator.test'
AND NOT EXISTS (
  SELECT 1 FROM produk p WHERE p.nama_produk = 'Sepatu Running'
);

INSERT INTO `produk` (`toko_id`, `nama_produk`, `harga`, `stok`, `foto`, `deskripsi`)
SELECT t.id, 'Tas Kasual', 180000, 15, 'tas.jpg', 'Tas kasual untuk aktivitas sehari-hari.'
FROM toko t
JOIN users u ON u.id = t.user_id
WHERE u.email = 'seller@simulator.test'
AND NOT EXISTS (
  SELECT 1 FROM produk p WHERE p.nama_produk = 'Tas Kasual'
);
