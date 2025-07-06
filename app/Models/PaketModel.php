<?php

namespace App\Models;

use CodeIgniter\Model;

class PaketModel extends Model
{
    protected $table = 'paket';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_paket', 'deskripsi', 'harga', 'gambar', 'durasi_jam', 'bonus', 'foto', 'jumlah_meja'];


    public $usetimestamps = true;
}
