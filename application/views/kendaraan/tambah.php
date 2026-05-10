<?php $this->load->view('_partials/header'); ?>
<?php $this->load->view('_partials/navbar'); ?>

<div class="container mt-4">

    <div class="card shadow-sm">
        <div class="card-body">

            <h4>Tambah Kendaraan</h4>

            <form method="post" action="<?= base_url('kendaraan/simpan') ?>">

                <div class="mb-3">
                    <label>Pelanggan</label>
                    <select name="id_pelanggan" class="form-control" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        <?php foreach ($pelanggan as $p): ?>
                            <option value="<?= $p->id_pelanggan ?>"><?= $p->nama ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Merk</label>
                    <input type="text" name="merk" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Tipe</label>
                    <input type="text" name="tipe" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>No Polisi</label>
                    <input type="text" name="no_polisi" class="form-control" required>
                </div>

                <button class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('kendaraan') ?>" class="btn btn-secondary">Kembali</a>

            </form>

        </div>
    </div>

</div>

<?php $this->load->view('_partials/footer'); ?>