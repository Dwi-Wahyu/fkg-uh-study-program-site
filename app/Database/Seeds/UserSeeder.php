<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel; // Pastikan model Anda di-import

class UserSeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();

        // Data admin (sesuaikan dengan .env Anda)
        $adminUsername = env('ADMIN_USERNAME', 'admin');
        $adminEmail    = env('ADMIN_EMAIL', 'admin@example.com');
        $adminPassword = env('ADMIN_PASSWORD', 'password');

        // Cek apakah user admin sudah ada sebelum insert
        if ($userModel->where('email', $adminEmail)->countAllResults() === 0) {
            $data = [
                'username'   => $adminUsername,
                'email'      => $adminEmail,
                'password'   => $adminPassword, // Model callback akan hash ini
                'role'       => 'admin',
                'is_active'  => 1,
                // created_at dan updated_at akan otomatis diisi oleh model timestamps
            ];
            $userModel->insert($data); // Menggunakan insert() dari model
            echo "Admin user seeded successfully.\n"; // Pesan di CLI
        } else {
            echo "Admin user already exists. Skipping.\n";
        }

        // Contoh data user biasa (opsional)
        for ($i = 1; $i <= 5; $i++) {
            $email = "user{$i}@example.com";
            if ($userModel->where('email', $email)->countAllResults() === 0) {
                $userData = [
                    'username'   => "user{$i}",
                    'email'      => $email,
                    'password'   => 'password123', // Model callback akan hash ini
                    'role'       => 'user',
                    'is_active'  => 1,
                ];
                $userModel->insert($userData);
                echo "User {$i} seeded successfully.\n";
            } else {
                echo "User {$i} already exists. Skipping.\n";
            }
        }
    }
}
