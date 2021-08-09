<?php

namespace App\Models;

use CodeIgniter\Model;

class Promo_model extends Model
{
    protected $table = "promo";
    protected $allowedFields = [
        'promo_terpakai'
    ];

    public function getPromoByName($name)
    {
        return $this->where('nama_promo', $name)->first();
    }

    public function updateStok($data, $id)
    {
        // if ($data == false && $id == false) {
        //     // return $this->findAll();
        // }
        // gives UPDATE mytable SET field = field+1 WHERE `id` = 2
        // return $this->where('id_produk', $id)->update($data);
        // return $this->update($data, ['id_produk' => $id]);
        return $this->db->table($this->table)->update($data, ['id_promo' => $id]);
        // return $this->update($data, ['id_produk' => $id]);
        // return $this->set("stok_produk", "stok_produk+$data")
        //     ->where('id_produk', $id)->update();
    }
}
