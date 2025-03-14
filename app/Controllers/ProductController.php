<?php

namespace App\Controllers;

use App\Entities\Product;
use App\Libraries\DataParams;
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
        // $cache = \Config\Services::cache();

        $params = new DataParams([
            'search' => $this->request->getGet('search'),
            'category' => $this->request->getGet('category'),
            'price' => $this->request->getGet('price'),
            'sort' => $this->request->getGet('sort'),
            'order' => $this->request->getGet('order'),
            'page_products' => $this->request->getGet('page_products'),
            'perPage' => $this->request->getGet('perPage')
        ]);

        $isNotAdmin = false;
        $result = $this->productModel->getFilteredProducts($params, $isNotAdmin);

        $data = [
            'products' => $result['products'],
            'total' => $result['total'],
            'priceRanges' => $this->productModel->getAllPrices(),
            'categories' => $this->categoryModel->getAllCategories(),
            'baseUrl' => base_url('/products'),
            'inputSearch' => view_cell('SearchCell', ['params' => $params, 'label' => 'Search Product']),
        ];

        $data['products'] = array_map(function ($product) {
            $product->formattedPrice = $product->getFormattedPrice();
            $product->isNewSpan = view_cell('IsNewProductCell', ['isNew' => (bool) $product->isNew()]);
            $product->isOnSaleSpan = view_cell('IsOnSaleProductCell', ['isOnSale' => $product->isSale()]);
            $product->stockStyling = view_cell('StockSpanProductCell', ['stock' => $product->stock]);
            $product->buyButton = view_cell('BuyButtonProductCell', ['stock' => $product->stock]);

            return $product;
        }, $data['products']);

        $data['filterCategory'] = view_cell('SelectOptionsCell', [
            'params' => $params,
            'label' => 'Filter by Categories',
            'paramsName' => 'category',
            'datas' => $data['categories'],
            'accessField' => [$params->category],
            'optionsSelectAll' => 'All Categories'
        ]);

        $data['selectPages'] = view_cell('SelectOptionsCell', [
            'params' => $params,
            'label' => 'Results per Page',
            'paramsName' => 'perPage',
            'datas' => [2, 10, 15, 25],
            'accessField' => [$params->perPage],
            'optionsSelectAll' => '',
            'optionsValueNull' => false,
            'style' => "col-md-2"
        ]);

        $data['filterPricesRange'] = view_cell('FilterPriceRangeCell', [
            'priceRanges' => $data['priceRanges'],
            'params' => $params
        ]);

        $data['thName'] = view_cell('SortTableHeaderCell',  [
            'params' => $params,
            'baseUrl' => $data['baseUrl'],
            'tableField' => 'name',
            'tableTitleHeader' => 'Name',
            'style' => "btn btn-primary d-flex align-items-center gap-1"
        ]);
        $data['thPrice'] =  view_cell('SortTableHeaderCell',  [
            'params' => $params,
            'baseUrl' => $data['baseUrl'],
            'tableField' => 'price',
            'tableTitleHeader' => 'Price',
            'style' => "btn btn-primary d-flex align-items-center gap-1"
        ]);
        $data['thCreatedAt'] = view_cell('SortTableHeaderCell',  [
            'params' => $params,
            'baseUrl' => $data['baseUrl'],
            'tableField' => 'created_at',
            'tableTitleHeader' => 'Date',
            'style' => "btn btn-primary d-flex align-items-center gap-1"
        ]);
        // $search = $this->request->getGet('search') ?? '';
        // $filter = $this->request->getGet('filter') ?? '';

        // $cacheKey = "products_search_{$search}_filter_{$filter}";

        // $data['search'] = esc($search);
        // $data['selected_active'] = ($filter === 'active') ? 'selected' : '';
        // $data['selected_inactive'] = ($filter === 'inactive') ? 'selected' : '';

        // if ($cachedData = $cache->get($cacheKey)) {
        //     return view('product/index', $cachedData);
        // }

        $data['content'] = $parser->setData($data)->render('components/product_list');
        $data['pager'] = $result['pager'];
        $data['params'] = $params;
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
        $params = new DataParams([
            'search' => $this->request->getGet('search'),
            'category' => $this->request->getGet('category'),
            'price' => $this->request->getGet('price'),
            'sort' => $this->request->getGet('sort'),
            'order' => $this->request->getGet('order'),
            'page_products' => $this->request->getGet('page_products'),
            'perPage' => $this->request->getGet('perPage')
        ]);

        $isAdmin = true;
        $result = $this->productModel->getFilteredProducts($params, $isAdmin);

        $data = [
            'products' => $result['products'],
            'pager' => $result['pager'],
            'total' => $result['total'],
            'params' => $params,
            'priceRanges' => $this->productModel->getAllPrices(),
            'categories' => $this->categoryModel->getAllCategories(),
            'baseUrl' => base_url('admin/products')
        ];

        foreach ($data['products'] as $product) {
            $product->images = $product->images ? explode(',', $product->images) : [];
        }
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
        $product->is_new = $this->request->getPost('is_new') ?? false;
        $product->is_sale = $this->request->getPost('is_sale') ?? false;

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

        return redirect()->to('admin/products')->with('message', 'Products added successfully');
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
            session()->setFlashdata('message', 'Product berhasil diupdate');
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
        return redirect()->to('admin/products')->with('message', 'Products deleted successfully');
    }
}
