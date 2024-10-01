<?php

namespace Controllers\ContentManagement;

use Models\ContentManagement\DisplayContentModel;

class DisplayContentController
{
    protected $data;

    public function __construct()
    {
        $this->data = new DisplayContentModel();
    }

    public function getContents()
    {
        return $this->data->getContent();
    }
}