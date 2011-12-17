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
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Exception\RequestException;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation\OperationInterface;

/**
 * This is a class to send BatchRequest to Amazon
 * through the Amazon Product Advertising API.
 *
 * @package SinyAmazonProductAdvertisingAPI
 * @subpackage API
 * @author Shinichiro Yuki <edy@siny.jp>
 */
class BatchRequest implements Requestable
{
    /**
     * The operations to send request
     *
     * @var array
     */
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
        $operation  = $this->extractOperationName();
        return array_merge(
            array('Operation' => $operation),
            $this->convertParameter($operation, $this->extractSharedParameters()));
    }

    /**
     * Extract an operation name from operations
     *
     * @return string
     */
    private function extractOperationName()
    {
        return $this->operations[0]->getOperationName();
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
            $parameters[] = $operation->getParameters();
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
            foreach ($operation->getParameters() as $key => $value) {
                if (isset($shared[$key]) === false) {
                    $parameters[$operationName . '.' . ($index + 1) . '.' . $key] = $value;
                }
            }
        }
        foreach ($shared as $key => $value) {
            $parameters[$operationName . '.Shared.' . $key] = $value;
        }
        return $parameters;
    }
}
