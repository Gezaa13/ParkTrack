<?php

namespace App\Models;

use CodeIgniter\Model;

class Area extends Model
{
    protected $table         = 'area';
    protected $primaryKey    = 'id_kapasitas';
    protected $allowedFields = [
        'terisi',
        'kapasitas',
    ];
    protected $returnType    = 'array';
}
