<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'        => 'Electronics',
                'description' => 'Devices and gadgets including smartphones, laptops, and accessories.',
                'status'      => 'active',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s')
            ],
            [
                'name'        => 'Fashion',
                'description' => 'Clothing, shoes, and accessories for men, women, and kids.',
                'status'      => 'active',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s')
            ],
            [
                'name'        => 'Home & Kitchen',
                'description' => 'Furniture, appliances, and home decor.',
                'status'      => 'active',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s')
            ],
            [
                'name'        => 'Books',
                'description' => 'A variety of books including novels, comics, and educational materials.',
                'status'      => 'active',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s')
            ],
            [
                'name'        => 'Sports & Outdoors',
                'description' => 'Sporting equipment, outdoor gear, and fitness accessories.',
                'status'      => 'active',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s')
            ],
        ];

        // Insert multiple categories
        $this->db->table('categories')->insertBatch($data);
    }
}
