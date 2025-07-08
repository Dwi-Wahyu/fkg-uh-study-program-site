<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKetuaProgramStudiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true, // Tetap gunakan auto_increment, tapi kita hanya akan memakai ID 1
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false, // Wajib diisi
                'unique'     => true, // Pastikan hanya ada satu nama (opsional, jika yakin satu baris)
                'comment'    => 'Nama Ketua Program Studi',
            ],
            'sambutan' => [
                'type'       => 'TEXT',
                'null'       => true, // Bisa null atau diset ke false jika wajib
                'comment'    => 'Sambutan dari Ketua Program Studi',
            ],
            'gambar' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true, // Gambar bisa null jika opsional
                'comment'    => 'Nama file gambar Ketua Program Studi',
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('ketua_program_studi');

        // Opsional: Masukkan data dummy awal (seed) langsung di migration
        // Ini akan membuat baris pertama secara otomatis saat migrasi dijalankan
        $data = [
            'nama'     => 'Nama Ketua Default',
            'sambutan' => 'Ini adalah sambutan default dari Ketua Program Studi. Silakan perbarui.',
            'gambar'   => null, // Atau nama file gambar default jika ada
        ];
        $this->db->table('ketua_program_studi')->insert($data);
    }

    public function down()
    {
        $this->forge->dropTable('ketua_program_studi');
    }
}
