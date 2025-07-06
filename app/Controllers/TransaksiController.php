<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;

class TransaksiController extends BaseController
{
    protected $cart;
    protected $client;
    protected $apiKey;
    protected $transaction;
    protected $transaction_detail;

        

    function __construct()
    {
        helper('number');
        helper('form');
        $this->cart = \Config\Services::cart();
        $this->client = new \GuzzleHttp\Client();
        $this->apiKey = env('COST_KEY');
        $this->transaction = new TransactionModel();
        $this->transaction_detail = new TransactionDetailModel();

    }

    public function index()
{
    $keranjangModel = new \App\Models\KeranjangModel();
    $data['items'] = $keranjangModel->findAll();

    // Hitung total harga   
    $total = 0;
    foreach ($data['items'] as $item) {
        $total += $item['harga']; // tambahkan qty kalau ada
    }
    $data['total'] = $total;

    return view('v_keranjang', $data);
}
public function clear()
{
    $keranjangModel = new \App\Models\KeranjangModel();
    $keranjangModel->truncate(); // Hapus semua data
    return redirect()->to('/keranjang')->with('success', 'Keranjang berhasil dikosongkan');
}

public function cart_delete($id)
{
    $keranjangModel = new \App\Models\KeranjangModel();
    $keranjangModel->delete($id);
    return redirect()->to('/keranjang')->with('success', 'Item berhasil dihapus');
}
public function checkout()
{
    $keranjangModel = new \App\Models\KeranjangModel();
    $items = $keranjangModel->findAll();

    $total = 0;
    foreach ($items as $item) {
        $total += $item['harga'];
    }

    return view('v_checkout', [
        'items' => $items,
        'total' => $total
    ]);
}
public function buy()
{
    $checkoutModel = new \App\Models\CheckoutModel();
    $keranjangModel = new \App\Models\KeranjangModel();
    $paketModel = new \App\Models\PaketModel();

    $nama = $this->request->getPost('nama');
    $total = $this->request->getPost('total_harga');

    // 1. Simpan data checkout
    $checkoutModel->insert([
        'nama' => $nama,
        'total_harga' => $total,
        'created_at' => date('Y-m-d H:i:s')
    ]);

    // 2. Kurangi jumlah_meja untuk setiap item di keranjang
    $items = $keranjangModel->findAll();
    foreach ($items as $item) {
        // Ambil data paket berdasarkan nama_produk
        $paket = $paketModel->where('nama_paket', $item['nama_produk'])->first();

        if ($paket && isset($item['jumlah_pesan'])) {
            $sisa = $paket['jumlah_meja'] - $item['jumlah_pesan'];

            // Cek agar tidak minus
            if ($sisa < 0) {
                $sisa = 0;
            }

            $paketModel->update($paket['id'], ['jumlah_meja' => $sisa]);
        }
    }

    // 3. Kosongkan keranjang
    $keranjangModel->truncate();

    return redirect()->to('/')->with('success', 'Checkout berhasil!');
}

public function riwayat()
{
    $checkoutModel = new \App\Models\CheckoutModel();
    $data['riwayat'] = $checkoutModel->orderBy('created_at', 'DESC')->findAll();
    return view('v_riwayat', $data);
}



}
