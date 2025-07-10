<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ChangeSurveyToSurveiMigration extends Migration
{
    public function up()
    {
        $this->forge->renameTable('survey', 'survei');
    }

    public function down()
    {
        $this->forge->renameTable('survei', 'survey');
    }
}
