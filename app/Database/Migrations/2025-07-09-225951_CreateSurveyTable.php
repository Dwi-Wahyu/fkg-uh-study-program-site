<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSurveyTable extends Migration
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
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false, // Judul wajib diisi
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,      // Deskripsi bersifat opsional
            ],
            'link' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false, // Link wajib diisi
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

        $this->forge->createTable('survey');
    }

    public function down()
    {
        $this->forge->dropTable('survey');
    }
}
