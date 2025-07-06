<?php

namespace App\Controllers;

use App\Models\PaketModel;
use Dompdf\Dompdf;

class PaketController extends BaseController
{
    protected $paket;

    public function __construct()
    {
        $this->paket = new PaketModel();
    }

    public function index()
    {
        $data['paket'] = $this->paket->findAll();
        return view('v_paket', $data);
    }

    public function create()
{
    $dataFoto = $this->request->getFile('foto');

    $dataForm = [
        'nama_paket'   => $this->request->getPost('nama_paket'),
        'harga'        => $this->request->getPost('harga'),
        'durasi_jam'   => $this->request->getPost('durasi_jam'),
        'bonus'        => $this->request->getPost('bonus'),
        'jumlah_meja'  => $this->request->getPost('jumlah_meja'),
        'created_at'   => date("Y-m-d H:i:s")
    ];

    if ($dataFoto->isValid()) {
        $fileName = $dataFoto->getRandomName();
        $dataForm['foto'] = $fileName;
        $dataFoto->move('img/', $fileName);
    }

    $this->paket->insert($dataForm);

    return redirect('paket')->with('success', 'Data Paket Berhasil Ditambah');
}


    public function edit($id)
{
    $dataPaket = $this->paket->find($id);

    $dataForm = [
        'nama_paket'   => $this->request->getPost('nama_paket'),
        'harga'        => $this->request->getPost('harga'),
        'durasi_jam'   => $this->request->getPost('durasi_jam'),
        'bonus'        => $this->request->getPost('bonus'),
        'jumlah_meja'  => $this->request->getPost('jumlah_meja'),
        'updated_at'   => date("Y-m-d H:i:s")
    ];

    if ($this->request->getPost('check') == 1) {
        if ($dataPaket['foto'] != '' && file_exists("img/" . $dataPaket['foto'])) {
            unlink("img/" . $dataPaket['foto']);
        }

        $dataFoto = $this->request->getFile('foto');

        if ($dataFoto->isValid()) {
            $fileName = $dataFoto->getRandomName();
            $dataFoto->move('img/', $fileName);
            $dataForm['foto'] = $fileName;
        }
    }

    $this->paket->update($id, $dataForm);

    return redirect('paket')->with('success', 'Data Paket Berhasil Diubah');
}


    public function delete($id)
    {
        $dataPaket = $this->paket->find($id);

        if ($dataPaket['foto'] != '' && file_exists("img/" . $dataPaket['foto'])) {
            unlink("img/" . $dataPaket['foto']);
        }

        $this->paket->delete($id);

        return redirect('paket')->with('success', 'Data Paket Berhasil Dihapus');
    }

    public function download()
    {
        $paket = $this->paket->findAll();
        $html = view('v_paketPDF', ['paket' => $paket]);

        $filename = date('Y-m-d-H-i-s') . '-paket';

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream($filename);
    }
}
