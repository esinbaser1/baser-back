<?php

namespace Controllers\SocialNetworkManagement;

use Models\SocialNetworkManagement\AddSocialNetworkModel;

class AddSocialNetworkController
{
    protected $data;

    public function __construct()
    {
        $this->data = new AddSocialNetworkModel();
    }

    public function addSocialNetwork()
    {
      return $this->data->addSocialNetwork();
    }
}