<?php

namespace Controllers\SocialNetworkManagement;

use Models\SocialNetworkManagement\UpdateSocialNetworkModel;

class UpdateSocialNetworkController
{
    protected $data;

    public function __construct()
    {
        $this->data = new UpdateSocialNetworkModel();
    }

    public function updateSocialNetwork()
    {
        return $this->data->updateSocialNetwork();
    }

    public function getSocialNetworkById($id)
    {
        return $this->data->getSocialNetworkById($id);
    }
}