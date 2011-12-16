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
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configurable;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Generatable;

/**
 * This is an interface of Buildable object.
 *
 * @package SinyAmazonProductAdvertisingAPI
 * @subpackage API
 * @author Shinichiro Yuki <edy@siny.jp>
 */
interface Buildable
{
    /**
     * Require a configuration
     *
     * @param Configurable $configuration
     */
    public function __construct(Configurable $configuration);

    /**
     * Set a configurable object
     *
     * @param Configurable $configuration
     * @return Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Buildable
     */
    public function setConfiguration(Configurable $configuration);

    /**
    * Set a generatable object
    *
    * @param Generatable $generator
    * @return Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Buildable
    */
    public function setGenerator(Generatable $generator);

    /**
     * Get a configurable object
     *
     * @return Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configurable
     */
    public function getConfiguration();

    /**
     * Get a generatable object
     *
     * @return Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Generatable
     */
    public function getGenerator();

    /**
     * Build a HttpRequest class instance from Requestable object.
     *
     * @param Requestable $request
     * @return HttpRequest
     * @throws Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Exception\BuildException
     */
    public function build(Requestable $request);
}
