<?php

use App\Libraries\DataParams;
use CodeIgniter\View\Cells\Cell;

class SearchCell extends Cell
{
    protected DataParams $params;
    protected string $label;

    public function mount(DataParams $params, string $label)
    {
        $this->params = $params;
        $this->label = $label;
    }

    public function getParamsProperty()
    {
        return $this->params;
    }

    public function getLabelProperty()
    {
        return $this->label;
    }
}
