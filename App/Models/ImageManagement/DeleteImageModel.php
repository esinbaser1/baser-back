<?php

namespace Models\ImageManagement;

use App\Database;
use PDOException;

class DeleteImageModel
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getImageById($id)
    {
        try 
        {
            $request = "SELECT path FROM image WHERE id = ?";
            $pdo = $this->db->prepare($request);
            $pdo->execute([$id]);
            return $pdo->fetch(\PDO::FETCH_ASSOC); 
        } 
        catch (PDOException $e) 
        {
            throw new \Exception("Erreur de base de données: " . $e->getMessage());
        }
    }

    public function deleteImage($id)
    {
        $image = $this->getImageById($id);

        if (!$image) 
        {
            throw new \Exception("Image introuvable.");
        }

        $imagePath = 'assets/img/' . $image['path'];

        try 
        {
            $request = "DELETE FROM image WHERE id = ?";
            $pdo = $this->db->prepare($request);
            $pdo->execute([$id]);

            if ($pdo->rowCount() > 0) 
            {
                if (file_exists($imagePath) && !unlink($imagePath)) 
                {
                    throw new \Exception("Image supprimée de la base de données mais échec de la suppression du fichier physique.");
                }
                return true; 
            } 
            else 
            {
                throw new \Exception("Image introuvable.");
            }
        } 
        catch (PDOException $e) 
        {
            throw new \Exception("Erreur de base de données: " . $e->getMessage());
        }
    }
}
