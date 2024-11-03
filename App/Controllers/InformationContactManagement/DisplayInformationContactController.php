<?php

namespace Controllers\InformationContactManagement;

use Models\InformationContactManagement\DisplayInformationContactModel;

class DisplayInformationContactController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DisplayInformationContactModel();
    }

    public function getInformationContact()
    {
        try 
        {
            $information = $this->model->getInformationContact();
            return ["success" => true, "information" => $information];
        } 
        catch (\Exception $e) 
        {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }
}
