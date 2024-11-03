<?php

namespace Controllers;

use Models\DisplaySectionModel;

class DisplaySectionController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DisplaySectionModel();
    }

    public function getSections()
    {
        try 
        {
            $sections = $this->model->getSection();
            return ["success" => true, "sections" => $sections];
        }
        catch(\PDOException $e)
        {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }
}