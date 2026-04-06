<?php

namespace App\Models;

use CodeIgniter\Model;

class Transaksi extends Model
{
    protected $table         = 'transaksi';
    protected $primaryKey    = 'id_transaksi';
    protected $allowedFields = [
        'id_kartu',
        'id_user',
        'waktu_masuk',
        'waktu_keluar',
        'durasi',
        'total',
        'status'
    ];
    protected $returnType    = 'array';
}
