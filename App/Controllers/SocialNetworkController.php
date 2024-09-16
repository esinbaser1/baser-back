<?php

namespace Controllers;

use Models\SocialNetworkModel;

class SocialNetworkController
{
    protected $model;

    public function __construct()
    {
        $this->model = new SocialNetworkModel();
    }

    public function getSocialNetworks()
    {
        $socialNetworks = $this->model->fetchAll();
        return [
            "success" => true,
            "data" => $socialNetworks
        ];
    }
}
