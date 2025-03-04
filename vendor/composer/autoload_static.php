<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3ba1cacb84ad7958de0d2312e37a5d74
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3ba1cacb84ad7958de0d2312e37a5d74::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3ba1cacb84ad7958de0d2312e37a5d74::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit3ba1cacb84ad7958de0d2312e37a5d74::$classMap;

        }, null, ClassLoader::class);
    }
}
