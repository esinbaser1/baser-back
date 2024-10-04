<?php

namespace Controllers\ImageManagement;

use Models\ImageManagement\DeleteImageModel;

class DeleteImageController
{
    protected $model;

    public function __construct()
    {
      $this->model = new DeleteImageModel();
    }

    public function deleteImages()
    {
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        $id = isset($data['id']) ? intval($data['id']) : null;

        if (empty($id)) 
        {
            return ["success" => false, "message" => "Id manquant."];
        }
        return $this->model->deleteImage($id);
    }
}