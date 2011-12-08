<?php
/**
 * This file is a part of SinyAmazonProductAdvertisingAPIBundle package.
 *
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API\Request;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation\OperationInterface;

/**
 * This is a interface of requestable object.
 *
 * @package SinyAmazonProductAdvertisingAPI
 * @subpackage API
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */
interface Requestable
{
    /**
     * set an Operation class when the instance construct
     *
     * @param OperationInterface $operation
     */
    public function __construct(OperationInterface $operation);

    /**
     * set an Operation class instance which you want to send request
     *
	 * @param OperationInterface $operation An operation class instance
     */
    public function setOperation(OperationInterface $operation);

    /**
     * get an Operation class instance which you want to send request
     *
     * @return A class instance which implemented \Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation\OperationInterface
     */
    public function getOperation();

    /**
     * Get a parameter array
     *
     * @return array
     */
    public function getParameters();
}
