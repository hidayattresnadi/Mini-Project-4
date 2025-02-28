<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \App\Entities\Product::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'description', 'price', 'stock', 'category_id', 'status', 'is_new', 'is_sale'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules  = [
        'name'  => 'required|min_length[3]',
        'description'  => 'required|min_length[12]',
        'price' => 'required|numeric|greater_than[0]',
        'stock' => 'required|integer|greater_than_equal_to[0]',
        'category_id'  => 'required',
        'status' => 'required|in_list[active, inactive]'
    ];
    protected $validationMessages   = [
        'name' => [
            'required'   => 'Product name is required.',
            'min_length' => 'Product name must be at least 3 characters long.'
        ],
        'description' => [
            'required'   => 'Product description is required.',
            'min_length' => 'Product description must be at least 12 characters long.'
        ],
        'price' => [
            'required'    => 'Price is required.',
            'decimal'     => 'Price must be a decimal number.',
            'greater_than' => 'Price must be greater than 0.'
        ],
        'stock' => [
            'required'                 => 'Stock is required.',
            'integer'                  => 'Stock must be an integer.',
            'greater_than_equal_to'    => 'Stock cannot be negative.'
        ],
        'category_id' => [
            'required'                 => 'Category is required.'
        ],
        'status' => [
            'required'                 => 'Status is required.',
            'in_list'                  => 'Status must be either active or inactive.'
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function findActiveProducts()
    {
        return $this->where('status', 'active')->countAllResults();
    }

    public function findListActiveProducts()
    {
        return $this->withCategory()->where('products.status', 'active')->findAll();
    }

    public function getProductsByCategory($categoryId)
    {
        return $this->where('category_id', $categoryId)->findAll();
    }

    public function getLowStockProducts(int $threshold = 5)
    {
        return $this->where('stock <=', $threshold)->countAllResults();
    }

    public function getOnSaleProducts()
    {
        return $this->where('is_sale', '1')->countAllResults();
    }

    public function countTotalProducts(): int
    {
        return $this->countAll();
    }

    public function withCategory()
    {
        return $this->select('products.*, categories.name as category')
            ->join('categories', 'categories.id = products.category_id')
            ->join('product_images', 'product_images.id = products.category_id');
    }

    public function withCategoryAndImages()
    {
        return $this->select('
            products.*, 
            categories.name as category, 
            GROUP_CONCAT(product_images.image_path) as images
        ')->join('categories', 'categories.id = products.category_id')
            ->join('product_images', 'product_images.product_id = products.id', 'left')
            ->groupBy('products.id, categories.name');
    }
}
