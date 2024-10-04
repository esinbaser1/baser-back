<?php

namespace Controllers\ContactManagement;

use Models\ContactManagement\DisplayContactModel;

class DisplayContactController 
{
  protected $model;

  public function __construct()
  {
    $this->model = new DisplayContactModel();
  }

  public function getContact()
  {
    return $this->model->getContact();
  }
}