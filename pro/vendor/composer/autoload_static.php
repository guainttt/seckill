<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd63818ab77690c49ad8dcd34389c5268
{
    public static $files = array (
        '253c157292f75eb38082b5acb06f3f01' => __DIR__ . '/..' . '/nikic/fast-route/src/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'FastRoute\\' => 10,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'FastRoute\\' => 
        array (
            0 => __DIR__ . '/..' . '/nikic/fast-route/src',
        ),
        'App\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInitd63818ab77690c49ad8dcd34389c5268::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd63818ab77690c49ad8dcd34389c5268::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitd63818ab77690c49ad8dcd34389c5268::$classMap;

        }, null, ClassLoader::class);
    }
}