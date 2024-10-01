<?php

namespace Controllers\ImageManagement;

use Models\ImageManagement\DisplayImageModel;

class DisplayImageController
{
  protected $data;

  public function __construct()
  {
    $this->data = new DisplayImageModel();
  }

  public function getImages()
  {
    return $this->data->getImage();
  }
}
