<?php

namespace Controllers\ImageManagement;

use Models\ImageManagement\AddImageModel;

class AddImageController
{
    protected $model;

    public function __construct()
    {
        $this->model = new AddImageModel();
    }

    public function addImages()
    {
        $imageName = isset($_POST['name']) ? trim(strip_tags($_POST['name'])) : null;
        $imagePath = isset($_FILES['path']) && $_FILES['path']['error'] === UPLOAD_ERR_OK ? $_FILES['path'] : null;
        $section = isset($_POST['section_id']) ? intval($_POST['section_id']) : null;

        if (empty($imageName) || empty($section) || empty($imagePath)) 
        {
            return ["success" => false, "message" => "Veuillez compléter tous les champs."];
        }

        $mimeType = mime_content_type($imagePath['tmp_name']);
        $validMimeTypes = ['image/jpeg', 'image/png', 'image/webp'];

        if (!in_array($mimeType, $validMimeTypes)) 
        {
            return ["success" => false, "message" => "Le fichier doit être une image valide (JPEG, PNG, WebP)."];
        }

        if ($imagePath['size'] > 5 * 1024 * 1024) 
        {
            return ["success" => false, "message" => "La taille de l'image ne doit pas dépasser 5 Mo."];
        }

        try 
        {
            $this->model->addImage($imageName, $imagePath, $section);
            return ["success" => true, "message" => "Image ajoutée avec succès!"];
        } 
        catch (\Exception $e) 
        {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }
}
