<?php
/**
 * This file is a part of Siny\Amazon\ProductAdvertisingAPIBundle package.
 *
 * (c) Shinichiro Yuki <edy@siny.jp>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation;

/**
 * This is a interface of Operatable object.
 *
 * @package SinyAmazonProductAdvertisingAPI
 * @subpackage API
 * @author Shinichiro Yuki <edy@siny.jp>
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
