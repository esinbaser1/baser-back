<?php

namespace Controllers\ContentManagement;

use Models\ContentManagement\DisplayContentModel;

class DisplayContentController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DisplayContentModel();
    }

    public function getContents()
    {
        try 
        {
            $content = $this->model->getContent();
            return ["success" => true, "content" => $content];
        }
        catch (\Exception $e) 
        {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }
}
