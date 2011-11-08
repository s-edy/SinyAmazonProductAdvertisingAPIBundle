<?php
/**
 * This file is a part of SinyAmazonProductAdvertisingAPIBundle package.
 *
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation\Exception\OperationException;

/**
 * This is a class to set operation and parameters
 * for the Amazon Product Advertising API.
 *
 * @package SinyAmazonProductAdvertisingAPI
 * @subpackage API
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */
abstract class Operation
{
    /**
     * @var string operation parameter
     */
    private $operation;

    /**
     * @var array request parameters
     */
    private $parameters = array();

    /**
     * set operation name and parameters.
     *
     * @param string $operation this is operation name.
     * @param array $parameters these are parameters.
     */
    public function __construct($operation, array $parameters = array())
    {
        $this->setOperation($operation);
        if (count($parameters) > 0) {
            $this->addParameters($parameters);
        }
    }

    /**
     * set operation name
     *
     * @param string $operation
     */
    protected function setOperation($operation)
    {
        $this->operation = $operation;
    }

    /**
     * set parameters. all parameters will be replaced.
     *
     * @param array $parameters
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * set key-value parameter
     *
     * @param string $key parameter name
     * @param mixed $value parameter value
     */
    public function setParameter($key, $value)
    {
        $this->parameters[$key] = $value;
    }

    /**
     * add parameter.
     *
     * If there are parameters of the same key,
	 * that are replaced by new parameters.
     *
     * @param array $parameters
     */
    public function addParameters(array $parameters)
    {
        $this->setParameters(array_merge($this->parameters, $parameters));
    }

    /**
     * get Operation name.
     *
     * @return string
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * get all parameters
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * get parameter of specified key.
     *
     * @param string $key a parameter key name that you want to get.
     * @throws OperationException occur if the parameter does not exist
     * @return mixed - parameter of specified key
     */
    public function getParameter($key)
    {
        if (isset($this->parameters[$key]) === false) {
            throw new OperationException(sprintf(
            	"'%s' parameter was not found", $key));
        }
        return $this->parameters[$key];
    }
}
