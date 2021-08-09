<?php

namespace App\Models;

use CodeIgniter\Model;

class RiwayatBelanja_model extends Model
{
    protected $table = "pembelian";

    public function getAll($idp = null)
    {
        // if ($idp == false) {
        //     return $this->findAll();
        // }
        return $this->where(['id_pelanggan' => $idp])
            // ->get()->getRowArray();
            ->get()->getResult();
    }
}
