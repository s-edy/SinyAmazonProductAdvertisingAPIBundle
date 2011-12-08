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
        $this->addParameters($parameters);
    }

    /**
     * {@inheritdoc}
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation\OperationInterface::addParameters()
     */
    public function addParameters(array $parameters)
    {
        foreach ($parameters as $key => $value) {
            if ($key === self::KEY_OPERATION) {
                continue;
            }
            $this->setParameter($key, $value);
        }
    }

    /**
     * {@inheritdoc}
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation\OperationInterface::setParameter()
     */
    protected function setParameter($key, $value)
    {
        $this->parameters[$key] = $value;
    }

    /**
     * {@inheritdoc}
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation\OperationInterface::getParameter()
     */
    protected function getParameter($key)
    {
        if ($this->hasParameter($key) === false) {
            throw new OperationException(sprintf("The parameter of specified key was not found. key=[%s]", $key));
        }
        return $this->parameters[$key];
    }

    /**
     * {@inheritdoc}
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation\OperationInterface::hasParameter()
     */
    protected function hasParameter($key)
    {
        return (isset($this->parameters[$key]));
    }

    /**
     * {@inheritdoc}
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation\OperationInterface::getParameters()
     */
    protected function getParameters()
    {
        return $this->parameters;
    }
}
