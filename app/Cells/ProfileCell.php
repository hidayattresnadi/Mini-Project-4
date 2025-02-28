<?php

use CodeIgniter\View\Cells\Cell;

class ProfileCell extends Cell
{
    protected array $userData = [];

    public function mount(array $userData)
    {
        $this->userData = $userData;
    }

    public function getUserDataProperty()
    {
        return $this->userData;
    }
}
