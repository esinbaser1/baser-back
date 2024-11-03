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
        try 
        {
            $statuses = $this->model->getStatus();
            return ["success" => true, "statuses" => $statuses];
        }
        catch(\PDOException $e)
        {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }
}