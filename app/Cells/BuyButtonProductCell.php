<?php

use CodeIgniter\View\Cells\Cell;

class BuyButtonProductCell extends Cell
{
    protected int $stock;

    public function mount(int $stock)
    {
        $this->stock = $stock;
    }

    public function getStockProperty()
    {
        return $this->stock;
    }
}
