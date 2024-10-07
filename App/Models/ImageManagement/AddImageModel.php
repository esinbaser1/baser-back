<?php

namespace Models\ImageManagement;

use App\Database;
use Lib\Slug;
use Utils\ConvertToWebP;

class AddImageModel
{
    protected $db;
    protected $slug;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->slug = new Slug();
    }

    public function addImage($imageName, $imagePath, $section)
    {
        if ($this->nameExist($imageName)) 
        {
            return ["success" => false, "message" => "Ce nom est déjà utilisé."];
        }

        // Création du slug pour l'image
        $productSlug = $this->slug->sluguer($imageName);

        // Chemin permanent où stocker les images
        $imageLocation = "assets/img/";

        // Chemin temporaire du fichier
        $tempImagePath = $imageLocation . basename($imagePath['name']);

        // Déplacement du fichier téléchargé vers le dossier permanent
        if (!move_uploaded_file($imagePath['tmp_name'], $tempImagePath)) 
        {
            return ["success" => false, "message" => "Échec du transfert du fichier téléchargé."];
        }

        // Conversion en WebP
        $converter = new ConvertToWebP();
        $webpImagePath = $converter->convertToWebP($tempImagePath, $imageLocation, $productSlug, $section);

        if (!$webpImagePath) 
        {
            return ["success" => false, "message" => "Échec de la conversion de l'image au format WebP."];
        }

        // Suppression du fichier temporaire après conversion
        if (file_exists($tempImagePath)) 
        {
            unlink($tempImagePath);
        }

        // Insertion de l'image dans la base de données
        try 
        {
            $request = "INSERT INTO image (name, path, slug, section_id) VALUES (?, ?, ?, ?)";
            $pdo = $this->db->prepare($request);
            $pdo->execute([$imageName, '', $productSlug, $section]);

            // Récupération de l'ID de l'image
            $imageId = $this->db->lastInsertId();

            // Renommage du fichier WebP avec l'ID de l'image
            $newWebpFileName = $productSlug . '-' . $imageId . '-' . $section . '.webp';
            $newWebpImagePath = $imageLocation . $newWebpFileName;

            if (!rename($webpImagePath, $newWebpImagePath)) 
            {
                return ["success" => false, "message" => "Échec du renommage de l'image WebP."];
            }

            // Mise à jour du chemin de l'image dans la base de données
            $updateRequest = "UPDATE image SET path = ? WHERE id = ?";
            $pdo = $this->db->prepare($updateRequest);
            $pdo->execute([$newWebpFileName, $imageId]);

            return ["success" => true, "message" => "Image ajouté avec succès!"];
        } 
        catch (\PDOException $e) 
        {
            return ["success" => false, "message" => "Erreur de base de données: " . $e->getMessage()];
        }
    }

    private function nameExist($imageName)
    {
        $pdo = $this->db->prepare("SELECT COUNT(*) FROM image WHERE name = ?");
        $pdo->execute([$imageName]);
        return $pdo->fetchColumn() > 0;
    }
}
