<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Product extends Entity
{
    protected $attributes = [
        'id'          => null,
        'name'        => null,
        'description' => null,
        'price'       => null,
        'stock'       => null,
        'category_id' => null, // Electronics
        'status'      => null,
        'is_new'      => null,
        'is_sale'     => null,
        'created_at'  => null,
        'updated_at'  => null
    ];

    protected $casts = [
        'price'      => 'float',
        'stock'      => 'integer',
        'is_new'     => 'boolean',
        'is_sale'    => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getFormattedPrice(): string
    {
        return 'Rp ' . number_format($this->attributes['price'], 2, '.', '.');
    }

    public function isInStock(): bool
    {
        return $this->attributes['stock'] > 0;
    }

    public function getStatus(): string
    {
        return $this->attributes['status'];
    }

    public function isSale(): bool
    {
        return (bool) $this->attributes['is_sale'];
    }

    public function isNew(): bool
    {
        return (bool) $this->attributes['is_new'];
    }
}
