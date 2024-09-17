<?php

namespace Controllers\ContentManagement;

use Models\ContentManagement\DisplayContentModel;

class DisplayContentController
{
    protected $content;

    public function __construct()
    {
        $this->content = new DisplayContentModel();
    }

    public function getContents()
    {
        return $this->content->getContent();
    }
}