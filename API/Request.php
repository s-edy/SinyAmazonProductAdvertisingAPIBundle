<?php
/**
 * This file is a part of SinyAmazonProductAdvertisingAPIBundle package.
 *
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\AbstractRequest,
    Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation,
    Siny\Amazon\ProductAdvertisingAPIBundle\API\Exception\RequestException,
    Siny\Amazon\ProductAdvertisingAPIBundle\API\Response;

/**
 * This is a class to send HTTP request to Amazon
 * through the Amazon Product Advertising API.
 *
 * @package SinyAmazonProductAdvertisingAPI
 * @subpackage API
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */
class Request extends AbstractRequest
{
    /**
     * An Operation class instance that you want to send request
     *
     * @var Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation
     */
    private $operation;

    /**
     * set Operation class that you want to send request
     *
	 * @param Operation $operation An operation class instance
     */
    public function setOperation(Operation $operation)
    {
        $this->operation = $operation;
    }

    /**
     * get Operation class instance that you want to send request
     *
     * @return \Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * {@inheritdoc}
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\AbstractRequest::send()
     */
    public function send()
    {
        if (is_null($this->getOperation())) {
            throw new RequestException("Operation class instance was not found.");
        }
        return new Response();
    }
}
