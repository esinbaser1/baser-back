<?php

namespace Controllers;

use Models\DisplaySectionModel;

class DisplaySectionController
{
    protected $section;

    public function __construct()
    {
        $this->section = new DisplaySectionModel();
    }

    public function getSections()
    {
        return $this->section->getSection();
    }
}