<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit605c463976a79d9e58a350d7dea2105f
{
    public static $files = array (
        '04c6c5c2f7095ccf6c481d3e53e1776f' => __DIR__ . '/..' . '/mustangostang/spyc/Spyc.php',
    );

    public static $prefixLengthsPsr4 = array (
        'J' => 
        array (
            'Jenssegers\\Agent\\' => 17,
            'Jaybizzle\\CrawlerDetect\\' => 24,
        ),
        'D' => 
        array (
            'DeviceDetector\\' => 15,
        ),
        'C' => 
        array (
            'Composer\\Installers\\' => 20,
            'CloudVerve\\Detect_Remote_Device\\' => 32,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Jenssegers\\Agent\\' => 
        array (
            0 => __DIR__ . '/..' . '/jenssegers/agent/src',
        ),
        'Jaybizzle\\CrawlerDetect\\' => 
        array (
            0 => __DIR__ . '/..' . '/jaybizzle/crawler-detect/src',
        ),
        'DeviceDetector\\' => 
        array (
            0 => __DIR__ . '/..' . '/piwik/device-detector',
        ),
        'Composer\\Installers\\' => 
        array (
            0 => __DIR__ . '/..' . '/composer/installers/src/Composer/Installers',
        ),
        'CloudVerve\\Detect_Remote_Device\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $prefixesPsr0 = array (
        'D' => 
        array (
            'Detection' => 
            array (
                0 => __DIR__ . '/..' . '/mobiledetect/mobiledetectlib/namespaced',
            ),
        ),
    );

    public static $classMap = array (
        'Mobile_Detect' => __DIR__ . '/..' . '/mobiledetect/mobiledetectlib/Mobile_Detect.php',
        'underDEV_Requirements' => __DIR__ . '/..' . '/underdev/requirements/underDEV_Requirements.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit605c463976a79d9e58a350d7dea2105f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit605c463976a79d9e58a350d7dea2105f::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit605c463976a79d9e58a350d7dea2105f::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit605c463976a79d9e58a350d7dea2105f::$classMap;

        }, null, ClassLoader::class);
    }
}
