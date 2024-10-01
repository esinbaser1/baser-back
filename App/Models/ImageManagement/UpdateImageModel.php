<?php

namespace Models\ImageManagement;

use App\Database;
use Utils\ConvertToWebP;
use Lib\Slug;

class UpdateImageModel
{
    protected $db;
    protected $slug;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->slug = new Slug();
    }

    public function getImageById($id)
    {
        try 
        {
            $request = "SELECT * FROM image WHERE id = ?";
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

    public function updateImage()
    {
        $imageName = isset($_POST['name']) ? trim(strip_tags($_POST['name'])) : null;
        $imagePath = isset($_FILES['path']) && $_FILES['path']['error'] === UPLOAD_ERR_OK ? $_FILES['path'] : null;
        $section = isset($_POST['section_id']) ? intval($_POST['section_id']) : null;
        $id = isset($_POST['idImage']) ? intval($_POST['idImage']) : null;

        // Vérifier si le nom de l'image existe déjà pour un autre ID
        if ($this->nameExist($imageName, $id)) 
        {
            return ["success" => false, "message" => "Ce nom est déjà utilisé."];
        }

        // Réutilisation de la méthode getImageById pour récupérer l'image existante
        $existingImageResult = $this->getImageById($id);

        if (!$existingImageResult['success']) 
        {
            return $existingImageResult;  // Retourner le message d'erreur si l'image n'existe pas
        }

        $existingImage = $existingImageResult['image'];

        // Comparer les nouvelles données avec celles existantes
        if (
            $imageName == $existingImage['name'] &&
            $section == $existingImage['section_id'] &&
            !$imagePath // Pas de nouveau fichier image fourni
        ) 
        {
            return ["success" => false, "message" => "Aucun changement détecté."];
        }

        $productSlug = $this->slug->sluguer($imageName);
        $imageLocation = "assets/img/";

        // Si un nouveau fichier image est fourni, on le traite
        if ($imagePath && $imagePath['tmp_name']) 
        {
            // Vérification du type MIME et de la taille du fichier après validation de l'existence du fichier
            $mimeType = mime_content_type($imagePath['tmp_name']);
            $validMimeTypes = ['image/jpeg', 'image/png', 'image/webp'];

            if (!in_array($mimeType, $validMimeTypes)) 
            {
                return ["success" => false, "message" => "Le fichier doit être une image valide (JPEG, PNG, WebP)."];
            }

            // Vérification de la taille du fichier (maximum 5 Mo)
            if ($imagePath['size'] > 5 * 1024 * 1024) 
            { 
                return ["success" => false, "message" => "La taille de l'image ne doit pas dépasser 5 Mo."];
            }

            $oldImagePath = $imageLocation . $existingImage['path'];

            // Transférer le nouveau fichier image
            $tempImagePath = $imageLocation . basename($imagePath['name']);
            if (!move_uploaded_file($imagePath['tmp_name'], $tempImagePath)) 
            {
                return ["success" => false, "message" => "Échec du transfert du fichier téléchargé."];
            }

            // Vérification de la présence du fichier transféré
            if (!file_exists($tempImagePath)) 
            {
                return ["success" => false, "message" => "Le fichier n'a pas été transféré correctement."];
            }

            // Convertir la nouvelle image en WebP
            $converter = new ConvertToWebP();
            $webpImagePath = $converter->convertToWebP($tempImagePath, $imageLocation, $productSlug, $section);

            if (!$webpImagePath || !file_exists($webpImagePath)) 
            {
                return ["success" => false, "message" => "Échec de la conversion de l'image au format WebP."];
            }

            // Suppression du fichier temporaire après conversion
            if (file_exists($tempImagePath)) 
            {
                unlink($tempImagePath);
            }

            // Ajouter l'horodatage dans le nom du fichier WebP pour éviter les conflits de cache
            $newWebpFileName = $productSlug . '-' . $id . '-' . $section . '-' . time() . '.webp';
            $newWebpImagePath = $imageLocation . $newWebpFileName;

            if (!rename($webpImagePath, $newWebpImagePath)) 
            {
                error_log("Erreur lors du renommage du fichier WebP: " . $webpImagePath);
                return ["success" => false, "message" => "Échec du renommage de l'image WebP."];
            }

            // Supprimer l'ancienne image si elle existe
            if (file_exists($oldImagePath)) 
            {
                if (!unlink($oldImagePath)) 
                {
                    return ["success" => false, "message" => "Échec de la suppression de l'ancienne image."];
                }
            }
        } 
        else 
        {
            // Si aucune nouvelle image n'est fournie, garder l'ancien chemin
            $newWebpFileName = $existingImage['path'];
        }

        // Mettre à jour les informations dans la base de données
        try 
        {
            $request = "UPDATE image SET name = ?, path = ?, slug = ?, section_id = ? WHERE id = ?";
            $pdo = $this->db->prepare($request);
            $pdo->execute([$imageName, $newWebpFileName, $productSlug, $section, $id]);

            return ["success" => true, "message" => "Image mise à jour avec succès!", "image" => [
                'id' => $id,
                'name' => $imageName,
                'path' => $newWebpFileName,
                'slug' => $productSlug,
                'section_id' => $section
            ]];
        } 
        catch (\PDOException $e) 
        {
            return ["success" => false, "message" => "Erreur de base de données: " . $e->getMessage()];
        }
    }

    private function nameExist($imageName, $id = null) 
    {
        $request = "SELECT COUNT(*) FROM image WHERE name = ? AND id != ?";
        $pdo = $this->db->prepare($request);
        $pdo->execute([$imageName, $id]);
        return $pdo->fetchColumn() > 0;
    }
}
