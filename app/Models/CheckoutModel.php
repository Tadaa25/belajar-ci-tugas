<?php


namespace App\Models;

use CodeIgniter\Model;

class CheckoutModel extends Model
{
    protected $table = 'checkout';
    protected $primaryKey = 'id';

    protected $allowedFields = ['nama', 'total_harga'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
}

