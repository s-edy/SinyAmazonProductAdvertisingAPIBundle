<?php
/**
 * This file is a part of Siny\Amazon\ProductAdvertisingAPIBundle package.
 *
 * (c) Shinichiro Yuki <edy@siny.jp>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API\Request;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Requestable;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation\OperationInterface;

/**
 * This is a class to send HTTP request to Amazon
 * through the Amazon Product Advertising API.
 *
 * @package SinyAmazonProductAdvertisingAPI
 * @subpackage API
 * @author Shinichiro Yuki <edy@siny.jp>
 */
class Request implements Requestable
{
    /**
     * An Operation class instance which you want to send request
     *
     * @var Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation\OperationInterface
     */
    private $operation;

    /**
     * Set an Operation class when the instance construct
     *
     * @param OperationInterface $operation
     */
    public function __construct(OperationInterface $operation)
    {
        $this->setOperation($operation);
    }

    /**
     * Set an Operation class instance which you want to send request
     *
     * @param OperationInterface $operation An operation class instance
     */
    public function setOperation(OperationInterface $operation)
    {
        $this->operation = $operation;
    }

    /**
     * Get an Operation class instance which you want to send request
     *
     * @return A class instance which implemented \Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation\OperationInterface
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
        return $this->getOperation()->toArray();
    }
}
