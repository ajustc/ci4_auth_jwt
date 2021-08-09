<?php

namespace App\Models;

use CodeIgniter\Model;

class Produk_model extends Model
{
    protected $table = "produk";
    protected $allowedFields = [
        'stok_produk',
        'terlaris'
    ];

    public function getAll($idp = false)
    {
        if ($idp == false) {
            return $this->findAll();
        }
        return $this->where(['id_produk' => $idp])->first();
    }

    public function getProdukKategori($idk)
    {
        return $this->where(['id_kategori' => $idk])->get()->getResultArray();
    }

    public function getProdukRekomendasi($rk)
    {
        if ($rk == false) {
            return $this->findAll();
        }
        return $this->where(['rekomendasi' => $rk])->get()->getResultArray();
    }

    public function updateStok($data, $id)
    {
        // if ($data == false && $id == false) {
        //     // return $this->findAll();
        // }
        // gives UPDATE mytable SET field = field+1 WHERE `id` = 2
        // return $this->where('id_produk', $id)->update($data);
        // return $this->update($data, ['id_produk' => $id]);
        return $this->db->table($this->table)->update($data, ['id_produk' => $id]);
        // return $this->update($data, ['id_produk' => $id]);
        // return $this->set("stok_produk", "stok_produk+$data")
        //     ->where('id_produk', $id)->update();
    }
}
