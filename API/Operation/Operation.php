<?php
/**
 * This file is a part of SinyAmazonProductAdvertisingAPIBundle package.
 *
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation\OperationInterface;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Requestable;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation\Exception\OperationException;

/**
 * This is a class to set operation and parameters
 * for the Amazon Product Advertising API.
 *
 * @package SinyAmazonProductAdvertisingAPI
 * @subpackage API
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */
abstract class Operation implements OperationInterface
{
    /**
     * Operation parameters
     *
     * @var array
     */
    private $parameters = array();

    /**
     * Add parameters when constructing.
     *
     * @param array $parameters these are parameters.
     */
    public function __construct(array $parameters = array())
    {
        $this->fromArray($parameters);
    }

    /**
     * {@inheritdoc}
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation\OperationInterface::addParameters()
     */
    public function fromArray(array $parameters)
    {
        foreach ($parameters as $key => $value) {
            if (strcasecmp($key, self::KEY_OPERATION) !== 0) {
                $this->set($key, $value);
            }
        }
    }

    /**
     * {@inheritdoc}
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation\OperationInterface::setParameter()
     */
    protected function set($key, $value)
    {
        $this->parameters[$key] = $value;
    }

    /**
     * {@inheritdoc}
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation\OperationInterface::getParameter()
     */
    protected function get($key)
    {
        if ($this->has($key) === false) {
            throw new OperationException(sprintf("The parameter of specified key was not found. key=[%s]", $key));
        }
        return $this->parameters[$key];
    }

    /**
     * {@inheritdoc}
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation\OperationInterface::hasParameter()
     */
    protected function has($key)
    {
        return (isset($this->parameters[$key]));
    }

    /**
     * {@inheritdoc}
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation\OperationInterface::getParameters()
     */
    public function toArray()
    {
        return $this->parameters;
    }

    /**
     * {@inheritdoc}
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation.OperationInterface::getOperationName()
     */
    public function getOperationName()
    {
        return $this->get(self::KEY_OPERATION);
    }

    /**
     * {@inheritdoc}
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation.OperationInterface::getParameters()
     */
    public function getParameters()
    {
        $parameters = array();
        foreach ($this->toArray() as $key => $value) {
            if (strcasecmp($key, self::KEY_OPERATION) !== 0) {
                $parameters[$key] = $value;
            }
        }
        return $parameters;
    }
}
