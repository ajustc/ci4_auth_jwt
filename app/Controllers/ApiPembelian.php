<?php

namespace App\Controllers;

use Firebase\JWT\JWT;
use App\Controllers\ApiAuth;
use CodeIgniter\RESTful\ResourceController;

// header
header("Access-Control-Allow-Origin: * ");
header("Access-Control-Allow-Method: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Content-Type: application/json;  charset=utf8");

class ApiPembelian extends ResourceController
{
    protected $pembelianModel;
    protected $controlAuth;

    public function __construct()
    {
        $this->pembelianModel = new \App\Models\Pembelian_model();
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
                        'data' => $this->pembelianModel->getPembelian($idp)
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

    public function create($data = false)
    {
        $data = [
            'id_pelanggan' => $this->request->getVar('id_pelanggan'),
            'id_promo' => $this->request->getVar('id_promo'),
            'tanggal_pembelian' => $this->request->getVar('tanggal_pembelian'),
            'total_pembelian' => $this->request->getVar('total_pembelian'),
            'alamat_pengiriman' => $this->request->getVar('alamat_pengiriman'),
            'totalberat' => $this->request->getVar('totalberat'),
            'provinsi' => $this->request->getVar('provinsi'),
            'distrik' => $this->request->getVar('distrik'),
            'tipe' => $this->request->getVar('tipe'),
            'kodepos' => $this->request->getVar('kodepos'),
            'ekspedisi' => $this->request->getVar('ekspedisi'),
            'paket' => $this->request->getVar('paket'),
            'ongkir' => $this->request->getVar('ongkir'),
            'estimasi' => $this->request->getVar('estimasi'),
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

                $result = $this->pembelianModel->setPembelian($data);
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

    public function update($idp = null)
    {
        $idp = $_GET['id'];

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

                $result = $this->pembelianModel->setStatusPembelian($idp);
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

    public function gettotalpromoterpakai($idp = null)
    {
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

                $result = $this->pembelianModel->getPembelian($idp);
                if ($decoded) {
                    // halaman akses
                    $output = [
                        'message' => 'Access granted!',
                        'data' => $this->pembelianModel->gettotalpromoterpakai($idp)
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
}
