<?php

namespace Controllers\SocialNetworkManagement;

use Models\SocialNetworkManagement\DeleteSocialNetworkModel;

class DeleteSocialNetworkController
{
    protected $data;

    public function __construct()
    {
        $this->data = new DeleteSocialNetworkModel();
    }

    public function deleteSocialNetwork()
    {
        return $this->data->deleteSocialNetwork();
    }
}
