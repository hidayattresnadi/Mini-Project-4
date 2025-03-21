<?php

namespace App\Models;

use App\Libraries\DataParams;
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

    public function productWithCategoryAndThumbnail()
    {
        return $this->select('
        products.*, 
        categories.name as category, 
        (SELECT image_path 
         FROM product_images 
         WHERE product_images.product_id = products.id 
         AND product_images.image_path LIKE "%/thumbnail/%"
         LIMIT 1) as thumbnail
    ')
            ->join('categories', 'categories.id = products.category_id')
            ->groupBy('products.id, categories.name');
    }

    public function productWithCategoryAndMediumImage()
    {
        return $this->select('
        products.*, 
        categories.name as category, 
        (SELECT image_path 
         FROM product_images 
         WHERE product_images.product_id = products.id 
         AND product_images.image_path LIKE "%/medium/%"
         LIMIT 1) as medium
    ')
            ->join('categories', 'categories.id = products.category_id')
            ->groupBy('products.id, categories.name');
    }


    public function getFilteredProducts(DataParams $params, bool $isAdmin)
    {

        $query = $isAdmin ? $this->withCategoryAndImages() : $this->productWithCategoryAndThumbnail();
        if (!empty($params->search)) {
            if ($isAdmin) {
                $query->groupStart()
                    ->like('products.name', $params->search)
                    ->orLike('products.description', $params->search)
                    ->orlike("CAST(products.price AS CHAR)", $params->search)
                    ->orlike("CAST(products.stock AS CHAR)", $params->search)
                    ->orlike("products.status", $params->search)
                    ->orlike("categories.name", $params->search)
                    ->groupEnd();
            } else {
                $query->groupStart()
                    ->like('products.name', $params->search)
                    ->orlike("categories.name", $params->search)
                    ->groupEnd();
            }
        }

        // Apply filter category

        if (!empty($params->category)) {
            $query->where('categories.name', $params->category);
        }

        // Apply filter price range

        if (!empty($params->price)) {
            // list => menyimpan elemen array ke variabel terpisah
            list($min, $max) = explode('-', $params->price);

            if ($max === 'above') {
                $query->where('price >=', $min); // Produk dengan harga >= min
            } else {
                $query->where('price >=', $min)->where('price <=', $max); // Produk dalam range harga
            }
        }


        // Apply sort
        $allowedSortColumns = ['price', 'name', 'created_at'];
        $sort = in_array($params->sort, $allowedSortColumns) ? $params->sort : 'id';
        $order = ($params->order === 'desc') ? 'desc' : 'asc';

        $this->orderBy($sort, $order);

        $result = [
            'products' => $this->paginate($params->perPage, 'products', $params->page_products),
            'pager' => $this->pager,
            'total' => $this->countAllResults(false)
        ];
        return $result;
    }

    public function getAllPrices()
    {
        $ranges = [];
        $prices = $this->select('price')->distinct()->findAll();
        $prices = array_column($prices, 'price');

        $min = min($prices);
        $max = max($prices);

        // range kenaikan harga

        $step = 20000;

        for ($i = $min; $i < $max; $i += $step) {
            $upper = $i + $step;
            $ranges["$i - $upper"] = [$i, $upper];
        }
        $ranges["Above $max"] = [$max, null];
        return $ranges;
    }
}
