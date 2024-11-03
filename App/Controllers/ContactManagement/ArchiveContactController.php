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

        try 
        {
            $result = $this->model->archiveContact($id);
            if ($result) 
            {
                return ["success" => true, "message" => "Message archivé avec succès."];
            } 
            else 
            {
                return ["success" => false, "message" => "Message introuvable."];
            }
        } 
        catch (\Exception $e)
        {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }
}