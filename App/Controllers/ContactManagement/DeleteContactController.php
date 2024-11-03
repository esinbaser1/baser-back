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

        $contactId = isset($_GET['id']) ? strip_tags($_GET['id']) : null;

        if (empty($contactId)) 
        {
            return ["success" => false, "message" => "Id manquant."];
        }

       try 
       {
        $result = $this->model->deleteContact($contactId);

        if($result)
        {
            return ["success" => true, "message" => "Message supprimé avec succès."];
        }
        else {
            return ["success" => false, "message" => "Message introuvable."];
        }

       }
       catch(\PDOException $e)
       {
        return ["success" => false, "message" => $e->getMessage()];
       }
    }
}