<?php

namespace App\Models;

use CodeIgniter\Model;

class Pembayaran_model extends Model
{
    protected $table = "pembayaran";
    protected $allowedFields = [
        'id_pembelian',
        'nama',
        'bank',
        'jumlah',
        'tanggal',
        'bukti'
    ];

    public function getById($id)
    {
        // if ($id == null) {
        //     return $this->
        // }
        return $this->join('pembelian', 'pembayaran.id_pembelian = pembelian.id_pembelian', 'left')
            ->where("pembelian.id_pembelian=$id")->first();
    }

    public function setPembayaran($data)
    {
        $query = $this->db->table($this->table)->insert($data);
        return $query ? true : false;
        // return $this->insert($data);
    }
}
