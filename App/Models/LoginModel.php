<?php

namespace Models;

use App\Database;
use Utils\Token;

class LoginModel
{
    protected $db;
    protected $token;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->token = new Token();
    }

    public function getUser()
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
            $request = "SELECT * FROM user WHERE email = ?";
            $pdo = $this->db->prepare($request);
            $pdo->execute([$email]);

            $user = $pdo->fetch(\PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) 
            {
                // Générer un JWT pour l'utilisateur avec son ID et rôle
                $token = $this->token->generateToken($user['id'], $user['role']);

                return [
                    "success" => true,
                    "message" => "Connexion réussie.",
                    "role" => $user['role'],
                    "user_id" => $user['id'],
                    "token" => $token,  // Retourner le token JWT au client
                ];
            } 
            else 
            {
                return ["success" => false, "message" => "Identifiants incorrects."];
            }
        } 
        catch (\PDOException $e) 
        {
            return ["success" => false, "message" => "Une erreur s'est produite lors de la connexion. Veuillez réessayer plus tard."];
        }
    }

    // Récupérer l'utilisateur par son ID
    public function getUserById($userId)
    {
        try 
        {
            $request = "SELECT * FROM user WHERE id = ?";
            $pdo = $this->db->prepare($request);
            $pdo->execute([$userId]);

            return $pdo->fetch(\PDO::FETCH_ASSOC);
            
        } 
        catch (\PDOException $e) 
        {
            return null;
        }
    }

    // Déconnexion (facultative avec JWT)
    public function logout()
    {
        return ["success" => true, "message" => "Déconnexion réussie."];
    }
}
