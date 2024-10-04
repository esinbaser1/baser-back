<?php

namespace Controllers;

use Models\DisplaySectionModel;

class DisplaySectionController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DisplaySectionModel();
    }

    public function getSections()
    {
        return $this->model->getSection();
    }
}