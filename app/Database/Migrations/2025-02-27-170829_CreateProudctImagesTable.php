<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProudctImagesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'product_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true
            ],
            'image_path' => [
                'type'       => 'VARCHAR',
                'constraint' => 255
            ],
            'is_primary' => [
                'type'    => 'BOOLEAN',
                'default' => false
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true
            ]
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('product_images');
    }

    public function down()
    {
        $this->forge->dropTable('product_images');
    }
}
