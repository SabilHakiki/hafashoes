<?php

namespace App\Models;

use CodeIgniter\Model;

class Akun extends Model
{
    protected $table = 'users';
    protected $primarykey = "id";
    protected $useautoincrement = true;
    protected $allowedFields = ['id', 'nama', 'foto', 'email', 'nohp', 'alamat', 'destination_id', 'destination_label', 'password', 'role'];

    protected $returnType = 'array';
}
