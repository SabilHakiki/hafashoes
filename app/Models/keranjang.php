<?php

namespace App\Models;

use CodeIgniter\Model;

class Keranjang extends Model
{
    protected $table = 'keranjang';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id',
        'id_user',
        'id_produk',
        'gmbr',
        'nama',
        'harga',
        'jumlah',
        'subtotal',
    ];

    public function getproduk($id)
    {
        return $this->select('keranjang.id AS id_keranjang, keranjang.*, produk.stok, produk.gmbr AS gmbr_produk')
            ->join('produk', 'keranjang.id_produk = produk.id')
            ->where('keranjang.id_user', $id)
            ->findAll();
    }
}
