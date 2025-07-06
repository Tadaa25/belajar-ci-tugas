<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashData('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<h4 class="mb-4">Keranjang Anda</h4>

<!-- Table -->
<table class="table datatable table-bordered">
    <thead class="text-center">
        <tr>
            <th>Nama</th>
            <th>Foto</th>
            <th>Harga</th>
            <th>Jumlah Pesan</th>
            <th>Subtotal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($items)) : ?>
            <?php foreach ($items as $item) : ?>
                <tr class="align-middle text-center">
                    <td><?= esc($item['nama_produk']) ?></td>
                    <td>
                        <img src="<?= base_url('img/' . $item['foto']) ?>" alt="foto" width="100px">
                    </td>
                    <td><?= number_to_currency($item['harga'], 'IDR') ?></td>
                    <td><?= $item['jumlah_pesan'] ?? 1 ?></td>
                    <td><?= number_to_currency($item['harga'] * ($item['jumlah_pesan'] ?? 1), 'IDR') ?></td>
                    <td>
                        <a href="<?= base_url('keranjang/delete/' . $item['id']) ?>" class="btn btn-danger">
                            🗑️ Hapus
                        </a>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php else : ?>
            <tr>
                <td colspan="6" class="text-center">Keranjang Kosong</td>
            </tr>
        <?php endif ?>
    </tbody>
</table>

<!-- Total dan tombol -->
<div class="alert alert-info">
    <strong>Total:</strong> <?= number_to_currency($total, 'IDR') ?>
</div>

<?php if (!empty($items)) : ?>
    <a class="btn btn-success" href="<?= base_url('checkout') ?>">Selesai Belanja</a>
<?php endif ?>

<?= $this->endSection() ?>
