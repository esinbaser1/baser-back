<?php

namespace Controllers\SocialNetworkManagement;

use Models\SocialNetworkManagement\DeleteSocialNetworkModel;

class DeleteSocialNetworkController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DeleteSocialNetworkModel();
    }

    public function deleteSocialNetwork()
    {
        $id = isset($_GET['id']) ? strip_tags($_GET['id']) : null;

        if (empty($id)) 
        {
            return ["success" => false, "message" => "Id manquant."];
        }

        try 
        {
            $result = $this->model->deleteSocialNetwork($id);
            if ($result) 
            {
                return ["success" => true, "message" => "Réseau social supprimé avec succès."];
            }
            else 
            {
                return ["success" => false, "message" => "Réseau social introuvable."];
            }
        } 
        catch (\Exception $e) 
        {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }
}
