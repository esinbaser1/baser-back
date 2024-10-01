<?php

namespace Controllers\ImageManagement;

use Models\ImageManagement\DeleteImageModel;

class DeleteImageController
{
    protected $data;

    public function __construct()
    {
      $this->data = new DeleteImageModel();
    }

    public function deleteImages()
    {
      return $this->data->deleteImage();
    }
}
