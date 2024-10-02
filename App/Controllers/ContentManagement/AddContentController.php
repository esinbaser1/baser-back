<?php

namespace Controllers\ContentManagement;

use Models\ContentManagement\AddContentModel;

class AddContentController
{
    protected $data;

    public function __construct()
    {
        $this->data = new AddContentModel();
    }

    public function addContents()
    {
        return $this->data->addContent();
    }
}