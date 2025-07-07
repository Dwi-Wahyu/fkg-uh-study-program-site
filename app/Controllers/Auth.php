<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if ($this->request->getMethod() === 'post') {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $userModel = new UserModel();
            $user = $userModel->where('email', $email)->first();

            if ($user && password_verify($password, $user['password'])) {
                session()->set([
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'isLoggedIn' => true,
                ]);
                return redirect()->to('/users');
            } else {
                return view('auth/login', ['error' => 'Email atau password salah']);
            }
        }

        return view('auth/login');
    }

    public function register()
    {
        helper(['form']);

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'username' => 'required|min_length[3]|is_unique[users.username]',
                'email'    => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[6]',
                'confirm_password' => 'required|matches[password]',
            ];

            $messages = [
                'username' => [
                    'required'    => 'Username wajib diisi',
                    'min_length'  => 'Username minimal 3 karakter',
                    'is_unique'   => 'Username sudah terdaftar',
                ],
                'email' => [
                    'required'    => 'Email wajib diisi',
                    'valid_email' => 'Format email tidak valid',
                    'is_unique'   => 'Email sudah terdaftar',
                ],
                'password' => [
                    'required'    => 'Password wajib diisi',
                    'min_length'  => 'Password minimal 6 karakter',
                ],
                'confirm_password' => [
                    'required' => 'Konfirmasi password wajib diisi',
                    'matches'  => 'Konfirmasi password tidak cocok',
                ],
            ];

            if (! $this->validate($rules, $messages)) {
                return view('auth/register', [
                    'validation' => $this->validator
                ]);
            }

            $userModel = new \App\Models\UserModel();
            $userModel->save([
                'username'   => $this->request->getPost('username'),
                'email'      => $this->request->getPost('email'),
                'password'   => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            session()->setFlashdata('success', 'Registrasi berhasil. Silakan login.');
            return redirect()->to('/login');
        }

        return view('auth/register');
    }



    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
