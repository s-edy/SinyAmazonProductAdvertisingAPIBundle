<?php
/**
 * This file is a part of SinyAmazonProductAdvertisingAPIBundle package.
 *
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation;

/**
 * This is a interface of Operatable object.
 *
 * @package SinyAmazonProductAdvertisingAPI
 * @subpackage API
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */
interface OperationInterface
{
    // Operation parameter key name
    const KEY_OPERATION = 'Operation';

    /**
     * To the operation parameters for the requsting.
     *
     * @return array
     */
    public function toArray();

    /**
     * Get operation name
     *
     * @return string
     */
    public function getOperationName();

    /**
     * Get parameters
     *
     * @return array
     */
    public function getParameters();
}
