<?php

namespace Controllers\SocialNetworkManagement;

use Models\SocialNetworkManagement\UpdateSocialNetworkModel;

class UpdateSocialNetworkController
{
    protected $model;

    public function __construct()
    {
        $this->model = new UpdateSocialNetworkModel();
    }

    public function updateSocialNetwork()
    {
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        $platform = isset($data['platform']) ? trim(strip_tags($data['platform'])) : null;
        $url = isset($data['url']) ? trim(strip_tags($data['url'])) : null;
        $id = isset($data['idSocialNetwork']) ? intval($data['idSocialNetwork']) : null;

        if (empty($platform) || empty($url) || empty($id)) 
        {
            return ["success" => false, "message" => "Tous les champs doivent être remplis."];
        }

        if (!filter_var($url, FILTER_VALIDATE_URL)) 
        {
            return ["success" => false, "message" => "URL invalide."];
        }

        return $this->model->updateSocialNetwork($platform, $url, $id);
    }

    public function getSocialNetworkById($id)
    {
        if (empty($id)) {
            return ["success" => false, "message" => "ID non fourni"];
        }
        return $this->model->getSocialNetworkById($id);
    }
}
