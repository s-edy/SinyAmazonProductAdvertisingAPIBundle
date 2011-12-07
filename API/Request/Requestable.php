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
    const KEY_OPERATION = 'Operation';

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
}
