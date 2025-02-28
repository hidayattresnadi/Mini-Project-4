<?php

namespace App\Controllers;

use App\Entities\Product;
use App\Models\CategoryModel;
use App\Models\ProductModel;

class ProductController extends BaseController
{
    protected $renderer;
    private ProductModel $productModel;
    private CategoryModel $categoryModel;

    public function __construct()
    {
        $this->renderer = service('renderer');
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }
    public function index(): string
    {
        $parser = \Config\Services::parser();
        $cache = \Config\Services::cache();
        $data['products'] = $this->productModel->findListActiveProducts();
        $data['products'] = array_map(function ($product) {
            $product->formattedPrice = $product->getFormattedPrice();
            $product->isNewSpan = view_cell('IsNewProductCell', ['isNew' => (bool) $product->isNew()]);
            $product->isOnSaleSpan = view_cell('IsOnSaleProductCell', ['isOnSale' => $product->isSale()]);
            $product->stockStyling = view_cell('StockSpanProductCell', ['stock' => $product->stock]);
            $product->buyButton = view_cell('BuyButtonProductCell', ['stock' => $product->stock]);

            return $product;
        }, $data['products']);

        $search = $this->request->getGet('search') ?? '';
        $filter = $this->request->getGet('filter') ?? '';

        $cacheKey = "products_search_{$search}_filter_{$filter}";

        $data['search'] = esc($search);
        $data['selected_active'] = ($filter === 'active') ? 'selected' : '';
        $data['selected_inactive'] = ($filter === 'inactive') ? 'selected' : '';

        if ($cachedData = $cache->get($cacheKey)) {
            return view('product/index', $cachedData);
        }

        $data['content'] = $parser->setData($data)->render('components/product_list');
        $this->renderer->setData($data);

        // $cache->save($cacheKey, $data, 3600);

        return view('product/index', $data);
    }

    public function getStatistics()
    {
        $salesData = [
            ['month' => 'Jan', 'sales' => 10],
            ['month' => 'Feb', 'sales' => 15],
            ['month' => 'Mar', 'sales' => 20],
            ['month' => 'Apr', 'sales' => 18],
        ];

        $inventoryData = [
            ['product' => 'Laptop', 'stock' => 50],
            ['product' => 'Headphones', 'stock' => 120],
            ['product' => 'Smartphone', 'stock' => 80],
        ];

        return $this->response->setJSON([
            'sales_trends' => $salesData,
            'inventory_levels' => $inventoryData,
        ]);
    }

    public function getViewStatistic()
    {
        return view_cell('ProductStatisticCell', null, 3600);
    }

    public function getAllProducts()
    {
        // $search = $this->request->getGet('search') ?? '';
        // $filter = $this->request->getGet('filter') ?? '';
        $data['products'] = $this->productModel->withCategory()->findAll();
        return view('product/products_list', $data);
    }

    public function show($id)
    {
        $data['product'] = $this->productModel->withCategory()->find($id);
        return view('product/product_detail', $data);
    }

    public function new(): string
    {
        $data['categories'] = $this->categoryModel->findAll();
        return view('product/add_product', $data);
    }

    public function create()
    {
        $product = new Product($this->request->getPost());

        if (! $this->productModel->save($product)) {
            print_r($this->productModel->errors());
            return redirect()->back()
                ->with('errors', $this->productModel->errors())
                ->withInput();
        }

        // delete cache at folder writable folder cache

        $cachePath = WRITEPATH . 'cache/';
        $files = glob($cachePath . "products_search_*");

        if ($files) {
            foreach ($files as $file) {
                unlink($file);
            }
        }

        return redirect()->to('admin/products')->with('success', 'Products added successfully');
    }

    public function edit($id): string
    {
        $data['product'] = $this->productModel->find($id);
        $data['categories'] = $this->categoryModel->findAll();
        return view('product/edit_product', $data);
    }

    public function update($id)
    {
        $data = $this->request->getPost();

        $product = $this->productModel->find($id);

        $product->fill($data);

        if ($this->productModel->save($product)) {
            session()->setFlashdata('success', 'User berhasil diupdate');
            // delete cache at folder writable folder cache

            $cachePath = WRITEPATH . 'cache/';
            $files = glob($cachePath . "products_search_*");

            if ($files) {
                foreach ($files as $file) {
                    unlink($file);
                }
            }

            return redirect()->to('/admin/products');
        }

        return redirect()->back()
            ->with('errors', $this->productModel->errors())
            ->withInput();
    }

    public function delete($id)
    {
        $this->productModel->delete($id);

        // delete cache at folder writable folder cache

        $cachePath = WRITEPATH . 'cache/';
        $files = glob($cachePath . "products_search_*");

        if ($files) {
            foreach ($files as $file) {
                unlink($file);
            }
        }
        return redirect()->to('admin/products')->with('success', 'Products deleted successfully');
    }
}
