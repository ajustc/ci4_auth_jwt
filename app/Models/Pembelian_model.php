<?php

namespace App\Models;

use CodeIgniter\Model;

class Pembelian_model extends Model
{
    protected $table = "pembelian";
    protected $allowedFields = [
        'id_pembelian',
        'id_pelanggan',
        'id_produk',
        'id_promo',
        'tanggal_pembelian',
        'total_pembelian',
        'alamat_pengiriman',
        'status_pembelian',
        'totalberat',
        'provinsi',
        'distrik',
        'tipe',
        'kodepos',
        'ekspedisi',
        'paket',
        'ongkir',
        'estimasi',
    ];

    public function getPembelian($idp = null)
    {
        if ($idp == null) {
            return $this->findAll();
        }
        return $this->where(['id_pembelian' => $idp])->first();
    }

    public function setPembelian($data = null)
    {
        if ($data == null) {
            return $this->findAll();
        }
        return $this->insert($data);
    }

    public function setStatusPembelian($idp = null)
    {
        return $this->set(['status_pembelian' => 'Sudah kirim pembayaran'])
            ->where(['id_pembelian' => $idp])->update();
    }

    public function gettotalpromoterpakai($idp)
    {
        return $this->select("(SELECT COUNT(id_promo) FROM pembelian WHERE pembelian.id_promo='$idp') AS terpakai")
            ->first();
    }
}
