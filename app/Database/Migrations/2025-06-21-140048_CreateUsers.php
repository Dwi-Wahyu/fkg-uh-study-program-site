<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true, // Pastikan username unik
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true, // Pastikan email unik
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => '255', // Password hash akan panjang
            ],
            'role' => [ // Tambahkan kolom role
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'default'    => 'user', // Default role 'user'
            ],
            'is_active' => [ // Untuk status aktif/non-aktif akun
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1, // Default aktif karena user ditambahkan via seeding
            ],
            // Kolom untuk reset password (opsional jika tidak butuh fitur ini)
            'reset_hash' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'reset_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'created_at datetime default current_timestamp', // Perbaiki definisi datetime
            'updated_at datetime default current_timestamp on update current_timestamp', // Tambahkan updated_at
            'deleted_at' => [ // Untuk soft delete (opsional)
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id'); // Gunakan addPrimaryKey
        $this->forge->createTable('users');

        // Muat data admin dari .env
        $adminUsername = env('ADMIN_USERNAME', 'admin'); // Default jika tidak ditemukan di .env
        $adminEmail    = env('ADMIN_EMAIL', 'admin@example.com');
        $adminPassword = env('ADMIN_PASSWORD', 'password'); // Ganti dengan default yang aman jika env tidak ada

        // Tambahkan user admin default melalui seeding di migrasi
        // Cek apakah user admin sudah ada (menggunakan email sebagai kriteria unik)
        $existingAdminCount = $this->db->table('users')->where('email', $adminEmail)->countAllResults();

        if ($existingAdminCount === 0) { // Jika tidak ada user dengan email tersebut
            $this->db->table('users')->insert([
                'username'   => $adminUsername,
                'email'      => $adminEmail,
                'password'   => password_hash($adminPassword, PASSWORD_DEFAULT), // Password akan di-hash
                'role'       => 'admin',
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

    public function down()
    {
        $this->forge->dropTable('users'); // Hapus tabel saat rollback
    }
}
