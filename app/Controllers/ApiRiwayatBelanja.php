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

class ApiRiwayatBelanja extends ResourceController
{
    protected $riwayatbelanjaModel;
    protected $controlAuth;

    public function __construct()
    {
        $this->riwayatbelanjaModel = new \App\Models\RiwayatBelanja_model();
        $this->controlAuth = new ApiAuth();
    }

    public function show($idp = null)
    {
        $idp = $this->request->getVar('id_pelanggan');

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
                        'data' => $this->riwayatbelanjaModel->getAll($idp)
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
