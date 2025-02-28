<?php

use CodeIgniter\View\Cells\Cell;

class IsOnSaleProductCell extends Cell
{
    protected bool $isOnSale;

    public function mount(bool $isOnSale)
    {
        $this->isOnSale = $isOnSale;
    }

    public function getIsOnSaleProperty()
    {
        return $this->isOnSale;
    }
}
