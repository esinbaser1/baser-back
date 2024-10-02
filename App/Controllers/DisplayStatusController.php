<?php

namespace Controllers;

use Models\DisplayStatusModel;

class DisplayStatusController
{
    protected $data;

    public function __construct()
    {
        $this->data = new DisplayStatusModel();
    }

    public function getStatus()
    {
        return $this->data->getStatus();
    }
}