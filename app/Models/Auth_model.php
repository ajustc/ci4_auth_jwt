<?php

namespace App\Models;

use CodeIgniter\Model;

class Auth_model extends Model
{
    protected $table = "pelanggan";

    public function register($data)
    {
        $query = $this->db->table($this->table)->insert($data);
        return $query ? true : false;
    }

    public function checklogin($email)
    {
        $query = $this->table($this->table)
            ->where('email_pelanggan', $email)->countAll();

        // checkdata
        if ($query > 0) {
            $hasil = $this->table($this->table)
                ->where('email_pelanggan', $email)
                ->limit(1)
                ->get()->getRowArray();
        } else {
            // $hasil = $hasil();
            $hasil = array();
        }
        return $hasil;
    }
}
