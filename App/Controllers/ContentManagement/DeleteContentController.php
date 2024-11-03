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
        $id = isset($_GET['id']) ? strip_tags($_GET['id']) : null;

        if (empty($id)) 
        {
            return ["success" => false, "message" => "Id manquant."];
        }

        try {
            $result = $this->model->deleteContent($id);
            if($result)
            {
                return ["success" => true, "message" => "Contenu supprimé avec succès."];
            }
            else
            {
                return ["success" => false, "message" => "Contenu introuvable."];
            }
        }
        catch(\PDOException $e)
        {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }
}