<?php

namespace App\Controllers;

use App\Entities\Product;
use App\Libraries\DataParams;
use App\Models\CategoryModel;
use App\Models\ProductImageModel;
use App\Models\ProductModel;
use CodeIgniter\Files\File;
use CodeIgniter\I18n\Time;
use Myth\Auth\Models\GroupModel;
use Myth\Auth\Models\UserModel;

class ProductController extends BaseController
{
    protected $renderer;
    private ProductModel $productModel;
    private CategoryModel $categoryModel;
    private ProductImageModel $productImageModel;
    private UserModel $userModel;

    public function __construct()
    {
        $this->renderer = service('renderer');
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->productImageModel = new ProductImageModel();
        $this->userModel = new UserModel();
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
            $product->thumbnail_src = $data['thumbnail'] = !empty($product->thumbnail) ? base_url($product->thumbnail) : base_url('uploads/default-thumbnail.jpg');

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
        $data['product'] = $this->productModel->productWithCategoryAndMediumImage()->find($id);
        return view('product/product_detail', $data);
    }

    public function new(): string
    {
        helper('form');
        $data['categories'] = $this->categoryModel->findAll();
        return view('product/add_product', $data);
    }

    public function create()
    {
        helper('form');
        $email = service('email');
        $product = new Product($this->request->getPost());
        $product->is_new = $this->request->getPost('is_new') ?? false;
        $product->is_sale = $this->request->getPost('is_sale') ?? false;

        if (! $this->productModel->save($product)) {
            print_r($this->productModel->errors());
            return redirect()->back()
                ->with('errors', $this->productModel->errors())
                ->withInput();
        }

        $insertedId = $this->productModel->insertID();

        // delete cache at folder writable folder cache

        $cachePath = WRITEPATH . 'cache/';
        $files = glob($cachePath . "products_search_*");

        if ($files) {
            foreach ($files as $file) {
                unlink($file);
            }
        }

        $userId = user_id();
        $user = $this->userModel->find($userId);
        $email->setFrom('online@shopping.com', 'Online Shopping App');
        $email->setTo($user->email);

        $ccList = $this->getEmailsByRoles(['administrator', 'product manager'], $user->email);
        $email->setCC($ccList);

        $email->setSubject('New Product has been added');

        $data['product'] = $product;
        $time = Time::now('Asia/Jakarta');
        $formattedDate = $time->toLocalizedString('EEEE, dd MMMM yyyy');

        $listFiles = $this->uploadProductImageWithListFiles($insertedId);
        $email->attach($listFiles['thumbnailPathRelative'], 'inline', 'product_thumbnail.png');
        $data = [
            'product' => $product,
            'product_url' => site_url('products/' . $insertedId),
            'category' => $this->categoryModel->find($product->category_id),
            'registration_date' => $formattedDate,
            'product_id' => $insertedId,
            'thumbnail' => "cid:product_thumbnail.png"
        ];

        $message = view('email/add_product', $data);
        $email->setMessage($message);


        if ($email->send()) {
            return redirect()->to('admin/products')->with('message', 'Products added successfully');
        } else {
            $data = ['error' => $email->printDebugger()];
            return redirect()->back()
                ->with('errors', $data);
        }
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

    public function uploadProductImageForm($id)
    {
        helper('form');
        $data['product_id'] = $id;
        return view('product/upload_product_image', $data);
    }

    public function uploadProductImage($id)
    {
        $listFiles = $this->uploadProductImageWithListFiles($id);

        $data = ['uploaded_fileinfo' => new File($listFiles['filePath'])];
        $data['baseUrl'] = 'admin/products/upload_product_image';
        return view('upload_success', $data);
    }

    public function uploadProductImageWithListFiles($id)
    {
        helper('form');
        $userfile = $this->request->getFile('userfile');

        $validationRules = [
            'userfile' => [
                'label' => 'Gambar',
                'rules' => [
                    'uploaded[userfile]',
                    'is_image[userfile]',
                    'mime_in[userfile,image/jpeg,image/jpg,image/png,image/webp]',
                    'max_size[userfile,5*1024]',
                    'min_dims[userfile,600,600]'
                ],
                'errors' => [
                    'uploaded' => 'Please choose file to upload',
                    'is_image' => 'File should be image',
                    'mime_in' => 'File format should be JPG, PNG, or WebP',
                    'max_size' => 'File size is not more than 5 MB',
                    'min_dims' => 'File dimension is not less than 600x600'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors());
        }

        $newName = $userfile->getRandomName();
        $uploadPath = FCPATH . 'uploads/product_' . $id;

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }
        $userfile->move($uploadPath, $newName);
        $filepath = $uploadPath . '/' . $newName;

        $listFiles = $this->createImageVersions($filepath, $newName, $uploadPath, $id);
        return $listFiles;
    }

    private function createImageVersions($filePath, $fileName, $uploadPath, $productId)
    {
        $mediumPathRelative = $this->getMediumPathRelative($filePath, $fileName, $uploadPath, $productId);
        $thumbnailPathRelative = $this->getThumbnailPathRelative($filePath, $fileName, $uploadPath, $productId);
        $originalPathRelative = $this->getOriginalPathRelative($filePath, $productId);
        $filePathRelative = [
            'mediumPathRelative' => $mediumPathRelative,
            'thumbnailPathRelative' => $thumbnailPathRelative,
            'originalPathRelative' => $originalPathRelative,
            'filepath' => $filePath
        ];
        return $filePathRelative;
    }

    protected function getEmailsByRoles(array $roles, $currentUserEmail)
    {
        $groupModel = new GroupModel();
        $emails = [];

        foreach ($roles as $role) {
            $group = $groupModel->where('name', $role)->first();
            $users = $groupModel->getUsersForGroup($group->id);
            foreach ($users as $user) {
                if ($currentUserEmail != $user['email']) {
                    $emails[] = $user['email'];
                }
            }
        }
        $uniqueEmails = array_unique($emails);
        return array_values($uniqueEmails);
    }

    private function getThumbnailPathRelative($filePath, $fileName, $uploadPath, $productId)
    {
        $image = service('image');
        $thumbnailPath = $uploadPath . '/thumbnail/';
        $thumbnailPathAbsolute = $thumbnailPath . $fileName;

        if (!is_dir($thumbnailPath)) {
            mkdir($thumbnailPath, 0777, true);
        }

        $image->withFile($filePath)
            ->fit(150, 150, 'center')
            ->save($thumbnailPathAbsolute);

        $thumbnailPathRelative = str_replace(FCPATH, '', $thumbnailPathAbsolute);

        $imageThumbnailData = [
            'product_id' => $productId,
            'image_path' => $thumbnailPathRelative,
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->productImageModel->save($imageThumbnailData);

        return $thumbnailPathRelative;
    }

    public function getMediumPathRelative($filePath, $fileName, $uploadPath, $productId)
    {
        $image = service('image');
        $mediumPath = $uploadPath . '/medium/';

        if (!is_dir($mediumPath)) {
            mkdir($mediumPath, 0777, true);
        }
        $mediumPathAbsolute = $mediumPath . $fileName;

        $image->withFile($filePath)
            ->text('Copyright 2017 My Photo Co', [
                'color'      => '#fff',
                'opacity'    => 0.5,
                'withShadow' => true,
                'hAlign'     => 'center',
                'vAlign'     => 'bottom',
                'fontSize'   => 20,
            ])
            ->resize(500, 500, true, 'auto')
            ->save($mediumPathAbsolute);

        $mediumPathRelative = str_replace(FCPATH, '', $mediumPathAbsolute);

        $imageMediumData = [
            'product_id' => $productId,
            'image_path' => $mediumPathRelative,
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->productImageModel->save($imageMediumData);

        return $mediumPathRelative;
    }

    public function getOriginalPathRelative($filePath, $productId)
    {
        $image = service('image');
        $image->withFile($filePath)
            ->text('Copyright 2017 My Photo Co', [
                'color'      => '#fff',
                'opacity'    => 0.5,
                'withShadow' => true,
                'hAlign'     => 'center',
                'vAlign'     => 'bottom',
                'fontSize'   => 20,
            ])
            ->save($filePath, 80);

        $filePathRelative = str_replace(FCPATH, '', $filePath);

        $imageOriginalData = [
            'product_id' => $productId,
            'image_path' => $filePathRelative,
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->productImageModel->save($imageOriginalData);

        return $filePathRelative;
    }
}
