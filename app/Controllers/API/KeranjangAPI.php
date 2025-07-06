<?php

namespace App\Controllers\API;

use App\Models\KeranjangModel;
use App\Models\PaketModel;
use CodeIgniter\RESTful\ResourceController;

class KeranjangAPI extends ResourceController
{
    protected $modelName = KeranjangModel::class;
    protected $format    = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll(), 200);
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);
        if (!$data) {
            return $this->failNotFound("Item keranjang dengan ID $id tidak ditemukan.");
        }
        return $this->respond($data);
    }

    public function create()
{
    $input = $this->request->getJSON(true);
    $jumlahPesan = $input['jumlah_pesan'] ?? 1;

    // Ambil data paket
    $paketModel = new PaketModel();
    $paket = $paketModel->find($input['id_produk']);

    if (!$paket) {
        return $this->failNotFound('Paket tidak ditemukan.');
    }

    // Cek apakah jumlah meja cukup
    if ($paket['jumlah_meja'] < $jumlahPesan) {
        return $this->fail('Stok meja tidak mencukupi. Tersisa: ' . $paket['jumlah_meja']);
    }

    // Masukkan ke keranjang
    $insert = [
        'id_produk'     => $input['id_produk'],
        'nama_produk'   => $paket['nama_paket'],
        'harga'         => $paket['harga'],
        'foto'          => $paket['foto'],
        'jumlah_pesan'  => $jumlahPesan,
    ];

    if (!$this->model->insert($insert)) {
        return $this->failValidationErrors($this->model->errors());
    }

    return $this->respondCreated(['message' => 'Item berhasil ditambahkan']);
}



    public function update($id = null)
    {
        $input = $this->request->getRawInput();

        if (!$this->model->update($id, $input)) {
            return $this->failValidationErrors($this->model->errors());
        }

        return $this->respond(['message' => 'Item berhasil diupdate']);
    }

    public function delete($id = null)
    {
        if (!$this->model->find($id)) {
            return $this->failNotFound("Item dengan ID $id tidak ditemukan.");
        }

        $this->model->delete($id);
        return $this->respondDeleted(['message' => 'Item berhasil dihapus']);
    }
}
