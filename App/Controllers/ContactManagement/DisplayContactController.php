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
    try 
    {
      $contact = $this->model->getContact();
      return ["success" => true, "contact" => $contact];
    } 
    catch (\Exception $e) 
    {
      return ["success" => false, "message" => $e->getMessage()];
    }
  }
}
