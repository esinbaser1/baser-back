<?php

namespace Controllers\ImageManagement;

use Models\ImageManagement\DisplayImageModel;

class DisplayImageController
{
  protected $model;

  public function __construct()
  {
    $this->model = new DisplayImageModel();
  }

  public function getImages()
  {
    return $this->model->getImage();
  }
}
