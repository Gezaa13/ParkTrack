<?php

namespace App\Models;

use CodeIgniter\Model;

class Kendaraan extends Model
{
    protected $table         = 'kendaraan';
    protected $primaryKey    = 'id_kartu';
    protected $allowedFields = [
        'id_kartu',
        'plat_nomor',
        'pemilik',
        'status_aktif'
    ];
    protected $returnType    = 'array';
}
