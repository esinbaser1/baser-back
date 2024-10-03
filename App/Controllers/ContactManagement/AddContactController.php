<?php

namespace Controllers\ContactManagement;

use Models\ContactManagement\AddContactModel;

class AddContactController
{
    protected $data;

    public function __construct()
    {
        $this->data = new AddContactModel();
    }

    public function addContact()
    {
        return $this->data->addContact();
    }
}