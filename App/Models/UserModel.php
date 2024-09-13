<?php

namespace Models;

require_once './App/Database.php';
use App\Database;

class UserModel
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function createUser($email, $password)
    {
        // Vérifier si l'email est valide
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ["success" => false, "message" => "Email invalide."];
        }

        // Hacher le mot de passe
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        try {
            // Insérer l'utilisateur dans la base de données
            $request = "INSERT INTO user (email, password) VALUES (?, ?)";
            $pdo = $this->db->prepare($request);
            $pdo->execute([$email, $hashedPassword]);

            return ["success" => true, "message" => "Utilisateur créé avec succès."];
        } catch (\PDOException $e) {
            error_log("Erreur lors de la création de l'utilisateur : " . $e->getMessage());
            return ["success" => false, "message" => "Une erreur s'est produite lors de la création de l'utilisateur."];
        }
    }
}

?>
