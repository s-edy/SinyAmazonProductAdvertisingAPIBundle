<?php
/**
 * This file is a part of SinyAmazonProductAdvertisingAPIBundle package.
 *
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API\Request;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Requestable;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Exception\RequestException;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation\OperationInterface;

/**
 * This is a class to send batch request to Amazon
 * through the Amazon Product Advertising API.
 *
 * @package SinyAmazonProductAdvertisingAPI
 * @subpackage API
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */
class BatchRequest implements Requestable
{
    private $operations = array();

    /**
     * Constructs from operations
     *
     * @param array $operations - Operations array
     */
    public function __construct(array $operations)
    {
        if (empty($operations)) {
            throw new RequestException("There are no Operation class instances");
        }
        foreach ($operations as $operation) {
            if ($operation instanceof OperationInterface === false) {
                throw new RequestException("Allow a class instance only which implemented 'OperationInterface'");
            }
            if (is_null($operation)) {
                continue;
            }
            $this->operations[] = $operation;
        }
    }

    /**
     * Returns parameters after changing structure of operation parameters to send a batch request
     *
     * @return array
     */
    public function getParameters()
    {
        $operation = $this->extractOperationName();
        $shared    = $this->extractSharedParameters();
        return $this->convertParameter($operation, $shared);
    }

    private function extractOperationName()
    {
        $parameters = $this->operations[0]->toArray();
        return $parameters[OperationInterface::KEY_OPERATION];
    }

    private function extractSharedParameters()
    {
        $parameters = array();
        $shared     = array();
        foreach ($this->operations as $index => $operation) {
            foreach ($operation->toArray() as $key => $value) {
                if (strcasecmp($key, OperationInterface::KEY_OPERATION) === 0) {
                    continue;
                }
                if (isset($parameters[$key]) && $parameters[$key] === $value) {
                    $shared[$key] = $value;
                    unset($parameters[$key]);
                    continue;
                }
                if (isset($shared[$key])) {
                    continue;
                }
                $parameters[$key] = $value;
            }
        }
        return $shared;
    }

    private function convertParameter($operationName, $shared)
    {
        $parameters = array();
        foreach ($this->operations as $index => $operation) {
            foreach ($operation->toArray() as $key => $value) {
                if (strcasecmp($key, OperationInterface::KEY_OPERATION) === 0) {
                    continue;
                }
                if (isset($shared[$key])) {
                    continue;
                }
                $parameters[$operationName . '.' . ($index + 1) . '.' . $key] = $value;
            }
        }
        foreach ($shared as $key => $value) {
            $parameters[$operationName . '.Shared.' . $key] = $value;
        }
        $parameters[OperationInterface::KEY_OPERATION] = $operationName;

        return $parameters;
    }
}
