<?php

namespace Controllers;

use Models\DisplayStatusModel;

class DisplayStatusController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DisplayStatusModel();
    }

    public function getStatus()
    {
        return $this->model->getStatus();
    }
}