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
        return $this->model->getInformationContact();
    }
}