<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ProductImage extends Entity
{
    protected $attributes = [
        'product_id'  => null,
        'image_path'  => null,
        'is_primary'  => null,
        'created_at'  => null
    ];

    protected $casts = [
        'product_id'      => 'integer',
        'is_primary'     => 'boolean',
        'created_at' => 'datetime',
    ];
}
