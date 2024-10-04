<?php

namespace Controllers\SocialNetworkManagement;

use Models\SocialNetworkManagement\DisplaySocialNetworkModel;

class DisplaySocialNetworkController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DisplaySocialNetworkModel();
    }

    public function getSocialNetwork()
    {
        return $this->model->getSocialNetwork();
    }
}