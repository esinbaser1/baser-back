<?php

namespace Controllers\InformationContactManagement;

use Models\InformationContactManagement\UpdateInformationContactModel;

class UpdateInformationContactController
{
    protected $data;

    public function __construct()
    {
        $this->data = new UpdateInformationContactModel();
    }

    public function updateInformationContact()
    {
        return $this->data->updateInformationContact();
    }

    public function getInformationContactById($id)
    {
        return $this->data->getInformationContactById($id);
    }
}
