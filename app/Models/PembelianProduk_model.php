<?php

namespace App\Models;

use CodeIgniter\Model;

class PembelianProduk_model extends Model
{
    protected $table = "pembelian_produk";
    protected $allowedFields = [
        'id_pembelian',
        'id_produk',
        'id_promo',
        'nama',
        'harga',
        'berat',
        'subberat',
        'subharga',
        'jumlah',
    ];

    public function getAll($idp = false)
    {
        if ($idp == null) {
            return $this->findAll();
        }
        return $this->where(['id_pembelian' => $idp])->get()->getResultArray();
    }

    public function getTotalPembelianProduk()
    {
        return $this->select('id_pembelian_produk, id_produk, nama')->selectSum('jumlah')->selectSum('harga')
            // ->groupBy('id_produk')->orderBy('jumlah DESC, harga ASC')->findAll();
            ->groupBy('id_produk')->orderBy('jumlah DESC, harga ASC')->get()->getResultArray();
    }

    public function setPembelianProduk($data)
    {
        if ($data == null) {
            return $this->findAll();
        }
        return $this->insert($data);
    }

    public function setProdukTerlaris($data, $id)
    {
        // if ($data == null) {
        //     return $this->db->table($this->table)->insert($data);
        // }
        return $this->db->table($this->table)->update($data, ['id_produk' => $id]);
    }
}
