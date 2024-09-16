<?php

namespace Controllers;

use Models\LoginModel;

class LoginController
{
    protected $loginModel;

    public function __construct()
    {
        $this->loginModel = new LoginModel();
    }

    public function login()
    {
        return $this->loginModel->getUser();
    }

    public function logout()
    {
        return $this->loginModel->logout();
    }
}
