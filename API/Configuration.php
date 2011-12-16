<?php
/**
 * This file is a part of Siny\Amazon\ProductAdvertisingAPIBundle package.
 *
 * (c) Shinichiro Yuki <edy@siny.jp>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Configurable;

/**
 * This is a abstract class that configure the Amazon API
 *
 * @package SinyAmazonProductAdvertisingAPI
 * @subpackage API
 * @author Shinichiro Yuki <edy@siny.jp>
 */
abstract class Configuration implements Configurable
{
    /**
     * Configuration parameters
     * @var array
     */
    private $parameters = array();

    /**
     * {@inheritdoc}
     */
    public function fromArray(array $parameters)
    {
        foreach ($parameters as $key => $value) {
            $this->set($key, $value);
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return $this->parameters;
    }

    /**
     * Set a parameter key-value pair
     *
     * @param string $key  - Parameter key
     * @param mixed $value - Value
     * @return Siny\Amazon\ProductAdvertisingAPIBundle\API\Configuration
     */
    protected function set($key, $value)
    {
        $this->parameters[$key] = $value;

        return $this;
    }

    /**
     * Get a parameter from key
     *
     * @param string $key
     * @return mixed
     * @throws InvalidArgumentException - If the parameter of the specified key does not exist
     */
    protected function get($key)
    {
        if ($this->has($key) === false) {
            throw new \InvalidArgumentException(sprintf("The value of speficied key index was not found. key=[%s]", $key));
        }
        return $this->parameters[$key];
    }

    /**
     * Has a parameter value of key
     *
     * @param string $key
     * @return boolean - Whether the parameter of the specified key is exist
     */
    protected function has($key)
    {
        return isset($this->parameters[$key]);
    }
}
