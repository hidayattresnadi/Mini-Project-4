<?php

use App\Libraries\DataParams;
use CodeIgniter\View\Cells\Cell;

class FilterPriceRangeCell extends Cell
{
    protected array $priceRanges = [];
    protected DataParams $params;

    public function mount(array $priceRanges, DataParams $params)
    {
        $this->priceRanges = $priceRanges;
        $this->params = $params;
    }

    public function getPriceRangesProperty()
    {
        return $this->priceRanges;
    }

    public function getParamsProperty()
    {
        return $this->params;
    }
}
