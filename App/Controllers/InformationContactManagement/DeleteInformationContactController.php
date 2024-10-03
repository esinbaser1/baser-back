<?php

namespace Controllers\InformationContactManagement;

use Models\InformationContactManagement\DeleteInformationContactModel;

class DeleteInformationContactController
{
    protected $data;

    public function __construct()
    {
        $this->data = new DeleteInformationContactModel();
    }

    public function deleteInformationContact()
    {
        return $this->data->deleteInformationContact();
    }
}