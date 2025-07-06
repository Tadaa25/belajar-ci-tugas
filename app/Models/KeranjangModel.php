<?php

namespace App\Models;

use CodeIgniter\Model;

class KeranjangModel extends Model
{
    protected $table = 'keranjang';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_produk', 'nama_produk', 'harga', 'foto'];
    protected $useTimestamps = true;
}
