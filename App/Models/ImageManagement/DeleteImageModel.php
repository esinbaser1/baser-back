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

    // Le modèle attend désormais un ID validé depuis le contrôleur
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
        // Récupérer le chemin de l'image à supprimer
        $imageResult = $this->getImageById($id);

        if (!$imageResult['success']) 
        {
            return $imageResult;  // Si l'image n'existe pas, renvoie le message d'erreur
        }

        $imagePath = 'assets/img/' . $imageResult['image']['path']; // Chemin complet de l'image

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
