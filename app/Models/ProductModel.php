<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'paket'; // atau 'products' jika tabel kamu bernama 'products'
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'harga', 'durasi_jam', 'bonus', 'foto']; // sesuaikan dengan kolom tabel
}
