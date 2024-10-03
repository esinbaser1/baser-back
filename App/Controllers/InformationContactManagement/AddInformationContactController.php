<?php

namespace Controllers\InformationContactManagement;

use Models\InformationContactManagement\AddInformationContactModel;

class AddInformationContactController
{
    protected $data;

    public function __construct()
    {
        $this->data = new AddInformationContactModel();
    }

    public function addInformationContact()
    {
        return $this->data->addInformationContact();
    }
}