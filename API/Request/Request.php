<?php
/**
 * This file is a part of SinyAmazonProductAdvertisingAPIBundle package.
 *
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API\Request;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Requestable;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation;

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
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * {@inheritdoc}
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Request.Requestable::getParameters()
     */
    public function getParameters()
    {
        return array_merge(
            array(self::KEY_OPERATION => $this->getOperation()->getOperationName()),
            $this->getOperation()->getParameters());
    }
}
