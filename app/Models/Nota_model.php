<?php

namespace App\Models;

use CodeIgniter\Model;

class Nota_model extends Model
{
    protected $table = "pembelian";

    public function getNota($idp = false)
    {
        if ($idp == false) {
            return $this->findAll();
        }
        return $this->join('pelanggan', 'pembelian.id_pelanggan = pelanggan.id_pelanggan')
            ->where("pembelian.id_pembelian=$idp")->first();
    }
}
