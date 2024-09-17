<?php

namespace Controllers;

use Models\DisplayStatusModel;

class DisplayStatusController
{
    protected $status;

    public function __construct()
    {
        $this->status = new DisplayStatusModel();
    }

    public function getStatus()
    {
        return $this->status->getStatus();
    }
}
