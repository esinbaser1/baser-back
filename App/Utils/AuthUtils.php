<?php

namespace Utils;

use Models\LoginModel;
use Utils\Token;

class AuthUtils
{
    protected $token;

    public function __construct()
    {
        $this->token = new Token();
    }

    public function extractTokenFromHeaders()
    {
        $headers = getallheaders();
        if (isset($headers['Authorization'])) {
            return str_replace('Bearer ', '', $headers['Authorization']);
        }
        return null;
    }

public function verifyAccess($requiredRole = 'admin')
    {
        $token = $this->extractTokenFromHeaders();

        if (!$token) {
            http_response_code(401);
            return ["success" => false, "message" => "Authorization header missing"];
        }

        $tokenVerification = $this->token->verifyToken($token);

        if (!$tokenVerification['success']) {
            http_response_code(401);
            return $tokenVerification;
        }

        $userId = $tokenVerification['user_id'];
        $userRole = $this->getUserRole($userId);

        if ($userRole !== $requiredRole) {
            http_response_code(403);
            return ["success" => false, "message" => "Access forbidden: insufficient rights"];
        }

        return null;
    }

    protected function getUserRole($userId)
    {
        $loginModel = new LoginModel();
        $user = $loginModel->getUserById($userId); // récupère l'user à partir de son ID
        return $user ? $user['role'] : null; // retourne le rôle de l'user s'il existe, sinon retourne null
    }
}
