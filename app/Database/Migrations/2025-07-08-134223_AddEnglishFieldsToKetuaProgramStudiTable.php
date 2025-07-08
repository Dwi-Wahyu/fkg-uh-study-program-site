<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEnglishFieldsToKetuaProgramStudiTable extends Migration
{
    public function up()
    {
        // Menambahkan kolom 'sambutan_en'
        $fields = [
            'sambutan_en' => [
                'type'       => 'TEXT',
                'null'       => true, // Bisa null jika tidak selalu ada terjemahan
                'comment'    => 'Sambutan dari Ketua Program Studi (English)',
                'after'      => 'sambutan', // Opsional: Untuk menempatkan setelah kolom 'sambutan'
            ],
        ];
        $this->forge->addColumn('ketua_program_studi', $fields);
    }

    public function down()
    {
        // Menghapus kolom 'sambutan_en' saat rollback
        $this->forge->dropColumn('ketua_program_studi', 'sambutan_en');
    }
}
