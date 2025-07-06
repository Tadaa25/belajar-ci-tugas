<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashData('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif ?>

<!-- Paket Billiard Grid -->
<div class="row">
    <?php foreach ($product as $item) : ?>
        <div class="col-lg-6 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <img src="<?= base_url("img/" . esc($item['foto'])) ?>" alt="<?= esc($item['nama_paket']) ?>" width="300px">
                    <h5 class="card-title mt-3">
                        <?= esc($item['nama_paket']) ?><br>
                        <?= number_to_currency($item['harga'], 'IDR') ?>
                    </h5>
                    <button 
                        type="button" 
                        class="btn btn-info rounded-pill mt-3 btn-beli"
                        data-id="<?= esc($item['id']) ?>"
                        data-nama="<?= esc($item['nama_paket']) ?>"
                        data-harga="<?= esc($item['harga']) ?>"
                        data-foto="<?= esc($item['foto']) ?>"
                    >
                        Beli
                    </button>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>

<!-- Script: Kirim ke API -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll('.btn-beli');

    buttons.forEach(button => {
        button.addEventListener('click', async function () {
            const data = {
                id_produk: this.dataset.id,
                nama_produk: this.dataset.nama,
                harga: this.dataset.harga,
                foto: this.dataset.foto
            };

            try {
                const response = await fetch("<?= base_url('api/keranjang') ?>", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (response.ok) {
                    alert("✔️ Produk berhasil dimasukkan ke keranjang.");
                } else {
                    alert("❌ Gagal: " + (result.message ?? "Data tidak valid"));
                }
            } catch (error) {
                console.error(error);
                alert("❌ Terjadi kesalahan saat menghubungi server.");
            }
        });
    });
});
</script>

<?= $this->endSection() ?>
