<?php

namespace App\Models;

use CodeIgniter\Model;

class order extends Model
{
    protected $table = 'order';
    protected $primarykey = "id";
    protected $useautoincrement = true;
    protected $allowedFields = ['id', 'id_user', 'order_number', 'nama_pembeli', 'total_harga', 'ongkir', 'grand_total', 'status', 'tanggal_pesanan', 'tanggal_pengiriman', 'alamat_pengiriman', 'kurir_id', 'kurir', 'layanan', 'snap_token', 'no_resi', 'metode_pembayaran', 'created_at'];

    public function getOrderWithPelanggan()
    {
        return $this->select('order.*, users.nama as nama_user, users.nohp, users.alamat')
            ->join('users', 'users.id = order.id_user')
            ->orderBy('order.tanggal_pengiriman', 'DESC')
            ->findAll();
    }
}
