<?php

namespace Controllers\ContentManagement;

use Models\ContentManagement\DisplayContentModel;

class DisplayContentController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DisplayContentModel();
    }

    public function getContents()
    {
        return $this->model->getContent();
    }
}