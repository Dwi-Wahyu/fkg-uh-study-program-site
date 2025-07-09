<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateSejarahTableForMultiLanguage extends Migration
{
    public function up()
    {
        $this->forge->addColumn('sejarah', [
            'content_en' => [
                'type' => 'TEXT',
                'null' => true, // Bisa null jika tidak wajib diisi
                'after' => 'content', // Tempatkan setelah content_id
            ],
        ]);
    }

    public function down() {}
}
