<?php

namespace Controllers\ContactManagement;

use Models\ContactManagement\DisplayContactTypeOfProjectModel;

class DisplayContactTypeOfProjectController 
{
  protected $data;

  public function __construct()
  {
    $this->data = new DisplayContactTypeOfProjectModel();
  }

  public function getContactTypeOfProject()
  {
    return $this->data->getContactTypeOfProject();
  }
}