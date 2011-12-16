<?php
/**
* This file is a part of SinyAmazonProductAdvertisingAPIBundle package.
*
* @author Shinichiro Yuki <sinycourage@gmail.com>
*/

$vendorDirectory = realpath(__DIR__ . '/../../../../../../vendor');
$bundleDirectory = $vendorDirectory . '/bundles/Siny/Amazon/ProductAdvertisingAPIBundle';

require_once $vendorDirectory . '/symfony/src/Symfony/Component/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespace('Siny', $bundleDirectory);
$loader->register();

spl_autoload_register(function($class)
{
    if (strpos($class, 'Siny\\Amazon\\ProductAdvertisingAPIBundle\\') === 0) {
        $file = __DIR__ . '/../' . implode('/', array_slice(explode('\\', $class), 3)) . '.php';
        if (file_exists($file) === false) {
            return false;
        }
        require_once $file;
    }
});
