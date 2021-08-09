<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use \Firebase\JWT\JWT;

class ApiAuth extends ResourceController
{
	protected $authModel;

	public function __construct()
	{
		$this->authModel = new \App\Models\Auth_model();
	}

	public function privateKey()
	{
		$privateKey = <<<EOD
		-----BEGIN RSA PRIVATE KEY-----
		MIICXAIBAAKBgQC8kGa1pSjbSYZVebtTRBLxBz5H4i2p/llLCrEeQhta5kaQu/Rn
		vuER4W8oDH3+3iuIYW4VQAzyqFpwuzjkDI+17t5t0tyazyZ8JXw+KgXTxldMPEL9
		5+qVhgXvwtihXC1c5oGbRlEDvDF6Sa53rcFVsYJ4ehde/zUxo6UvS7UrBQIDAQAB
		AoGAb/MXV46XxCFRxNuB8LyAtmLDgi/xRnTAlMHjSACddwkyKem8//8eZtw9fzxz
		bWZ/1/doQOuHBGYZU8aDzzj59FZ78dyzNFoF91hbvZKkg+6wGyd/LrGVEB+Xre0J
		Nil0GReM2AHDNZUYRv+HYJPIOrB0CRczLQsgFJ8K6aAD6F0CQQDzbpjYdx10qgK1
		cP59UHiHjPZYC0loEsk7s+hUmT3QHerAQJMZWC11Qrn2N+ybwwNblDKv+s5qgMQ5
		5tNoQ9IfAkEAxkyffU6ythpg/H0Ixe1I2rd0GbF05biIzO/i77Det3n4YsJVlDck
		ZkcvY3SK2iRIL4c9yY6hlIhs+K9wXTtGWwJBAO9Dskl48mO7woPR9uD22jDpNSwe
		k90OMepTjzSvlhjbfuPN1IdhqvSJTDychRwn1kIJ7LQZgQ8fVz9OCFZ/6qMCQGOb
		qaGwHmUK6xzpUbbacnYrIM6nLSkXgOAwv7XXCojvY614ILTK3iXiLBOxPu5Eu13k
		eUz9sHyD6vkgZzjtxXECQAkp4Xerf5TGfQXGXhxIX52yH+N2LtujCdkQZjXAsGdm
		B2zNzvrlgRmgBrklMTrMYgm1NPcW+bRLGcwgW2PTvNM=
		-----END RSA PRIVATE KEY-----
		EOD;
		return $privateKey;
	}

	public function publicKey()
	{
		$publicKey = <<<EOD
		-----BEGIN PUBLIC KEY-----
		MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC8kGa1pSjbSYZVebtTRBLxBz5H
		4i2p/llLCrEeQhta5kaQu/RnvuER4W8oDH3+3iuIYW4VQAzyqFpwuzjkDI+17t5t
		0tyazyZ8JXw+KgXTxldMPEL95+qVhgXvwtihXC1c5oGbRlEDvDF6Sa53rcFVsYJ4
		ehde/zUxo6UvS7UrBQIDAQAB
		-----END PUBLIC KEY-----
		EOD;
		return $publicKey;
	}

	public function login()
	{
		// // Gabisa getPost kalo di react native
		// $email = $this->request->getPost('email');
		// $password = $this->request->getPost('password');

		$email = $this->request->getVar('email');
		$password = $this->request->getVar('password');

		// ceklogin
		$ceklogin = $this->authModel->checklogin($email);

		if ($email && $password != null) {
			if (password_verify($password, $ceklogin['password_pelanggan'])) {
				// konfig token
				$secretkey = $this->privateKey();
				$issuer_claim = "THE_CLAIM";
				$audience_claim = "THE_AUDIENCE";
				$issuedat_claim = time();
				$notbefore_claim = $issuedat_claim + 10;
				$expire_claim = $issuedat_claim + 86400; // detik = 1hari
				// $expire_claim = $issuedat_claim + 500; // detik = 5menit

				$token = [
					"iss" => $issuer_claim,
					"aud" => $audience_claim,
					"iat" => $issuedat_claim,
					"nbf" => $notbefore_claim,
					"exp" => $expire_claim,
					"data" => [
						'id_pelanggan' => $ceklogin['id_pelanggan'],
						'nama_pelanggan' => $ceklogin['nama_pelanggan'],
					]
				];

				// generate token
				$token = JWT::encode($token, $secretkey, 'HS256');

				$output = [
					'status' => 200,
					'message' => 'Login Berhasil',
					'user_id' => $ceklogin['id_pelanggan'],
					'user_name' => $ceklogin['nama_pelanggan'],
					'user_email' => $ceklogin['email_pelanggan'],
					'user_telepon' => $ceklogin['telepon_pelanggan'],
					'user_alamat' => $ceklogin['alamat_pelanggan'],
					'user_token' => $token,
					'token_iat' => $issuedat_claim,
					'token_exp' => $expire_claim,
				];

				return $this->respond($output, 200);
			} else {
				$output = [
					'status' => 500,
					'message' => 'Login Gagal Hubungi Admin',
				];

				return $this->respond($output, 500);
			}
		} else {
			$output = [
				'status' => 401,
				'message' => "Input Null Hubungi Admin",
			];
			return $this->respond($output, 401);
		}
	}

	public function register()
	{
		// // Gabisa getPost kalo di react native
		// $firstname = $this->request->getPost('firstname');
		// $lastname = $this->request->getPost('lastname');
		// $email = $this->request->getPost('email');
		// $password = $this->request->getPost('password');

		// Ini baru bisaa, ajg ajg bukan dartadi
		$nama = $this->request->getVar('nama');
		$email = $this->request->getVar('email');
		$password = $this->request->getVar('password');
		$alamat = $this->request->getVar('alamat');
		$telepon = $this->request->getVar('telepon');

		$password_hash = password_hash($password, PASSWORD_BCRYPT);

		$data = [
			'nama_pelanggan' => $nama,
			'email_pelanggan' => $email,
			'password_pelanggan' => $password_hash,
			'alamat_pelanggan' => $alamat,
			'telepon_pelanggan' => $telepon
		];

		$register = $this->authModel->register($data);

		if ($register == true) {
			$output = [
				'status' => 200,
				'message' => 'Berhasil Register',
				'password' => $password_hash
			];
			return $this->respond($output, 200);
		} else {
			$output = [
				'status' => 500,
				'message' => 'Gagal Register Hubungi Admin'
			];
			return $this->respond($output, 500);
		}
	}
}
