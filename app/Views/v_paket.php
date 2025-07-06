<?= $this->extend('layout') ?>
<?= $this->section('content') ?> 

<?php if (session()->getFlashData('success')): ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashData('failed')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('failed') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
    Tambah Paket
</button>

<!-- Table with stripped rows -->
<table class="table datatable">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Paket</th>
            <th>Harga</th>
            <th>Durasi (jam)</th>
            <th>Jumlah Meja</th>
            <th>Bonus</th>
            <th>Foto</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($paket as $index => $item): ?>
            <tr>
                <th><?= $index + 1 ?></th>
                <td><?= $item['nama_paket'] ?></td>
                <td><?= $item['harga'] ?></td>
                <td><?= $item['durasi_jam'] ?></td>
                <td><?= $item['jumlah_meja'] ?? '-' ?></td>
                <td><?= $item['bonus'] ?></td>
                <td>
                    <?php if (!empty($item['foto']) && file_exists("img/" . $item['foto'])): ?>
                        <img src="<?= base_url("img/" . $item['foto']) ?>" width="100px">
                    <?php endif; ?>
                </td>
                <td>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal-<?= $item['id'] ?>">
                        Ubah
                    </button>
                    <a href="<?= base_url('paket/delete/' . $item['id']) ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus paket ini?')">
                        Hapus
                    </a>
                </td>
            </tr>

            <!-- Edit Modal Begin -->
            <div class="modal fade" id="editModal-<?= $item['id'] ?>" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Paket</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="<?= base_url('paket/edit/' . $item['id']) ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="modal-body">
                                <div class="form-group mb-2">
                                    <label>Nama Paket</label>
                                    <input type="text" name="nama_paket" class="form-control" value="<?= $item['nama_paket'] ?>" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label>Harga</label>
                                    <input type="text" name="harga" class="form-control" value="<?= $item['harga'] ?>" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label>Durasi (jam)</label>
                                    <input type="number" name="durasi_jam" class="form-control" value="<?= $item['durasi_jam'] ?>" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label>Jumlah Meja</label>
                                    <input type="number" name="jumlah_meja" class="form-control" value="<?= $item['jumlah_meja'] ?? 1 ?>" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label>Bonus</label>
                                    <input type="text" name="bonus" class="form-control" value="<?= $item['bonus'] ?>">
                                </div>
                                <img src="<?= base_url("img/" . $item['foto']) ?>" width="100px" class="my-2">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="check" value="1" id="check-<?= $item['id'] ?>">
                                    <label class="form-check-label" for="check-<?= $item['id'] ?>">
                                        Ceklis jika ingin mengganti foto
                                    </label>
                                </div>
                                <div class="form-group mb-2">
                                    <label>Foto</label>
                                    <input type="file" class="form-control" name="foto">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Edit Modal End -->
        <?php endforeach ?>
    </tbody>
</table>

<!-- Add Modal Begin -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Paket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('paket') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label>Nama Paket</label>
                        <input type="text" name="nama_paket" class="form-control" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Harga</label>
                        <input type="text" name="harga" class="form-control" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Durasi (jam)</label>
                        <input type="number" name="durasi_jam" class="form-control" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Jumlah Meja</label>
                        <input type="number" name="jumlah_meja" class="form-control" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Bonus</label>
                        <input type="text" name="bonus" class="form-control">
                    </div>
                    <div class="form-group mb-2">
                        <label>Foto</label>    
                        <input type="file" class="form-control" name="foto">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add Modal End -->

<?= $this->endSection() ?>
