<?php

namespace App\Controllers;

use App\Controllers\ApiAuth;
use CodeIgniter\RESTful\ResourceController;

// header
header("Access-Control-Allow-Origin: * ");
header("Access-Control-Allow-Method: * ");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Content-Type: application/json;  charset=utf8");

class ApiKategori extends ResourceController
{
    protected $kategoriModel;
    protected $controlAuth;

    public function __construct()
    {
        $this->kategoriModel = new \App\Models\Kategori_model();
        $this->controlAuth = new ApiAuth();
    }

    public function index()
    {
        $data = [
            'data' => $this->kategoriModel->getKategori()
        ];

        return $this->respond($data, 200);
    }
}
