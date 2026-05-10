<!DOCTYPE html> 
<html> 
<head> 
<title>Dashboard</title> 
</head> 
<body> 
<h1><?= $title ?></h1>
<p>Selamat datang, <b><?= html_escape($nama) ?></b> (<?= html_escape($username) ?>)</p>
<p>Role aktif: <b><?= html_escape($role) ?></b></p>

<?php if ($role === 'ADMIN'): ?>
<p>Akses Admin: Kelola user, data master, laporan.</p>
<?php elseif ($role === 'MEKANIK'): ?>
<p>Akses Mekanik: Lihat daftar servis, update status pengerjaan.</p>
<?php elseif ($role === 'KASIR'): ?>
<p>Akses Kasir: Kelola transaksi pembayaran, verifikasi pelunasan.</p>
<?php endif; ?>

<a href="<?= base_url('login/logout') ?>">Log out</a> 
</body> 
</html> 