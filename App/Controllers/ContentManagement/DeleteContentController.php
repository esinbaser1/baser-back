<?php

namespace Controllers\ContentManagement;

use Models\ContentManagement\DeleteContentModel;

class DeleteContentController
{
    protected $data;

    public function __construct()
    {
        $this->data = new DeleteContentModel();
    }

    public function deleteContents()
    {
        return $this->data->deleteContent();
    }
}
