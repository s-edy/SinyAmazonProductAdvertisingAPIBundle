<?php
/**
 * This file is a part of SinyAmazonProductAdvertisingAPIBundle package.
 *
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Buildable,
    Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Requestable,
    Siny\Amazon\ProductAdvertisingAPIBundle\API\Response;

/**
 * This is a class to send HTTP request for the Amazon.
 *
 * @package SinyAmazonProductAdvertisingAPI
 * @subpackage API
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */
class Sender
{
    /**
     * a building request class instance
     *
     * @var Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Buildable
     */
    private $builder;

    /**
     * set a Buildable class instance when this is constructed.
     *
     * @param Buildable $buildable
     */
    public function __construct(Buildable $builder)
    {
        $this->setBuilder($builder);
    }

    /**
     * set a class instance which implement a Buildable insterface.
     *
     * @param Buildable $buildable
     * @return \Siny\Amazon\ProductAdvertisingAPIBundle\API\Sender
     */
    public function setBuilder(Buildable $builder)
    {
        $this->builder = $builder;

        return $this;
    }

    /**
     * get a class instance which implement a Buildable interface.
     *
     * @return \Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Buildable
     */
    public function getBuilder()
    {
        return $this->builder;
    }

    /**
     * send a HTTP request
     *
     * @param \Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Requestable
     * @return \Siny\Amazon\ProductAdvertisingAPIBundle\API\Response
     */
    public function send(Requestable $request)
    {
        return $this->getBuilder()->build($request)->send();
    }
}
