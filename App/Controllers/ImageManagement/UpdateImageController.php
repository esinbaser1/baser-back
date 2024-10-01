<?php

namespace Controllers\ImageManagement;

use Models\ImageManagement\UpdateImageModel;

class UpdateImageController
{
    protected $data;

    public function __construct()
    {
      $this->data = new UpdateImageModel();
    }

    public function updateImage()
    {
      return $this->data->updateImage();
    }

    public function getImageById($id)
    {
        return $this->data->getImageById($id);
    }
}
