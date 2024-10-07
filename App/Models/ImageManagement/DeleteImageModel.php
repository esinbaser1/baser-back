<?php

namespace Models\ImageManagement;

use App\Database;

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
            $image = $pdo->fetch(\PDO::FETCH_ASSOC);

            if ($image) 
            {
                return ["success" => true, "image" => $image];
            } 
            else 
            {
                return ["success" => false, "message" => "Image introuvable."];
            }
        } 
        catch (\PDOException $e) 
        {
            return ["success" => false, "message" => "Erreur de base de données: " . $e->getMessage()];
        }
    }

    public function deleteImage($id)
    {
        $imageResult = $this->getImageById($id);

        if (!$imageResult['success']) 
        {
            return $imageResult; 
        }

        $imagePath = 'assets/img/' . $imageResult['image']['path'];

        try 
        {
            // Supprimer l'image de la base de données
            $request = "DELETE FROM image WHERE id = ?";
            $pdo = $this->db->prepare($request);
            $pdo->execute([$id]);

            if ($pdo->rowCount() > 0) 
            {
                // Supprimer le fichier image du dossier si la suppression en base est réussie
                if (file_exists($imagePath)) 
                {
                    if (!unlink($imagePath)) 
                    {
                        return ["success" => true, "message" => "Image supprimée de la base de données mais échec de la suppression du fichier physique."];
                    }
                }
                return ["success" => true, "message" => "Image supprimée avec succès."];
            } 
            else 
            {
                return ["success" => false, "message" => "Image introuvable."];
            }
        } 
        catch (\PDOException $e) 
        {
            return ["success" => false, "message" => "Erreur de base de données"];
        }
    }
}
