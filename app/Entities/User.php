<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class User extends Entity
{
    protected $attributes = [
        'id' => null,
        'username'   => null,
        'email'      => null,
        'password'   => null,
        'full_name'  => null,
        'role'       => null,
        'status'     => null,
        'last_login' => null,
        'created_at' => null,
        'updated_at' => null,
        'deleted_at' => null
    ];

    protected $casts = [
        'id'         => 'integer',
        'last_login' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => '?datetime' // Bisa null
    ];

    protected function setPassword(string $password)
    {
        $this->attributes['password'] = password_hash($password, PASSWORD_DEFAULT);
    }

    public function isAdmin(): bool
    {
        return $this->attributes['role'] === 'admin';
    }

    public function getFullName(): string
    {
        return $this->attributes['full_name'] ?? '';
    }

    public function getFormattedLastLogin(): string
    {
        return $this->attributes['last_login']
            ? $this->attributes['last_login']->format('d M Y H:i:s')
            : 'Never Logged In';
    }
}
