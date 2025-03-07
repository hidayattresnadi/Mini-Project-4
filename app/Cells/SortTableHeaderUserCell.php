<?php

namespace App\Cells;

use App\Libraries\DataParamsUser;
use CodeIgniter\View\Cells\Cell;

class SortTableHeaderUserCell extends Cell
{
    protected DataParamsUser $params;
    protected string $baseUrl;
    protected string $tableField;
    protected string $tableTitleHeader;
    protected string $style;

    public function mount(
        DataParamsUser $params,
        string $baseUrl,
        string $tableField,
        string $tableTitleHeader,
        string $style = "text-white fw-bold text-decoration-none"
    ) {
        $this->params = $params;
        $this->baseUrl = $baseUrl;
        $this->tableField = $tableField;
        $this->tableTitleHeader = $tableTitleHeader;
        $this->style = $style;
    }

    public function getParamsProperty()
    {
        return $this->params;
    }

    public function getBaseUrlProperty()
    {
        return $this->baseUrl;
    }

    public function getTableFieldProperty()
    {
        return $this->tableField;
    }


    public function getTableTitleHeaderProperty()
    {
        return $this->tableTitleHeader;
    }

    public function getStyleProperty()
    {
        return $this->style;
    }
}
