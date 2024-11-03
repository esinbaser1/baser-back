<?php

namespace Controllers\ContentManagement;

use Models\ContentManagement\ArchiveContentModel;

class ArchiveContentController
{
    protected $model;

    public function __construct()
    {
        $this->model = new ArchiveContentModel();
    }

    public function archiveContent()
    {
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        $id = isset($data['id']) ? intval($data['id']) : null;

        if (empty($id)) 
        {
            return ["success" => false, "message" => "Id manquant."];
        }

        try 
        {
            $result = $this->model->archiveContent($id);

            if($result)
            {
                return ["success" => true, "message" => "Contenu archivé avec succès."];
            }
            else 
            {
                return ["success" => false, "message" => "Message introuvable."];
            }
        }
        catch(\PDOException $e)
        {
            return ["success" => false, "message" => $e->getMessage()];
        }

    }
}
