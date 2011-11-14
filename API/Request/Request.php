<?php
/**
 * This file is a part of SinyAmazonProductAdvertisingAPIBundle package.
 *
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API\Request;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Requestable,
    Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation;

/**
 * This is a class to send HTTP request to Amazon
 * through the Amazon Product Advertising API.
 *
 * @package SinyAmazonProductAdvertisingAPI
 * @subpackage API
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */
class Request implements Requestable
{
    /**
     * An Operation class instance which you want to send request
     *
     * @var Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation
     */
    private $operation;

    /**
     * This is a method which will use when request send.
     * default value is "GET".
     *
     * @var string
     */
    private $method = self::METHOD_GET;

    /**
     * {@inheritdoc}
     */
    public function __construct(Operation $operation)
    {
        $this->setOperation($operation);
    }

    /**
     * {@inheritdoc}
     */
    public function setOperation(Operation $operation)
    {
        $this->operation = $operation;
    }

    /**
     * {@inheritdoc}
     */
    public function setGETMethod()
    {
        $this->method = self::METHOD_GET;
    }

    /**
     * {@inheritdoc}
     */
    public function setPOSTMethod()
    {
        $this->method = self::METHOD_POST;
    }

    /**
     * {@inheritdoc}
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * {@inheritdoc}
     */
    public function isGETMethod()
    {
        return $this->method === self::METHOD_GET;
    }

    /**
     * {@inheritdoc}
     */
    public function isPOSTMethod()
    {
        return $this->method === self::METHOD_POST;
    }
}
