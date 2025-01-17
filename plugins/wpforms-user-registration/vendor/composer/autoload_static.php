<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit15482672a3c7f625efa921e05564e22a
{
    public static $files = array (
        'a083fc3b8575c3b466f107a9a8ea023a' => __DIR__ . '/../..' . '/includes/deprecated.php',
    );

    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'WPFormsUserRegistration\\' => 24,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'WPFormsUserRegistration\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit15482672a3c7f625efa921e05564e22a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit15482672a3c7f625efa921e05564e22a::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit15482672a3c7f625efa921e05564e22a::$classMap;

        }, null, ClassLoader::class);
    }
}
