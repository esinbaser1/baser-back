<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0b1e2a1edcacd6de52192509def1812d
{
    public static $prefixLengthsPsr4 = array (
        'U' => 
        array (
            'Utils\\' => 6,
        ),
        'M' => 
        array (
            'Models\\ContentManagement\\' => 25,
            'Models\\' => 7,
        ),
        'L' => 
        array (
            'Lib\\' => 4,
        ),
        'C' => 
        array (
            'Controllers\\ContentManagement\\' => 30,
            'Controllers\\' => 12,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Utils\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App/Utils',
        ),
        'Models\\ContentManagement\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App/Models/ContentManagement',
        ),
        'Models\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App/Models',
        ),
        'Lib\\' => 
        array (
            0 => __DIR__ . '/../..' . '/lib',
        ),
        'Controllers\\ContentManagement\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App/Controllers/ContentManagement',
        ),
        'Controllers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App/Controllers',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0b1e2a1edcacd6de52192509def1812d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0b1e2a1edcacd6de52192509def1812d::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit0b1e2a1edcacd6de52192509def1812d::$classMap;

        }, null, ClassLoader::class);
    }
}
