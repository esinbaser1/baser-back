<?php

namespace Lib;

class Slug
{
    public $string;
    public $slug;

    public function sluguer($string)
    {
        // Normaliser les caractères Unicode en une forme décomposée (sans accents)
        $string = \Normalizer::normalize($string, \Normalizer::FORM_D); // Utilisation de la classe Normalizer

        // Supprimer les accents en gardant uniquement les caractères de base
        $string = preg_replace('/[\p{Mn}]/u', '', $string);

        // Remplacer les caractères non-alphanumériques par des tirets
        $slug = strtolower(trim(preg_replace("/[^A-Za-z0-9-]+/", "-", $string)));

        return $slug;
    }
}

// // Test
// $slugger = new Slug();

// $testString = "Autre";

// $result = $slugger->sluguer($testString);
// echo $result;

