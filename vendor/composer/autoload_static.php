<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2615aac67cdb328d2f3733aaad432917
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'CranleighSchool\\Policies\\' => 25,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'CranleighSchool\\Policies\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2615aac67cdb328d2f3733aaad432917::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2615aac67cdb328d2f3733aaad432917::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
