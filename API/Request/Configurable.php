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
     * set parameter
     *
     * @param string $key  - Parameter key
     * @param mixed $value - Value
     */
    public function set($key, $value);

    /**
     * get parameter
     *
     * @param string $key
     * @return mixed
     * @throws InvalidArgumentException - If the parameter of the specified key does not exist
     */
    public function get($key);

    /**
     * has parameter
     *
     * @param string $key
     * @return boolean - Whether the parameter of the specified key is exist
     */
    public function has($key);

    /**
     * get all parameters
     *
     * @return array
     */
    public function getAll();
}
