<?php

namespace Models\SocialNetworkManagement;

use App\Database;
use PDOException;

class AddSocialNetworkModel
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function addSocialNetwork($platform, $url)
    {
        if ($this->existsInColumn('platform', $platform)) 
        {
            throw new \Exception("Ce nom de réseau social est déjà utilisé.");
        }

        if ($this->existsInColumn('url', $url)) 
        {
            throw new \Exception("Cette URL est déjà utilisée.");
        }

        try 
        {
            $request = "INSERT INTO social_network (platform, url) VALUES (?, ?)";
            $pdo = $this->db->prepare($request);
            $pdo->execute([$platform, $url]);

            return true;
        } 
        catch (PDOException $e) 
        {
            throw new \Exception("Erreur de base de données: " . $e->getMessage()); 
        }
    }

    private function existsInColumn($column, $value)
    {
        $query = "SELECT COUNT(*) FROM social_network WHERE $column = ?";
        $pdo = $this->db->prepare($query);
        $pdo->execute([$value]);
        return $pdo->fetchColumn() > 0;
    }
}