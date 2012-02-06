<?php
/**
* This file is a part of Siny\Amazon\ProductAdvertisingAPIBundle package.
*
* (c) Shinichiro Yuki <edy@siny.jp>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

$vendorDirectory = realpath(__DIR__ . '/../vendor');

require_once $vendorDirectory . '/symfony/src/Symfony/Component/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespace('Symfony', array($vendorDirectory.'/symfony/src', $vendorDirectory.'/bundles'));
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
