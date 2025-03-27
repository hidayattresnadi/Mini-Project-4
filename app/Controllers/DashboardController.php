<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\ProductModel;

class DashboardController extends BaseController
{
    private ProductModel $productModel;
    private CategoryModel $categoryModel;
    protected $renderer;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->renderer = service('renderer');
    }

    public function index()
    {

        $productsByCategory = $this->productsByCategory();

        $getTopFiveProducts = $this->getTopFiveProducts();

        $productGrowthMonth = $this->getProductGrowthMonth();
        $year = date('Y');

        return view('dashboard', [

            'productsByCategory' => json_encode($productsByCategory),

            'getTopFiveProducts' => json_encode($getTopFiveProducts),

            'productGrowthMonth' => json_encode($productGrowthMonth),
        ]);
    }

    private function productsByCategory()
    {
        $products = $this->productModel->getAllProductsByCategory();

        foreach ($products as $row) {
            $gradeLabels[] = $row->category . ' = ' . $row->total_products;
            $totalProducts[] = round((float)$row->percentage, 2);
            $colors[] = sprintf("rgb(%d, %d, %d)", rand(0, 255), rand(0, 255), rand(0, 255));
        }

        return [
            'labels' => $gradeLabels,
            'datasets' => [
                [
                    'label' => 'Products by Category %',
                    'data' => $totalProducts,
                    'backgroundColor' => $colors,
                    'hoverOffset' => 4
                ]
            ]
        ];
    }

    private function getTopFiveProducts()
    {
        $totalProductsData = $this->productModel->getTopFiveProducts();

        foreach ($totalProductsData as $row) {
            $labels[] = '' . $row->category;
            $totalProducts[] = (int)$row->total_products;
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Total Products',
                    'data' => $totalProducts,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.5)',
                    'borderColor' => 'rgb(54, 162, 235)',
                    'borderWidth' => 1
                ],
            ]
        ];
    }

    private function getProductGrowthMonth()
    {
        $productGrowthMonth = $this->productModel->getProductGrowthMonth();
        $listMonths = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        foreach ($listMonths as $index => $month) {
            $isFound = false;
            foreach ($productGrowthMonth as $row) {
                if ($index === (int) $row->month - 1) {
                    $total_products[] = (int)$row->total_products;
                    $labelMonths[] = $month;
                    $isFound = true;
                    break;
                }
            }
            if (!$isFound) {
                $total_products[] = 0;
                $labelMonths[] = $month;
            }
        }

        return [
            'labels' => $labelMonths,
            'datasets' => [
                [
                    'label' => 'Total Products',
                    'data' => $total_products,
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'tension' => 0.1,
                    'fill' => false
                ]
            ]
        ];
    }
}
