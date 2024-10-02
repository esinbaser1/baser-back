<?php

namespace Controllers;

use Models\LoginModel;

class LoginController
{
    protected $data;

    public function __construct()
    {
        $this->data = new LoginModel();
    }

    public function login()
    {
        return $this->data->getUser();
    }

    public function logout()
    {
        return $this->data->logout();
    }
}
