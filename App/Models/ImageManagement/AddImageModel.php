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

    public function addImage()
    {
        $imageName = isset($_POST['name']) ? trim(strip_tags($_POST['name'])) : null;
        $imagePath = isset($_FILES['path']) ? $_FILES['path'] : null;
        $section = isset($_POST['section_id']) ? intval($_POST['section_id']) : null;
    
        if (empty($imageName) || empty($section) || empty($imagePath)) 
        {
            return ["success" => false, "message" => "Veuillez compléter tous les champs."];
        }
    
        if ($this->nameExist($imageName)) 
        {
            return ["success" => false, "message" => "Ce nom est déjà utilisé."];
        }
    
        $productSlug = $this->slug->sluguer($imageName);

        $imageLocation = "assets/img/";

        $tempImagePath = $imageLocation . basename($imagePath['name']);
    
        if (!move_uploaded_file($imagePath['tmp_name'], $tempImagePath)) 
        {
            return ["success" => false, "message" => "Échec du transfert du fichier téléchargé."];
        }
    
        $converter = new ConvertToWebP();
        $webpImagePath = $converter->convertToWebP($tempImagePath, $imageLocation, $productSlug, $section);
    
        if (!$webpImagePath) 
        {
            return ["success" => false, "message" => "Échec de la conversion de l'image au format WebP."];
        }
    
        try 
        {
            $request = "INSERT INTO image (name, path, slug, section_id) VALUES (?, ?, ?, ?)";
            $pdo = $this->db->prepare($request);
            $pdo->execute([$imageName, '', $productSlug, $section]);
    
            $imageId = $this->db->lastInsertId();
    
            $newWebpFileName = $productSlug . '-' . $imageId . '-' . $section . '.webp';
            $newWebpImagePath = $imageLocation . $newWebpFileName;
    
            if (!rename($webpImagePath, $newWebpImagePath)) 
            {
                return ["success" => false, "message" => "Échec du renommage de l'image WebP."];
            }
    
            $updateRequest = "UPDATE image SET path = ? WHERE id = ?";
            $pdo = $this->db->prepare($updateRequest);
            $pdo->execute([$newWebpFileName, $imageId]);
    
            $newContent = [
                'id' => $imageId,
                'name' => $imageName,
                'path' => $newWebpFileName,
                'slug' => $productSlug, 
                'section_id' => $section
            ];
    
            return ["success" => true, "message" => "Contenu ajouté avec succès!", "content" => $newContent];
    
        } 
        catch (\PDOException $e) 
        {
            error_log("Error when creating content: " . $e->getMessage());
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

