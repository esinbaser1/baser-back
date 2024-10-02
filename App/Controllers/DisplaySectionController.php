<?php

namespace Controllers;

use Models\DisplaySectionModel;

class DisplaySectionController
{
    protected $data;

    public function __construct()
    {
        $this->data = new DisplaySectionModel();
    }

    public function getSections()
    {
        return $this->data->getSection();
    }
}