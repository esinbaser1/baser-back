<?php

namespace Controllers\ContactManagement;

use Models\ContactManagement\DeleteContactModel;

class DeleteContactController
{
    protected $data;

    public function __construct()
    {
        $this->data = new DeleteContactModel();
    }

    public function deleteContact()
    {
        return $this->data->deleteContact();
    }
}