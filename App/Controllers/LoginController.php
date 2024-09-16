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

    public function getUserRole($userId)
    {
        $user = $this->loginModel->getUserById($userId);
        return $user ? $user['role'] : null;
    }
    
    public function logout($userId)
    {
        return $this->loginModel->logout($userId);
    }
}
