<?php

use CodeIgniter\View\Cells\Cell;

class IsNewProductCell extends Cell
{
    protected bool $isNew;

    public function mount(bool $isNew)
    {
        $this->isNew = $isNew;
    }

    public function getIsNewProperty()
    {
        return $this->isNew;
    }
}
