<?php

namespace App\Controllers;

use \Firebase\JWT\JWT;
use App\Controllers\ApiAuth;
use CodeIgniter\RESTful\ResourceController;

class ApiPembayaran extends ResourceController
{
	protected $pembayaranModel;
	protected $controlAuth;

	public function __construct()
	{
		$this->pembayaranModel = new \App\Models\Pembayaran_model();
		$this->controlAuth = new ApiAuth();
	}

	public function show($id = null)
	{
		$id = $_GET["id"];

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
						'data' => $this->pembayaranModel->getById($id)
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

	public function create()
	{
		// getRawInput gabisa di react native
		// $data = $this->request->getRawInput();

		// ngakalinnya jadi getVar deh
		$data = [
			'id_pembelian' => $this->request->getVar('id_pembelian'),
			'nama' => $this->request->getVar('nama'),
			'bank' => $this->request->getVar('bank'),
			'jumlah' => $this->request->getVar('jumlah'),
			'tanggal' => $this->request->getVar('tanggal'),
			'bukti' => $this->request->getVar('bukti'),
		];

		// // Gabisa getPost coiii kalo di react native
		// $firstname = $this->request->getPost('firstname');
		// $lastname = $this->request->getPost('lastname');
		// $email = $th	is->request->getPost('email');
		// $password = $this->request->getPost('password');

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
						'data' => $this->pembayaranModel->setPembayaran($data),
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
