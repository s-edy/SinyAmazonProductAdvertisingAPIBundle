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
     * set using GET method
     */
    public function setGETMethod();

    /**
     * set using POST method
     */
    public function setPOSTMethod();

    /**
     * get an Operation class instance which you want to send request
     *
     * @return \Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation
     */
    public function getOperation();

    /**
     * Get a parameter array
     *
     * @return array
     */
    public function getParameters();

    /**
     * is GET method
     *
     * @return boolean whether using GET method
     */
    public function isGETMethod();

    /**
     * is POST method
     *
     * @return boolean whether using POST method
     */
    public function isPOSTMethod();
}
