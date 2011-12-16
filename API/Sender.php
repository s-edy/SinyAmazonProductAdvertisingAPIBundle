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
     * A building request class instance
     *
     * @var Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Buildable
     */
    private $builder;

    /**
     * Set a Buildable class instance when constructing
     *
     * @param Buildable $buildable - A Buildable class instance
     */
    public function __construct(Buildable $builder)
    {
        $this->setBuilder($builder);
    }

    /**
     * Set a Buildable class instance
     *
     * @param Buildable $buildable - A Buildable class instance
     * @return Siny\Amazon\ProductAdvertisingAPIBundle\API\Sender
     */
    public function setBuilder(Buildable $builder)
    {
        $this->builder = $builder;

        return $this;
    }

    /**
     * Get a Buildable class instance
     *
     * @return \Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Buildable
     */
    public function getBuilder()
    {
        return $this->builder;
    }

    /**
     * Send a HTTP request
     *
     * @param Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Requestable
     * @return Siny\Amazon\ProductAdvertisingAPIBundle\API\Response
     */
    public function send(Requestable $request)
    {
        try {
            return new Response($this->getBuilder()->build($request)->send());
        } catch (HttpException $e) {
            throw new SenderException("Sending exception occurred.", 0, $e);
        }
    }
}
