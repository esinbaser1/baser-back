<?php

namespace Controllers\ContentManagement;

use Models\ContentManagement\AddContentModel;

class AddContentController
{
    protected $content;

    public function __construct()
    {
        $this->content = new AddContentModel();
    }

    public function addContents()
    {
        return $this->content->addContent();
    }
}