<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKurikulumTable extends Migration
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
                'constraint' => '255',
                'null'       => false,
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true, // Keterangan opsional
            ],
            'keterangan_en' => [
                'type' => 'TEXT',
                'null' => true, // Keterangan bahasa Inggris opsional
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
        $this->forge->addKey('id', true);
        $this->forge->createTable('kurikulum');
    }

    public function down()
    {
        $this->forge->dropTable('kurikulum');
    }
}
