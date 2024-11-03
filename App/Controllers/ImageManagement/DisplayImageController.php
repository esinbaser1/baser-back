<?php

namespace Controllers\ImageManagement;

use Models\ImageManagement\DisplayImageModel;

class DisplayImageController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DisplayImageModel();
    }

    public function getImages()
    {
        try 
        {
            $images = $this->model->getImage();
            return ["success" => true, "image" => $images];
        } 
        catch (\Exception $e) 
        {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }
}
