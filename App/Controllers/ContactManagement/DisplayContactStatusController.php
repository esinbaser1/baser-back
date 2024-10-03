<?php

namespace Controllers\ContactManagement;

use Models\ContactManagement\DisplayContactStatusModel;

class DisplayContactStatusController 
{
  protected $data;

  public function __construct()
  {
    $this->data = new DisplayContactStatusModel();
  }

  public function getContactStatus()
  {
    return $this->data->getContactStatus();
  }
}