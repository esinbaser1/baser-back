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
    try 
    {
      $statuses = $this->model->getContactStatus();
      return ["success" => true, "statuses" => $statuses];
    }
    catch (\Exception $e) 
    {
      return ["success" => false, "message" => $e->getMessage()];
    }
  }
}