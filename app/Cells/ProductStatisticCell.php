<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class ProductStatisticCell extends Cell
{
    public function render(): string
    {
        return view('product/product_statistic');
    }
}
