<?php

namespace Models\SocialNetworkManagement;

use App\Database;

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
            return ["success" => false, "message" => "Ce nom de réseau social est déjà utilisé."];
        }

        if ($this->existsInColumn('url', $url)) 
        {
            return ["success" => false, "message" => "Cette URL est déjà utilisée."];
        }

        try 
        {
            $request = "INSERT INTO social_network (platform, url) VALUES (?, ?)";
            $pdo = $this->db->prepare($request);
            $pdo->execute([$platform, $url]);
        
            return ["success" => true, "message" => "Réseau social ajouté avec succès!"];
        } 
        catch (\PDOException $e) 
        {
            return ["success" => false, "message" => "Erreur de base de données: " . $e->getMessage()];
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