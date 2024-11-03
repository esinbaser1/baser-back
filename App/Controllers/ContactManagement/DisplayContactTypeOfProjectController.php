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
    try 
    {
      $typeOfProject = $this->model->getContactTypeOfProject();
      return ["success" => true, "typeOfProject" => $typeOfProject];
    }
    catch (\Exception $e) 
    {
      return ["success" => false, "message" => $e->getMessage()];
    }
  }
}