<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Category extends Entity
{
    protected $attributes = [
        'name'        => null,
        'description' => null,
        'status'      => null,
        'created_at'  => null,
        'updated_at'  => null
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
