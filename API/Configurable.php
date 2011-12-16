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

/**
 * This is an interface of Configurable object.
 *
 * @package SinyAmazonProductAdvertisingAPI
 * @subpackage API
 * @author Shinichiro Yuki <edy@siny.jp>
 */
interface Configurable
{
    /**
     * Set parameters from array
     *
     * @param array $parameters - a Parameters array
     */
    public function fromArray(array $parameters);

    /**
     * Get all parameters
     *
     * @return array - Configuration parameters
     */
    public function toArray();
}
