<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProfilLulusanTableMigration extends Migration
{

    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'gambar' => [
                'type'       => 'VARCHAR',
                'constraint' => '255', // Panjang string untuk path gambar
                'null'       => false, // Gambar dianggap wajib
            ],
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true, // Judul bersifat opsional
            ],
            'deskripsi' => [
                'type' => 'TEXT',    // Menggunakan TEXT untuk deskripsi yang mungkin panjang
                'null' => true,      // Deskripsi bersifat opsional
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        // Menambahkan primary key
        $this->forge->addKey('id', true);

        // Membuat tabel
        $this->forge->createTable('profil_lulusan');
    }

    public function down()
    {
        // Menghapus tabel 'profil_lulusan'
        $this->forge->dropTable('profil_lulusan');

        // Opsional: Menambahkan pesan log
        // log_message('info', 'Tabel profil_lulusan berhasil dihapus.');
    }
}
