<?php

namespace Controllers\ImageManagement;

use Models\ImageManagement\AddImageModel;

class AddImageController
{
    protected $data;

    public function __construct()
    {
        $this->data = new AddImageModel();
    }

    public function addImages()
    {
        return $this->data->addImage();
    }
}