<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitdaa0c5e517df7144db3df49fd9ca6a41
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInitdaa0c5e517df7144db3df49fd9ca6a41', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitdaa0c5e517df7144db3df49fd9ca6a41', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitdaa0c5e517df7144db3df49fd9ca6a41::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}