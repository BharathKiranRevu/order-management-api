<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function register()
    {
        $data = $this->request->getJSON(true);
        if (!$data) {
            return $this->response->setJSON(['error' => 'Invalid JSON'])->setStatusCode(400);
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name'     => 'required',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]'
        ]);

        if (!$validation->run($data)) {
            return $this->response->setJSON(['errors' => $validation->getErrors()])
                                  ->setStatusCode(422);
        }

        $userModel = new UserModel();

        $userId = $userModel->insert([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT)
        ]);

        return $this->response->setJSON([
            'message' => 'User registered successfully',
            'user_id' => $userId
        ])->setStatusCode(201);
    }

    public function login()
    {
        $data = $this->request->getJSON(true);
        if (!$data) {
            return $this->response->setJSON(['error' => 'Invalid JSON'])->setStatusCode(400);
        }

        $userModel = new UserModel();
        $user = $userModel->where('email', $data['email'])->first();

        if (!$user || !password_verify($data['password'], $user['password'])) {
            return $this->response->setJSON(['error' => 'Invalid credentials'])
                                  ->setStatusCode(401);
        }

        // Session-based login
        $session = session();
        $session->set([
            'user_id'   => $user['id'],
            'user_name' => $user['name'],
            'is_logged' => true
        ]);

        return $this->response->setJSON([
            'message' => 'Login successful',
            'user' => [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email']
            ]
        ]);
    }

    public function logout()
    {
        $session = session();

        if (!$session->has('user_id')) {
            return $this->response->setJSON(['error' => 'Not logged in'])
                                  ->setStatusCode(401);
        }

        $session->destroy();

        return $this->response->setJSON(['message' => 'Logged out successfully']);
    }
}
