<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name'        => 'Samsung Galaxy S23',
                'description' => 'Latest Samsung smartphone with high-end specs.',
                'price'       => 999.99,
                'stock'       => 50,
                'category_id' => 1, // Electronics
                'status'      => 'active',
                'is_new'      => true,
                'is_sale'     => false,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s')
            ],
            [
                'name'        => 'Nike Air Max 2023',
                'description' => 'Comfortable and stylish running shoes.',
                'price'       => 150.00,
                'stock'       => 100,
                'category_id' => 2, // Fashion
                'status'      => 'active',
                'is_new'      => true,
                'is_sale'     => true,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s')
            ],
            [
                'name'        => 'Wooden Dining Table',
                'description' => 'Modern wooden dining table with six chairs.',
                'price'       => 499.99,
                'stock'       => 20,
                'category_id' => 3, // Home & Kitchen
                'status'      => 'active',
                'is_new'      => false,
                'is_sale'     => true,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s')
            ],
            [
                'name'        => 'The Alchemist - Paulo Coelho',
                'description' => 'A bestselling novel about following your dreams.',
                'price'       => 12.99,
                'stock'       => 200,
                'category_id' => 4, // Books
                'status'      => 'active',
                'is_new'      => false,
                'is_sale'     => false,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s')
            ],
            [
                'name'        => 'Adidas Football',
                'description' => 'Premium quality football for professional play.',
                'price'       => 40.00,
                'stock'       => 75,
                'category_id' => 5, // Sports & Outdoors
                'status'      => 'active',
                'is_new'      => true,
                'is_sale'     => false,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s')
            ],
        ];

        $this->db->table('products')->insertBatch($products);
    }
}
