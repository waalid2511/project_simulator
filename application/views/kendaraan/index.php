<?php $this->load->view('_partials/header'); ?>
<?php $this->load->view('_partials/navbar'); ?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2>Daftar Kendaraan</h2>
            <small class="text-muted">Data kendaraan pelanggan</small>
        </div>

        <a href="<?= base_url('kendaraan/tambah') ?>" class="btn btn-success">
            + Tambah Kendaraan
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-bordered table-hover">
                <thead class="table-primary text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Pelanggan</th>
                        <th>Merk</th>
                        <th>Tipe</th>
                        <th>No Polisi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                <?php $no=1; foreach($kendaraan as $k): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= $k->nama ?></td>
                        <td><?= $k->merk ?></td>
                        <td><?= $k->tipe ?></td>
                        <td><?= $k->no_polisi ?></td>
                        <td class="text-center">
                            <a href="<?= base_url('kendaraan/edit/'.$k->id_kendaraan) ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="<?= base_url('kendaraan/hapus/'.$k->id_kendaraan) ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Yakin hapus?')">
                               Hapus
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>

            </table>

        </div>
    </div>

</div>

<?php $this->load->view('_partials/footer'); ?>