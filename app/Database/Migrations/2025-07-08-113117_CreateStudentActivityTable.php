<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStudentActivityTable extends Migration
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
            ],
            'deskripsi' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'gambar' => [ // Kolom untuk menyimpan nama file gambar
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false, // <-- Diubah menjadi NOT NULL
            ],
            'tanggal' => [ // Kolom tanggal baru
                'type'       => 'DATE', // Menggunakan tipe DATE untuk tanggal saja
                'null'       => false,  // <-- Diubah menjadi NOT NULL (required)
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');

        $this->forge->createTable('student_activity');
    }

    public function down()
    {
        $this->forge->dropTable('student_activity');
    }
}
