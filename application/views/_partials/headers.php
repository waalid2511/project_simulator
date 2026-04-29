<!DOCTYPE html>
<html lang="en">
<head> 
<meta charset="UTF-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<?php
$ci = &get_instance();
$titlePage = isset($titlePage) ? $titlePage : 'Sistem Manajemen Bengkel';
?>
<title><?= html_escape($titlePage) ?></title> 

<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body { background-color: #f8f9fa; }
    .glass-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        border-radius: 12px;
    }
</style>
</head> 

<body> 

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4"> 
<div class="container"> 
<a class="navbar-brand fw-bold" href="<?= base_url('login') ?>">Bengkel Motor</a> 

<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
    <span class="navbar-toggler-icon"></span> 
</button> 

<div class="collapse navbar-collapse" id="navbarNav"> 
<ul class="navbar-nav ms-auto"> 

<?php if ($this->session->userdata('logged_in')): ?>
    <li class="nav-item">
        <a class="nav-link text-white" href="#">Halo, <?= html_escape($this->session->userdata('nama')) ?></a>
    </li>
<?php endif; ?>

</ul> 
</div> 

</div> 
</nav>