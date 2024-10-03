<?php

namespace Controllers\ContactManagement;

use Models\ContactManagement\DisplayContactModel;

class DisplayContactController 
{
  protected $data;

  public function __construct()
  {
    $this->data = new DisplayContactModel();
  }

  public function getContact()
  {
    return $this->data->getContact();
  }
}