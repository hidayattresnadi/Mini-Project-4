<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameUsersToCustomers extends Migration
{
    public function up()
    {
        $this->forge->renameTable('users', 'customers');
    }

    public function down()
    {
        $this->forge->renameTable('customers', 'users');
    }
}
