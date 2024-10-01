<?php

namespace Controllers\ImageManagement;

use Models\ImageManagement\AddImageModel;

class AddImageController
{
    protected $content;

    public function __construct()
    {
        $this->content = new AddImageModel();
    }

    public function addImages()
    {
        return $this->content->addImage();
    }
}