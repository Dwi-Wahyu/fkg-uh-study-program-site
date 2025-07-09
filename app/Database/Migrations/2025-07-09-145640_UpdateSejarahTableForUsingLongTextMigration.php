<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateSejarahTableForUsingLongTextMigration extends Migration
{

    public function up()
    {
        $this->forge->modifyColumn('sejarah', [
            'content' => [
                'type' => 'LONGTEXT',
            ],
        ]);

        $this->forge->modifyColumn('sejarah', [
            'content_en' => [
                'type' => 'LONGTEXT',
            ],
        ]);
    }


    public function down()
    {
        $this->forge->modifyColumn('sejarah', [
            'content' => [
                'type' => 'TEXT',
            ],
        ]);

        $this->forge->modifyColumn('sejarah', [
            'content_en' => [
                'type' => 'TEXT',
            ],
        ]);
    }
}
