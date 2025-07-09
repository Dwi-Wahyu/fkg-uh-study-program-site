<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;

class Auth extends BaseController
{
    use ResponseTrait;

    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['form', 'url', 'session']);
    }

    public function login()
    {
        // Jika user sudah login, arahkan ke dashboard admin
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/admin/dashboard'); // <-- Langsung arahkan ke admin dashboard
        }

        if ($this->request->getMethod() === 'POST') {
            log_message('debug', 'Login: Form disubmit.'); // <--- Tambahkan ini

            $rules = [
                'email'    => 'required|valid_email',
                'password' => 'required',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $email    = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $user = $this->userModel->where('email', $email)->first();

            if (!$user || !password_verify($password, $user['password'])) {
                return redirect()->back()->withInput()->with('errors', ['Email atau password salah.']);
            }

            if (!$user['is_active']) {
                return redirect()->back()->withInput()->with('errors', ['Akun Anda belum aktif. Mohon hubungi administrator.']);
            }

            // Login Berhasil: Set Sesi
            $ses_data = [
                'user_id'    => $user['id'],
                'username'   => $user['username'],
                'email'      => $user['email'],
                'role'       => $user['role'], // Role tetap disimpan di sesi jika sewaktu-waktu dibutuhkan
                'isLoggedIn' => true,
            ];
            session()->set($ses_data);

            // Langsung arahkan ke /admin/dashboard tanpa memeriksa role
            return redirect()->to('/admin/dashboard')->with('success', 'Selamat datang, ' . $user['username'] . '!');
        }

        // Tampilkan Form Login (GET request)
        $data = [
            'title' => 'Login',
            'errors' => session()->getFlashdata('errors'),
            'success' => session()->getFlashdata('success'),
        ];
        return view('auth/login', $data);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Anda telah berhasil logout.');
    }
}
