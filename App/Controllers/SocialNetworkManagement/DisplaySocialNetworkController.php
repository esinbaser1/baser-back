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
        try 
        {
            $socialNetwork = $this->model->getSocialNetwork();
            return ["success" => true, "socialNetwork" => $socialNetwork];
        } 
        catch (\Exception $e) 
        {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }
}