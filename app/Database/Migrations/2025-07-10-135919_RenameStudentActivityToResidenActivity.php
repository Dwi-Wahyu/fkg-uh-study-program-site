<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameStudentActivityToResidenActivity extends Migration
{
    public function up()
    {
        $this->forge->renameTable('student_activity', 'resident_activity');
    }

    public function down() {}
}
