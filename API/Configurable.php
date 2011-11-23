<?php
/**
 * This file is a part of SinyAmazonProductAdvertisingAPIBundle package.
 *
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API;

/**
 * This is a interface of Configurable object.
 *
 * @package SinyAmazonProductAdvertisingAPI
 * @subpackage API
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */
interface Configurable
{
    /**
     * Set parameters from array
     *
     * @param array $parameters
     */
    public function fromArray(array $parameters);

    /**
     * Get all parameters
     *
     * @return array
     */
    public function toArray();
}
