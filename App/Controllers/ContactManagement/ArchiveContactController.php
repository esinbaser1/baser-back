<?php

namespace Controllers\ContactManagement;

use Models\ContactManagement\ArchiveContactModel;

class ArchiveContactController
{
    protected $model;

    public function __construct()
    {
        $this->model = new ArchiveContactModel();
    }

    public function archiveContact()
    {
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        $id = isset($data['id']) ? intval($data['id']) : null;

        if (empty($id)) 
        {
            return ["success" => false, "message" => "Id manquant."];
        }

        return $this->model->archiveContact($id);
    }
}