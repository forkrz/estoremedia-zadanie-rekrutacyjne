<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit82d7e41db9c240409737a63d75df0fc2
{
    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit82d7e41db9c240409737a63d75df0fc2::$classMap;

        }, null, ClassLoader::class);
    }
}
