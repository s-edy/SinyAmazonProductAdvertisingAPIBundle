<?php
/**
 * This file is a part of SinyAmazonProductAdvertisingAPIBundle package.
 *
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API\Request;

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
     * Set a parameter key-value pair
     *
     * @param string $key  - Parameter key
     * @param mixed $value - Value
     * @return Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configurable
     */
    public function set($key, $value);

    /**
     * Get a parameter from key
     *
     * @param string $key
     * @return mixed
     * @throws InvalidArgumentException - If the parameter of the specified key does not exist
     */
    public function get($key);

    /**
     * Has a parameter value of key
     *
     * @param string $key
     * @return boolean - Whether the parameter of the specified key is exist
     */
    public function has($key);

    /**
     * Clear all parameters
     *
     * @return Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configurable
     */
    public function clear();

    /**
     * Get all parameters
     *
     * @return array
     */
    public function getAll();
}
