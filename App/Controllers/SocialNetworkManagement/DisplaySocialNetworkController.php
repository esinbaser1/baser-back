<?php

namespace Controllers\SocialNetworkManagement;

use Models\SocialNetworkManagement\DisplaySocialNetworkModel;

class DisplaySocialNetworkController
{
    protected $data;

    public function __construct()
    {
        $this->data = new DisplaySocialNetworkModel();
    }

    public function getSocialNetwork()
    {
        return $this->data->getSocialNetwork();
    }
}