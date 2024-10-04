<?php

namespace Controllers\ContactManagement;

use Models\ContactManagement\DisplayContactTypeOfProjectModel;

class DisplayContactTypeOfProjectController 
{
  protected $model;

  public function __construct()
  {
    $this->model = new DisplayContactTypeOfProjectModel();
  }

  public function getContactTypeOfProject()
  {
    return $this->model->getContactTypeOfProject();
  }
}