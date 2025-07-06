<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h3>Checkout</h3>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif ?>

<form action="<?= base_url('checkout') ?>" method="post">
    <div class="mb-3">
        <label for="nama" class="form-label">Nama Pemesan</label>
        <input type="text" class="form-control" name="nama" required>
    </div>

    <div class="mb-3">
        <label for="total" class="form-label">Total Harga</label>
        <input type="text" class="form-control" value="<?= number_to_currency($total, 'IDR') ?>" disabled>
        <input type="hidden" name="total_harga" value="<?= $total ?>">
    </div>

    <button type="submit" class="btn btn-primary">Proses Checkout</button>
</form>

<?= $this->endSection() ?>
