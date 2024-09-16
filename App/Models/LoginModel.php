<?php

namespace Models;

use App\Database;
use Utils\AuthUtils;
use Utils\Token;

class LoginModel
{
    protected $db;
    protected $token;
    protected $authUtils;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->token = new Token();
        $this->authUtils = new AuthUtils(); 
    }


    public function getUser()
    {
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        $email = isset($data['email']) ? filter_var($data['email'], FILTER_SANITIZE_EMAIL) : null;
        $password = isset($data['password']) ? strip_tags($data['password']) : null;

        if (empty($email) || empty($password)) {
            return ["success" => false, "message" => "Tous les champs sont obligatoires."];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ["success" => false, "message" => "Identifiants incorrects."];
        }

        try {
            $request = "SELECT * FROM user WHERE email = ?";
            $pdo = $this->db->prepare($request);
            $pdo->execute([$email]);

            $user = $pdo->fetch(\PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $token = $this->token->generateToken();
                $tokenExpireAt = $this->token->formatDate('+30 days');

                $request = "INSERT INTO session (user_id, token, expires_at) VALUES (?, ?, ?)";
                $pdo = $this->db->prepare($request);
                $pdo->execute([$user['id'], $token, $tokenExpireAt]);

                return [
                    "success" => true,
                    "message" => "Connexion réussie.",
                    "role" => $user['role'],
                    "user_id" => $user['id'],
                    "token" => $token,
                ];
            } else {
                return ["success" => false, "message" => "Identifiants incorrects."];
            }
        } catch (\PDOException $e) {
            error_log("Erreur lors de la tentative de connexion : " . $e->getMessage());
            
            return ["success" => false, "message" => "Une erreur s'est produite lors de la connexion. Veuillez réessayer plus tard."];
        }
    }

    public function getUserById($userId)
    {
        try {
            $request = "SELECT * FROM user WHERE id = ?";
            $pdo = $this->db->prepare($request);
            $pdo->execute([$userId]);

            return $pdo->fetch(\PDO::FETCH_ASSOC);
            
        } catch (\PDOException $e) {
            error_log("Erreur lors de la recherche d'un utilisateur par son ID : " . $e->getMessage());
            return null;
        }
    }
    
    public function logout()
    {
        $token = $this->authUtils->extractTokenFromHeaders(); 

        if ($token) {
            try {
                $request = "DELETE FROM session WHERE token = ?";
                $pdo = $this->db->prepare($request);
                $pdo->execute([$token]);

                return ["success" => true, "message" => "Déconnexion réussie."];
            } catch (\PDOException $e) {
                error_log("Erreur lors de la déconnexion : " . $e->getMessage());
                return ["success" => false, "message" => "Une erreur s'est produite lors de la déconnexion."];
            }
        } else {
            return ["success" => false, "message" => "Token manquant."];
        }
    }

    
}
