<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Panggil seeder spesifik Anda di sini
        $this->call('UserSeeder'); // Memanggil UserSeeder
        // $this->call('SaranaPrasaranaSeeder'); // Jika Anda punya seeder lain
        // $this->call('VisiMisiTujuanSeeder'); // Jika Anda punya seeder lain
    }
}
