<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\UserModel;
use Firebase\JWT\JWT;
use CodeIgniter\API\ResponseTrait;

class AuthController extends BaseController
{
    use ResponseTrait;

    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function register()
    {
        $rules = [
            'username' => 'required|min_length[3]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
        ];

        if (! $this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getVar('username'),
            'email'    => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
        ];

        $this->userModel->insert($data);

        return $this->respondCreated(['message' => 'Register berhasil']);
    }

    public function login()
    {
        $email    = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $user = $this->userModel->where('email', $email)->first();

        if (! $user || ! password_verify($password, $user['password'])) {
            return $this->failUnauthorized('Email atau password salah');
        }

        unset($user['password']);

        $key = getenv('JWT_SECRET_KEY');
        $payload = [
            'iss' => 'aniku-app',
            'iat' => time(),
            'exp' => time() + (60 * 60 * 24), // token berlaku 24 jam
            'data' => [
                'id'    => $user['id'],
                'email' => $user['email'],
            ],
        ];

        $token = JWT::encode($payload, $key, 'HS256');

        return $this->respond([
            'message' => 'Login berhasil',
            'user'    => $user,
            'token'   => $token,
        ]);
    }

    public function profile()
    {
        $userData = $this->request->user;

        $user = $this->userModel->find($userData->id);
        unset($user['password']);

        return $this->respond([
            'message' => 'Berhasil mengambil profile',
            'user'    => $user,
        ]);
    }
}