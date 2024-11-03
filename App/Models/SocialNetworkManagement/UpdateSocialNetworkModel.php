<?php

namespace Models\SocialNetworkManagement;

use App\Database;
use PDOException;

class UpdateSocialNetworkModel
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function updateSocialNetwork($platform, $url, $id)
    {
        $existingSocialNetwork = $this->getSocialNetworkById($id);

        if (!$existingSocialNetwork) 
        {
            throw new \Exception("Réseau social introuvable.");
        }

        if (
            $platform === $existingSocialNetwork['platform'] &&
            $url === $existingSocialNetwork['url']
        ) 
        {
            return false; 
        }

        if ($this->existsInColumn('platform', $platform, $id)) 
        {
            throw new \Exception("Ce nom de plateforme est déjà utilisé.");
        }

        if ($this->existsInColumn('url', $url, $id)) 
        {
            throw new \Exception("Cette URL est déjà utilisée.");
        }

        try 
        {
            $request = "UPDATE social_network SET platform = ?, url = ? WHERE id = ?";
            $pdo = $this->db->prepare($request);
            $pdo->execute([$platform, $url, $id]);

            return $pdo->rowCount() > 0; 
        } 
        catch (PDOException $e) 
        {
            throw new \Exception("Erreur de base de données: " . $e->getMessage());
        }
    }

    public function getSocialNetworkById($id)
    {
        try 
        {
            $request = "SELECT * FROM social_network WHERE id = ?";
            $pdo = $this->db->prepare($request);
            $pdo->execute([$id]);
            return $pdo->fetch(\PDO::FETCH_ASSOC); 
        } 
        catch (PDOException $e) 
        {
            throw new \Exception("Erreur de base de données: " . $e->getMessage());
        }
    }

    private function existsInColumn($column, $value, $id = null)
    {
        $query = "SELECT COUNT(*) FROM social_network WHERE $column = ? AND id != ?";
        $pdo = $this->db->prepare($query);
        $pdo->execute([$value, $id]);
        return $pdo->fetchColumn() > 0;
    }
}
