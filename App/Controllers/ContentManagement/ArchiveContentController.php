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


        return $this->model->archiveContent($id);
    }
}