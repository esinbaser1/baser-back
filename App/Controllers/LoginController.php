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
        $result = $this->loginModel->getUser();
        return $result;
    }
}
