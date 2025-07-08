<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSaranaPrasaranaTable extends Migration
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
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false,
                'comment'    => 'Nama atau judul sarana/prasarana',
            ],
            'deskripsi' => [
                'type'       => 'TEXT',
                'null'       => true,
                'comment'    => 'Deskripsi detail sarana/prasarana',
            ],
            'gambar_thumbnail' => [ // Kolom untuk menyimpan nama file gambar thumbnail
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false, // Gambar thumbnail wajib diisi
                'comment'    => 'Nama file gambar thumbnail untuk sarana/prasarana',
            ],
            'file_video' => [ // Kolom untuk menyimpan nama file video
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true, // Video bisa opsional, jika tidak ada, tampilkan hanya gambar
                'comment'    => 'Nama file video untuk sarana/prasarana (jika ada)',
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('sarana_prasarana');
    }

    public function down()
    {
        $this->forge->dropTable('sarana_prasarana');
    }
}
