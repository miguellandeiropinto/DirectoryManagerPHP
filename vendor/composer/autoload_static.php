<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit93df978608f3d323d7163e31247b50d5
{
    public static $files = array(
        '2444d0cc665fd7aa502cdfdccf4e2b6e' => __DIR__ . '/../..' . '/includes/__functions.php',
    );

    public static $prefixLengthsPsr4 = array(
        'D' =>
            array(
                'DirectoryManager\\' => 17,
            ),
    );

    public static $prefixDirsPsr4 = array(
        'DirectoryManager\\' =>
            array(
                0 => __DIR__ . '/../..' . '/includes',
            ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit93df978608f3d323d7163e31247b50d5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit93df978608f3d323d7163e31247b50d5::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
