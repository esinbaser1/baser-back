<?php

namespace Controllers;

use Models\LoginModel;
use Utils\Token;

class LoginController
{
    protected $model;
    protected $token;

    public function __construct()
    {
        $this->model = new LoginModel();
        $this->token = new Token();
    }

    public function login()
    {
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        $email = isset($data['email']) ? filter_var($data['email'], FILTER_SANITIZE_EMAIL) : null;
        $password = isset($data['password']) ? strip_tags($data['password']) : null;

        if (empty($email) || empty($password)) 
        {
            return ["success" => false, "message" => "Tous les champs sont obligatoires."];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
        {
            return ["success" => false, "message" => "Identifiants incorrects."];
        }

        try 
        {
            $user = $this->model->getUserByEmail($email);

            if (!$user || !password_verify($password, $user['password'])) 
            {
                return ["success" => false, "message" => "Identifiants incorrects."];
            }

            $token = $this->token->generateToken($user['id'], $user['role']);

            return [
                "success" => true,
                "message" => "Connexion réussie.",
                "role" => $user['role'],
                "user_id" => $user['id'],
                "token" => $token
            ];
        } 
        catch (\Exception $e) 
        {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }

    public function logout()
    {
        return ["success" => true, "message" => "Déconnexion réussie."];
    }
}