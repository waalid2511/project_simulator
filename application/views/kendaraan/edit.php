<?php $this->load->view('_partials/header'); ?>
<?php $this->load->view('_partials/navbar'); ?>

<h3>Edit Kendaraan</h3>

<form method="post" action="<?= base_url('kendaraan/update/'.$kendaraan->id_kendaraan) ?>">

<select name="id_pelanggan">
<?php foreach ($pelanggan as $p): ?>
    <option value="<?= $p->id_pelanggan ?>"
    <?= ($kendaraan->id_pelanggan == $p->id_pelanggan) ? 'selected' : '' ?>>
    <?= $p->nama ?>
    </option>
<?php endforeach; ?>
</select><br><br>

<input type="text" name="merk" value="<?= $kendaraan->merk ?>"><br><br>
<input type="text" name="tipe" value="<?= $kendaraan->tipe ?>"><br><br>
<input type="text" name="no_polisi" value="<?= $kendaraan->no_polisi ?>"><br><br>

<button type="submit">Update</button>

</form>

<?php $this->load->view('_partials/footer'); ?>