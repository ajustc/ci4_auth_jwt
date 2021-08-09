<?php

namespace App\Controllers;

use Firebase\JWT\JWT;
use App\Controllers\ApiAuth;
use CodeIgniter\RESTful\ResourceController;

// header
header("Access-Control-Allow-Origin: * ");
header("Access-Control-Allow-Method: * ");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Content-Type: application/json;  charset=utf8");

class ApiProduk extends ResourceController
{
    protected $produkModel;
    protected $controlAuth;

    public function __construct()
    {
        $this->produkModel = new \App\Models\Produk_model();
        $this->controlAuth = new ApiAuth();
    }

    public function index()
    {
        $data = [
            'data' => $this->produkModel->getAll()
        ];

        return $this->respond($data, 200);
    }

    public function show($idp = null)
    {
        $idp = $_GET['id_produk'];
        $data = [
            // 'data' => $this->produkModel->getAll($id),
            'data' => $this->produkModel->getAll($idp)
        ];

        return $this->respond($data, 200);
    }

    public function update($id = null)
    {
        $data = $this->request->getRawInput();

        // Ambil secret key dari Contoller-Auth
        $secretkey = $this->controlAuth->privateKey();

        $token = null;

        $authHeader = $this->request->getServer("HTTP_AUTHORIZATION");

        $arr = explode(" ", $authHeader);

        $token = $arr[1];

        // Validasi token jika ingin menggunakan data
        if ($token) {
            try {
                $decoded = JWT::decode($token, $secretkey, array("HS256"));
                $result = $this->produkModel->updateStok($data, $id);

                if ($decoded && $result) {
                    // halaman akses
                    $output = [
                        'message' => 'Access granted!',
                        'data' => $result
                    ];
                    return $this->respond($output, 200);
                }
            } catch (\Exception $e) {
                $output = [
                    'message' => 'Access denied!',
                    'error' => $e->getMessage()
                ];
                return $this->respond($output, 500);
            }
        }
    }

    public function getkategori($idk = null)
    {
        $idk = $this->request->getVar('id');

        $data = [
            'data' => $this->produkModel->getProdukKategori($idk)
        ];

        return $this->respond($data, 200);
    }

    public function getrekomendasi($rk = null)
    {
        $rk = $this->request->getVar('rekomendasi');

        $data = [
            'data' => $this->produkModel->getProdukRekomendasi($rk)
        ];

        return $this->respond($data, 200);
    }
}
