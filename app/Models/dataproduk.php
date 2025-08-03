<?php

namespace App\Models;

use CodeIgniter\Model;

class dataproduk extends Model
{
    protected $table = 'produk';
    protected $primarykey = "id";
    protected $useautoincrement = true;
    protected $allowedFields = ['gmbr', 'nama', 'kategori', 'harga', 'stok', 'deskripsi', 'created_at'];

    public function fullkategori()
    {
        return $this->join('kategori', 'produk.kategori = kategori.id_kategori')
            ->orderBy('id', 'DESC')
            ->findAll();
    }
}
