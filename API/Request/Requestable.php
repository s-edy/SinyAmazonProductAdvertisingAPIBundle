<?php
/**
 * This file is a part of SinyAmazonProductAdvertisingAPIBundle package.
 *
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API\Request;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation;

/**
 * This is a interface of requestable object.
 *
 * @package SinyAmazonProductAdvertisingAPI
 * @subpackage API
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */
interface Requestable
{
    const METHOD_GET  = 'GET';
    const METHOD_POST = 'POST';

    /**
     * set an Operation class when the instance construct
     *
     * @param Operation $operation
     */
    public function __construct(Operation $operation);

    /**
     * set an Operation class instance which you want to send request
     *
	 * @param Operation $operation An operation class instance
     */
    public function setOperation(Operation $operation);

    /**
     * set which method use
     * @param string $method
     * @throws Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Exception\RequestException
     */
    public function setMethod($method);

    /**
     * get an Operation class instance which you want to send request
     *
     * @return \Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation
     */
    public function getOperation();

    /**
     * get which method use
     *
     * @return string
     */
    public function getMethod();
}
