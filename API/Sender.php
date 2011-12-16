<?php
/**
 * This file is a part of Siny\Amazon\ProductAdvertisingAPIBundle package.
 *
 * (c) Shinichiro Yuki <edy@siny.jp>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Buildable;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Requestable;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Response;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Exception\SenderException;
use \HttpException;

/**
 * This is a class to send HTTP request for the Amazon.
 *
 * @package SinyAmazonProductAdvertisingAPI
 * @subpackage API
 * @author Shinichiro Yuki <edy@siny.jp>
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
            $httpMessage = $this->getBuilder()->build($request)->send();
            return new Response($httpMessage);
        } catch (HttpException $e) {
            throw new SenderException("Sending exception occurred.", 0, $e);
        }
    }
}
