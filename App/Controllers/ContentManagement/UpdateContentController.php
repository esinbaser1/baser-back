<?php

namespace Controllers\ContentManagement;

use Models\ContentManagement\UpdateContentModel;

class UpdateContentController
{
    protected $data;

    public function __construct()
    {
        $this->data = new UpdateContentModel();
    }

    public function updateContent()
    {
        return $this->data->updateContent();
    }

    public function getContentById($id)
    {
        return $this->data->getContentById($id);
    }
}
