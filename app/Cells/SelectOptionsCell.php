<?php

use App\Libraries\DataParams;
use CodeIgniter\View\Cells\Cell;

class SelectOptionsCell extends Cell
{
    protected DataParams $params;
    protected string $label;
    protected string $paramsName;
    protected array $datas;
    protected array $accessField;
    protected string $optionsSelectAll;
    protected string $style;
    protected bool $optionsValueNull;

    public function mount(
        DataParams $params,
        string $label,
        string $paramsName,
        array $datas,
        array $accessField,
        string $optionsSelectAll,
        string $style = "col-md-2 ms-md-5",
        bool $optionsValueNull = true
    ) {
        $this->params = $params;
        $this->label = $label;
        $this->paramsName = $paramsName;
        $this->datas = $datas;
        $this->accessField = $accessField;
        $this->optionsSelectAll = $optionsSelectAll;
        $this->style = $style;
        $this->optionsValueNull = $optionsValueNull;
    }

    public function getParamsProperty()
    {
        return $this->params;
    }

    public function getLabelProperty()
    {
        return $this->label;
    }

    public function getParamsNameProperty()
    {
        return $this->paramsName;
    }

    public function getDatasProperty()
    {
        return $this->datas;
    }

    public function getAccessFieldProperty()
    {
        return $this->accessField;
    }

    public function getOptionsSelectAllProperty()
    {
        return $this->optionsSelectAll;
    }

    public function getStyleProperty()
    {
        return $this->style;
    }

    public function getOptionsValueNullProperty()
    {
        return $this->optionsValueNull;
    }
}
