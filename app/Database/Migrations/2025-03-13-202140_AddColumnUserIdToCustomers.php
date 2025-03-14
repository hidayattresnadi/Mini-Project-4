<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnUserIdToCustomers extends Migration
{
    public function up()
    {

        $this->forge->addColumn('customers', [
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'id', // Letakkan setelah kolom id
            ],
            'CONSTRAINT customers_user_id_fk FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE',
        ]);
    }

    public function down()
    {
        $this->forge->dropForeignKey('customers', 'customers_user_id_fk');
        $this->forge->dropColumn('customers', 'user_id');
    }
}
