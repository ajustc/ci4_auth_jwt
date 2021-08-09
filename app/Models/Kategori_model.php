<?php

namespace App\Models;

use CodeIgniter\Model;

class Kategori_model extends Model
{
    protected $table = "kategori";

    public function getKategori()
    {
        return $this->findAll();
    }
}
