<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBeritaTable extends Migration
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
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false,
                'comment'    => 'Judul Berita',
            ],
            'thumbnail' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true, // Thumbnail bisa opsional
                'comment'    => 'Nama file gambar thumbnail berita',
            ],
            'deskripsi_singkat' => [
                'type'       => 'TEXT',
                'null'       => true, // Deskripsi singkat bisa opsional
                'comment'    => 'Ringkasan singkat berita',
            ],
            'detail' => [
                'type'       => 'LONGTEXT', // Gunakan LONGTEXT untuk konten editor yang panjang
                'null'       => true, // Detail bisa opsional
                'comment'    => 'Konten detail berita (dari TinyMCE)',
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
            'deleted_at' => [ // Untuk soft delete
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('berita');
    }

    public function down()
    {
        $this->forge->dropTable('berita');
    }
}
