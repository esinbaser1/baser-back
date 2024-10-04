<?php

namespace Controllers\ContentManagement;

use Models\ContentManagement\UpdateContentModel;

class UpdateContentController
{
    protected $model;

    public function __construct()
    {
        $this->model = new UpdateContentModel();
    }

    public function updateContent()
    {
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        $content = isset($data['content']) ? trim(strip_tags($data['content'])) : null;
        $section = isset($data['section_id']) ? intval($data['section_id']) : null;
        $status = isset($data['status_id']) ? intval($data['status_id']) : null;
        $id = isset($data['idContent']) ? intval($data['idContent']) : null;

        if (empty($content) || empty($section) || empty($status) || empty($id)) 
        {
            return ["success" => false, "message" => "Tous les champs doivent être remplis."];
        }

        $existingContentResult = $this->getContentById($id);

        if (!$existingContentResult['success']) 
        {
            return $existingContentResult; 
        }

        $existingContent = $existingContentResult['content'];

        if (
            $content === $existingContent['content'] &&
            $section === intval($existingContent['section_id']) &&
            $status === intval($existingContent['status_id'])
        ) 
        {
            return ["success" => false, "message" => "Aucun changement détecté."];
        }

        return $this->model->updateContent($id, $content, $section, $status);
    }

    public function getContentById($id)
    {
        if (empty($id)) 
        {
            return ["success" => false, "message" => "ID non fourni"];
        }
        
        return $this->model->getContentById($id);
    }
}