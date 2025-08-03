<?php

namespace App\Models;

use CodeIgniter\Model;

class kategori extends Model
{
    protected $table = 'kategori';
    protected $primarykey = "id";
    protected $useautoincrement = true;
    protected $allowedFields = ['id_kategori', 'nkategori'];
}
