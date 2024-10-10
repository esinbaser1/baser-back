<?php

namespace Lib;

class Slug
{
    public $string;
    public $slug;

    public function sluguer($string)
    {
        $string = \Normalizer::normalize($string, \Normalizer::FORM_D); 
        $string = preg_replace('/[\p{Mn}]/u', '', $string);
        $slug = strtolower(trim(preg_replace("/[^A-Za-z0-9-]+/", "-", $string)));
        return $slug;
    }
}

// // Test
// $slugger = new Slug();

// $testString = "Page nos réalisations";

// $result = $slugger->sluguer($testString);
// echo $result;

