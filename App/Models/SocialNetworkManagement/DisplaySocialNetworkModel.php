<?php

namespace Models\SocialNetworkManagement;

use App\Database;
use PDOException;

class DisplaySocialNetworkModel
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getSocialNetwork()
    {
        try 
		{
            $request = "SELECT * FROM social_network";
            $pdo = $this->db->query($request);
            return $pdo->fetchAll(\PDO::FETCH_ASSOC); 
        } 
		catch (PDOException $e) 
		{
            throw new \Exception("Erreur de base de données: " . $e->getMessage());
        }
    }
}