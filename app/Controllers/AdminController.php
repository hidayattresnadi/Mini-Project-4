<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\UserModel;

class AdminController extends BaseController
{
    protected $renderer;
    private ProductModel $productModel;
    private UserModel $userModel;

    public function __construct()
    {
        $this->renderer = service('renderer');
        $this->productModel = new ProductModel();
        $this->userModel = new UserModel();
    }
    public function showDashboard(): string
    {
        $parser = \Config\Services::parser();
        $data = [
            'title' => 'E-Commerce Overview',
            'activeProducts' => number_format($this->productModel->findActiveProducts()),
            'totalProducts' => number_format($this->productModel->countTotalProducts()),
            'outOfStock' => number_format($this->productModel->getLowStockProducts()),
            'onSaleProducts' => $this->productModel->getOnSaleProducts(),
        ];
        $data['content'] = $parser->setData($data)->render('components/admin_dashboard');
        $this->renderer->setData($data);
        return view('admin/dashboard', $data);
    }

    public function showUserDashboard(): string
    {
        $parser = \Config\Services::parser();
        $data = [
            'title' => 'User Overview',
            'activeUsers' => number_format($this->userModel->findActiveUsers()),
            'totalUsers' => number_format($this->userModel->getTotalUsers()),
            'newUsers' => number_format($this->userModel->getNewUsersThisMonth()),
        ];
        $data['content'] = $parser->setData($data)->render('components/admin_user_dashboard');
        $this->renderer->setData($data);
        return view('admin/user_dashboard', $data);
    }
}
