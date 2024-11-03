<?php

namespace Controllers\InformationContactManagement;

use Models\InformationContactManagement\DeleteInformationContactModel;

class DeleteInformationContactController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DeleteInformationContactModel();
    }

    public function deleteInformationContact()
    {
        $id = isset($_GET['id']) ? strip_tags($_GET['id']) : null;

        if (empty($id)) 
        {
            return ["success" => false, "message" => "Id manquant."];
        }

        try 
        {
            $result = $this->model->deleteInformationContact($id);
            if ($result) 
            {
                return ["success" => true, "message" => "Information de contact supprimée avec succès."];
            } 
            else 
            {
                return ["success" => false, "message" => "Information de contact introuvable."];
            }
        } 
        catch (\Exception $e) 
        {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }
}