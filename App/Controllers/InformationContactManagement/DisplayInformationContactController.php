<?php

namespace Controllers\InformationContactManagement;

use Models\InformationContactManagement\DisplayInformationContactModel;

class DisplayInformationContactController
{
    protected $data;

    public function __construct()
    {
        $this->data = new DisplayInformationContactModel();
    }

    public function getInformationContact()
    {
        return $this->data->getInformationContact();
    }
}