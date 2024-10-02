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

    public function addSocialNetwork()
    {
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);
    
        $platform = isset($data['platform']) ? trim(strip_tags($data['platform'])) : null;
        $url = isset($data['url']) ? trim(strip_tags($data['url'])) : null;
    
        if (empty($platform) || empty($url))
        {
          return ["success" => false, "message" => "Veuillez compléter tous les champs."];
        }

        if ($this->existsInColumn('platform', $platform)) {
            return ["success" => false, "message" => "Ce nom de plateforme est déjà utilisé."];
        }
    
        // Vérifier si l'URL existe déjà pour un autre ID
        if ($this->existsInColumn('url', $url)) {
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
            return ["success" => false, "message" => "Database error: " . $e->getMessage()];
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