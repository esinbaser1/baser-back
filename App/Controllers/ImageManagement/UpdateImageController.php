<?php

namespace Controllers\ImageManagement;

use Models\ImageManagement\UpdateImageModel;

class UpdateImageController
{
    protected $model;

    public function __construct()
    {
      $this->model = new UpdateImageModel();
    }

    public function updateImage()
    {
      return $this->model->updateImage();
    }

    public function getImageById($id)
    {
      if (empty($id)) 
      {
        return ["success" => false, "message" => "ID non fourni"];
      }
        return $this->model->getImageById($id);
    }
}