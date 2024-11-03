<?php

namespace Models;

use App\Database;

class LoginModel
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

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
            throw new \Exception("Erreur de base de données: " . $e->getMessage());
        }
    }

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
            throw new \Exception("Erreur de base de données: " . $e->getMessage());
        }
    }
}