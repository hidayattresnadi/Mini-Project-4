<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'product_id'  => 1,
                'image_path'  => 'uploads/products/samsung-galaxy-s23-1.jpg',
                'is_primary'  => true,
                'created_at'  => date('Y-m-d H:i:s')
            ],
            [
                'product_id'  => 1,
                'image_path'  => 'uploads/products/samsung-galaxy-s23-2.jpg',
                'is_primary'  => false,
                'created_at'  => date('Y-m-d H:i:s')
            ],
            [
                'product_id'  => 2,
                'image_path'  => 'uploads/products/nike-air-max-2023-1.jpg',
                'is_primary'  => true,
                'created_at'  => date('Y-m-d H:i:s')
            ],
            [
                'product_id'  => 3,
                'image_path'  => 'uploads/products/wooden-dining-table-1.jpg',
                'is_primary'  => true,
                'created_at'  => date('Y-m-d H:i:s')
            ],
            [
                'product_id'  => 4,
                'image_path'  => 'uploads/products/the-alchemist-book.jpg',
                'is_primary'  => true,
                'created_at'  => date('Y-m-d H:i:s')
            ],
            [
                'product_id'  => 5,
                'image_path'  => 'uploads/products/adidas-football-1.jpg',
                'is_primary'  => true,
                'created_at'  => date('Y-m-d H:i:s')
            ],
        ];

        $this->db->table('product_images')->insertBatch($data);
    }
}
