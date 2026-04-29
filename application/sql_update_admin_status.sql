ALTER TABLE `users`
ADD COLUMN `status_akun` ENUM('pending','active','blocked') NOT NULL DEFAULT 'active' AFTER `role`;
