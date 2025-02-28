<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username'   => 'admin',
                'email'      => 'admin@example.com',
                'password'   => password_hash('Admin123!', PASSWORD_BCRYPT), // Hashing password
                'full_name'  => 'Admin User',
                'role'       => 'admin',
                'status'     => 'active',
                'last_login' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'deleted_at' => null
            ],
            [
                'username'   => 'john_doe',
                'email'      => 'john.doe@example.com',
                'password'   => password_hash('User1234!', PASSWORD_BCRYPT),
                'full_name'  => 'John Doe',
                'role'       => 'user',
                'status'     => 'active',
                'last_login' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'deleted_at' => null
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
