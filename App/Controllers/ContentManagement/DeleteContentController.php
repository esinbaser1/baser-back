<?php

namespace Controllers\ContentManagement;

use Models\ContentManagement\DeleteContentModel;

class DeleteContentController
{
    protected $deleteContentModel;

    public function __construct()
    {
        $this->deleteContentModel = new DeleteContentModel();
    }

    public function deleteContents()
    {
        return $this->deleteContentModel->deleteContent();
    }
}
