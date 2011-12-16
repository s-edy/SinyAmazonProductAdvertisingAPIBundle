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

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configurable;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Requestable;

/**
 * This is an interface of Generatable object.
 *
 * @package SinyAmazonProductAdvertisingAPI
 * @subpackage API
 * @author Shinichiro Yuki <edy@siny.jp>
 */
interface Generatable
{
    /**
     * Generates parameters from configuration, and request.
     *
     * @param Configurable $configuration - A configuration class instance
     * @param Requestable $request        - A requestable class instance
     * @return array - Configuration parameters
     */
    public function generateParameters(Configurable $configuration, Requestable $request);
}
