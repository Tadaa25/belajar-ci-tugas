<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h4>Riwayat Transaksi</h4>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Total Harga</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($riwayat)) : ?>
            <?php foreach ($riwayat as $item) : ?>
                <tr>
                    <td><?= esc($item['nama']) ?></td>
                    <td><?= number_to_currency($item['total_harga'], 'IDR') ?></td>
                    <td><?= date('d M Y H:i', strtotime($item['created_at'])) ?></td>
                </tr>
            <?php endforeach ?>
        <?php else : ?>
            <tr><td colspan="3" class="text-center">Belum ada transaksi.</td></tr>
        <?php endif ?>
    </tbody>
</table>

<?= $this->endSection() ?>