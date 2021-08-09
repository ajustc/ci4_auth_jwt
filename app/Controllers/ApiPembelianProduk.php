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

class ApiPembelianProduk extends ResourceController
{
    protected $pembelianprodukModel;
    protected $controlAuth;

    public function __construct()
    {
        $this->pembelianprodukModel = new \App\Models\PembelianProduk_model();
        $this->controlAuth = new ApiAuth();
    }

    public function show($idp = null)
    {
        $idp = $_GET['id_pembelian'];

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

                if ($decoded) {
                    // halaman akses
                    $output = [
                        'message' => 'Access granted!',
                        'data' => $this->pembelianprodukModel->getAll($idp)
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

    public function create($data = false)
    {
        $data = [
            'id_pembelian' => $this->request->getVar('id_pembelian'),
            'id_produk' => $this->request->getVar('id_produk'),
            'tanggal_pembelian' => $this->request->getVar('tanggal_pembelian'),
            'id_promo' => $this->request->getVar('id_promo'),
            'nama' => $this->request->getVar('nama'),
            'harga' => $this->request->getVar('harga'),
            'berat' => $this->request->getVar('berat'),
            'subberat' => $this->request->getVar('subberat'),
            'subharga' => $this->request->getVar('subharga'),
            'jumlah' => $this->request->getVar('jumlah'),
        ];

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

                $result = $this->pembelianprodukModel->setPembelianProduk($data);
                if ($decoded && $result) {
                    // halaman akses
                    $output = [
                        'message' => 'Access granted!',
                        'data' => $result
                    ];
                    return $this->respond($output, 200);
                    // return $this->respondCreated($output, 201);
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
}
