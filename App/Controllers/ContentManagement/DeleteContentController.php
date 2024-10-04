<?php

namespace Controllers\ContentManagement;

use Models\ContentManagement\DeleteContentModel;

class DeleteContentController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DeleteContentModel();
    }

    public function deleteContents()
    {
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        $id = $data['id'] ?? null;

        if (empty($id)) 
        {
            return ["success" => false, "message" => "Id manquant."];
        }
        return $this->model->deleteContent($id);
    }
}