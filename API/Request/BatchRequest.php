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
            if ($operation instanceof OperationInterface) {
                $this->operations[] = $operation;
            } else {
                throw new RequestException("Allow a class instance only which implemented 'OperationInterface'");
            }
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

    /**
     * Extract an operation name from operations
     *
     * @return string
     */
    private function extractOperationName()
    {
        $parameters = $this->operations[0]->toArray();
        return $parameters[OperationInterface::KEY_OPERATION];
    }

    /**
     * Extract some shared parameters from operations
     *
     * @return array
     */
    private function extractSharedParameters()
    {
        $parameters = array();
        foreach ($this->operations as $operation) {
            $operationParameters = array();
            foreach ($operation->toArray() as $key => $value) {
                if (strcasecmp($key, OperationInterface::KEY_OPERATION) === 0) {
                    continue;
                }
                $operationParameters[$key] = $value;
            }
            $parameters[] =$operationParameters;
        }
        return call_user_func_array("array_intersect_assoc", $parameters);
    }

    /**
     * Convert operation parameters with the Operation name
     * and shared parameters.
     *
     * @param string $operationName - Operation name
     * @param array $shared - Shared parameters array
     */
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
