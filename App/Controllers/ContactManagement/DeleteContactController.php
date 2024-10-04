<?php

namespace Controllers\ContactManagement;

use Models\ContactManagement\DeleteContactModel;

class DeleteContactController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DeleteContactModel();
    }

    public function deleteContact()
    {
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        $contactId = isset($data['id']) ? intval($data['id']) : null;

        if (empty($contactId)) 
        {
            return ["success" => false, "message" => "Id manquant."];
        }

        return $this->model->deleteContact($contactId);
    }
}