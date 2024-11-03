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
        $id = isset($_GET['id']) ? strip_tags($_GET['id']) : null;

        if (empty($id)) 
        {
            return ["success" => false, "message" => "Id manquant."];
        }

        try 
        {
            $this->model->deleteImage($id);
            return ["success" => true, "message" => "Image supprimée avec succès."];
        } 
        catch (\Exception $e)
        {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }
}
