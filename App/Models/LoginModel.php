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

    // Récupérer l'utilisateur par email
    public function getUserByEmail($email)
    {
        try 
        {
            $request = "SELECT * FROM user WHERE email = ?";
            $pdo = $this->db->prepare($request);
            $pdo->execute([$email]);

            return $pdo->fetch(\PDO::FETCH_ASSOC);
        } 
        catch (\PDOException $e) 
        {
            return null; // Gestion des erreurs si la base de données échoue
        }
    }

    // Générer le token JWT
    public function generateToken($userId, $role)
    {
        return $this->token->generateToken($userId, $role);
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
            return null; // Retourner null en cas d'échec
        }
    }

    // Déconnexion (facultative avec JWT)
    public function logout()
    {
        return ["success" => true, "message" => "Déconnexion réussie."];
    }
}
