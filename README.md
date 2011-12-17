Amazon Product Advertising API Bundle
=====================================

This is a client of the Amazon Product Advertising API to use in Symfony2 as a Bundle.

Installation
-------------

### 1) Add the following lines in your deps file

```
[SinyAmazonProductAdvertisingAPIBundle]
    git=git://github.com/s-edy/SinyAmazonProductAdvertisingAPIBundle.git
    target=bundles/Siny/Amazon/ProductAdvertisingAPIBundle
```

### 2) Run venders scpript

```
$ php bin/venders install
```

### 3) Add the Siny namespace to your autoloader

```php
<?php
// app/autoload.php

$loader->registerNamespaces(array(
	// ...
	'Siny'             => __DIR__.'/../vendor/bundles',
));
```

### 4) Add this bundle to your application's kernel

```php
<?php
// app/AppKernel.php

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
        	// ...
            new Siny\Amazon\ProductAdvertisingAPIBundle\SinyAmazonProductAdvertisingAPIBundle(),
        );
```

How to use
----------

Please see `Test/ExampleTest.php`.
