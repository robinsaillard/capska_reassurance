<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9c5fdc504ac7fd81dc16bb19c203eadf
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'Capska\\CapskaReassurance\\' => 25,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Capska\\CapskaReassurance\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9c5fdc504ac7fd81dc16bb19c203eadf::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9c5fdc504ac7fd81dc16bb19c203eadf::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
