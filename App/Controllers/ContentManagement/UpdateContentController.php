<?php

namespace Controllers\ContentManagement;

use Models\ContentManagement\UpdateContentModel;

class UpdateContentController
{
    protected $updateContent;

    public function __construct()
    {
        $this->updateContent = new UpdateContentModel();
    }

    public function updateContent()
    {
        return $this->updateContent->updateContent();
    }

    public function getContentById($id)
    {
        return $this->updateContent->getContentById($id);
    }
}
