<?php
/**
 * This file is a part of SinyAmazonProductAdvertisingAPIBundle package.
 *
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Buildable;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Requestable;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Response;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Exception\SenderException;

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
        try {
            return $this->getBuilder()->build($request)->send();
        } catch (\Exception $e) {
            throw new SenderException("Sending exception occurred.", 0, $e);
        }
    }
}
