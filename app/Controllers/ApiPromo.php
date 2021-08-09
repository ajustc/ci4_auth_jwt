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

class ApiPromo extends ResourceController
{
    protected $promoModel;
    protected $controlAuth;

    public function __construct()
    {
        $this->promoModel = new \App\Models\Promo_model();
        $this->controlAuth = new ApiAuth();
    }

    public function show($name = null)
    {
        $name = $_GET['promo'];
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
                        'data' => $this->promoModel->getPromoByName($name)
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

    public function update($id = null)
    {
        // getRawInput gabisa di react native
        // $data = $this->request->getRawInput();

        $data = [
            'promo_terpakai' => $this->request->getVar('promo_terpakai'),
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
                $result = $this->promoModel->updateStok($data, $id);

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
}
