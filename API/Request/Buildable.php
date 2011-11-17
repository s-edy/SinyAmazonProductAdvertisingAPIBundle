<?php
/**
 * This file is a part of SinyAmazonProductAdvertisingAPIBundle package.
 *
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API\Request;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Requestable;

/**
 * This is a interface of Buildable object.
 *
 * @package SinyAmazonProductAdvertisingAPI
 * @subpackage API
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */
interface Buildable
{
    /**
     * build a HttpRequest class instance from Requestable object.
     *
     * @param Requestable $request
     * @return HttpRequest
     * @throws Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Exception\BuildException
     */
    public function build(Requestable $request);
}
