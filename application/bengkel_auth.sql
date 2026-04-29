CREATE DATABASE IF NOT EXISTS `db_bengkel_motor`;
USE `db_bengkel_motor`;

-- Tabel user untuk fitur authorization (login + dashboard)
CREATE TABLE IF NOT EXISTS `user` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` VARCHAR(100) NOT NULL,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin','mekanik','kasir') NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_user_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data akun awal:
-- admin/admin123
-- mekanik/mekanik123
-- kasir/kasir123
INSERT INTO `user` (`nama`, `username`, `password`, `role`) VALUES
('Administrator', 'admin', '$2y$10$2.iCyjri3dausc2E0PS.0eykQUZEGYcjioh.frbsRCR3X6.qMuMTq', 'admin'),
('Mekanik Utama', 'mekanik', '$2y$10$tj.xPl3.EzA4PwEWd66VZ.gZGMpnAXfBZcbCV74tie27G2NWKTRma', 'mekanik'),
('Kasir Utama', 'kasir', '$2y$10$x7vCAaIl3rbn4XbwbTtb6OS7eXeR5OVO2Kt0iOaTCSk4Vp6A1DS5u', 'kasir')
ON DUPLICATE KEY UPDATE
`nama` = VALUES(`nama`),
`password` = VALUES(`password`),
`role` = VALUES(`role`);
