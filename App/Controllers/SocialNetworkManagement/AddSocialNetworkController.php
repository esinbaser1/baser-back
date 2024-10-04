<?php

namespace Controllers\SocialNetworkManagement;

use Models\SocialNetworkManagement\AddSocialNetworkModel;

class AddSocialNetworkController
{
    protected $model;

    public function __construct()
    {
        $this->model = new AddSocialNetworkModel();
    }

    public function addSocialNetwork()
    {
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);
    
        $platform = isset($data['platform']) ? trim(strip_tags($data['platform'])) : null;
        $url = isset($data['url']) ? trim(strip_tags($data['url'])) : null;
    
        if (empty($platform) || empty($url))
        {
            return ["success" => false, "message" => "Veuillez compléter tous les champs."];
        }

        if (!filter_var($url, FILTER_VALIDATE_URL)) 
        {
            return ["success" => false, "message" => "URL invalide."];
        }

        return $this->model->addSocialNetwork($platform, $url);
    }
}