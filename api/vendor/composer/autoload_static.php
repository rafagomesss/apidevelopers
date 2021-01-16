<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3bca2b04d6a43d09f91448155cf8a3a7
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'System\\' => 7,
        ),
        'A' => 
        array (
            'Api\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'System\\' => 
        array (
            0 => __DIR__ . '/..' . '/System',
        ),
        'Api\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3bca2b04d6a43d09f91448155cf8a3a7::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3bca2b04d6a43d09f91448155cf8a3a7::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
