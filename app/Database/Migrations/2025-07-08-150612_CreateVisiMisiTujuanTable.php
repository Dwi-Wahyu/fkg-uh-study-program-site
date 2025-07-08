<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVisiMisiTujuanTable extends Migration
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
            'visi_id' => [
                'type'       => 'TEXT',
                'null'       => true,
                'comment'    => 'Konten Visi (Indonesia)',
            ],
            'visi_en' => [
                'type'       => 'TEXT',
                'null'       => true,
                'comment'    => 'Konten Visi (English)',
            ],
            'misi_id' => [
                'type'       => 'TEXT',
                'null'       => true,
                'comment'    => 'Konten Misi (Indonesia)',
            ],
            'misi_en' => [
                'type'       => 'TEXT',
                'null'       => true,
                'comment'    => 'Konten Misi (English)',
            ],
            'tujuan_id' => [
                'type'       => 'TEXT',
                'null'       => true,
                'comment'    => 'Konten Tujuan (Indonesia)',
            ],
            'tujuan_en' => [
                'type'       => 'TEXT',
                'null'       => true,
                'comment'    => 'Konten Tujuan (English)',
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
            // 'deleted_at' => [ // Opsional: biasanya tidak diperlukan untuk data singleton
            //     'type' => 'DATETIME',
            //     'null' => true,
            // ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('visi_misi_tujuan');

        // Masukkan data default pertama kali migrasi dijalankan
        $data = [
            'visi_id'   => 'Visi default Anda dalam Bahasa Indonesia.',
            'visi_en'   => 'Your default Vision in English.',
            'misi_id'   => 'Misi default Anda dalam Bahasa Indonesia.',
            'misi_en'   => 'Your default Mission in English.',
            'tujuan_id' => 'Tujuan default Anda dalam Bahasa Indonesia.',
            'tujuan_en' => 'Your default Goal in English.',
        ];
        $this->db->table('visi_misi_tujuan')->insert($data);
    }

    public function down()
    {
        $this->forge->dropTable('visi_misi_tujuan');
    }
}
