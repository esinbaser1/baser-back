<?php

namespace Controllers\ContentManagement;

use Models\ContentManagement\AddContentModel;

class AddContentController
{
    protected $model;

    public function __construct()
    {
        $this->model = new AddContentModel();
    }

    public function addContents()
    {
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);
    
        $content = isset($data['content']) ? trim(strip_tags($data['content'])) : null;
        $section = isset($data['section_id']) ? intval($data['section_id']) : null;
        $status = isset($data['status_id']) ? intval($data['status_id']) : null;
    
        if (empty($content) || empty($section) || empty($status)) 
        {
            return ["success" => false, "message" => "Veuillez compléter tous les champs."];
        }
    
        return $this->model->addContent($content, $section, $status);
    }
}