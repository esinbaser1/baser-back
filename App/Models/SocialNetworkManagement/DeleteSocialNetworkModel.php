<?php

namespace Models\SocialNetworkManagement;

use App\Database;
use PDOException;

class DeleteSocialNetworkModel
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function deleteSocialNetwork($id)
    {
        try 
        {
            $request = "DELETE FROM social_network WHERE id = ?";
            $pdo = $this->db->prepare($request);
            $pdo->execute([$id]);

            return $pdo->rowCount() > 0; 
        } 
        catch (PDOException $e) 
        {
            throw new \Exception("Erreur de base de données: " . $e->getMessage());
        }
    }
}
