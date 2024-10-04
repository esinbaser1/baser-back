<?php

namespace Controllers\ContactManagement;

use Models\ContactManagement\DisplayContactStatusModel;

class DisplayContactStatusController 
{
  protected $model;

  public function __construct()
  {
    $this->model = new DisplayContactStatusModel();
  }

  public function getContactStatus()
  {
    return $this->model->getContactStatus();
  }
}