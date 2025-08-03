<?php

namespace App\Models;

use CodeIgniter\Model;

class orderdetail extends Model
{
    protected $table = 'order_detail';
    protected $primarykey = "id";
    protected $useautoincrement = true;
    protected $allowedFields = ['id', 'id_order', 'id_produk', 'jumlah', 'harga', 'subtotal'];

    public function getOrderDetailsWithProduk($id)
    {
        return $this->select('order_detail.*, produk.nama AS nama')
            ->join('produk', 'produk.id = order_detail.id_produk')
            ->where('order_detail.id_order', $id)
            ->findAll();
    }

    public function getDetailsByOrderId($orderId)
    {
        return $this->select('order_detail.*, produk.nama AS nama')
            ->join('produk', 'produk.id = order_detail.id_produk')
            ->where('order_detail.id_order', $orderId)
            ->findAll();
    }
}
