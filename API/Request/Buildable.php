<?php
/**
 * This file is a part of SinyAmazonProductAdvertisingAPIBundle package.
 *
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API\Request;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Requestable;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configurable;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Generatable;

/**
 * This is a interface of Buildable object.
 *
 * @package SinyAmazonProductAdvertisingAPI
 * @subpackage API
 * @author Shinichiro Yuki <sinycourage@gmail.com>
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
     * build a HttpRequest class instance from Requestable object.
     *
     * @param Requestable $request
     * @return HttpRequest
     * @throws Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Exception\BuildException
     */
    public function build(Requestable $request);
}
