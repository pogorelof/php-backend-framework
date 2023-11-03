<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd7b17c1e7ed92672be8aad9e493e2962
{
    public static $prefixLengthsPsr4 = array (
        'w' => 
        array (
            'watch\\' => 6,
        ),
        'a' => 
        array (
            'app\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'watch\\' => 
        array (
            0 => __DIR__ . '/..' . '/watch/core',
        ),
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd7b17c1e7ed92672be8aad9e493e2962::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd7b17c1e7ed92672be8aad9e493e2962::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitd7b17c1e7ed92672be8aad9e493e2962::$classMap;

        }, null, ClassLoader::class);
    }
}
