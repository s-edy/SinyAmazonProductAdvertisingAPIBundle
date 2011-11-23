<?php
/**
 * This file is a part of SinyAmazonProductAdvertisingAPIBundle package.
 *
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API\Request;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Buildable;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configurable;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Requestable;

/**
 * This is a class that build a HttpRequest by the Request.
 *
 * @package SinyAmazonProductAdvertisingAPI
 * @subpackage API
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */
class Builder implements Buildable
{
    /**
     * Configuration class instance
     *
     * @var Configuration
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configurable
     */
    private $configuration;

    /**
     * {@inheritdoc}
     *
     * @param Configurable $configuration
     */
    public function __construct(Configurable $configuration)
    {
        $this->setConfiguration($configuration);
    }

    /**
     * {@inheritdoc}
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Request.Buildable::setConfiguration()
     */
    public function setConfiguration(Configurable $configuration)
    {
        $this->configuration = $configuration;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Request.Buildable::getConfiguration()
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * {@inheritdoc}
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Request.Buildable::build()
     */
    public function build(Requestable $request)
    {
        return new \HttpRequest();
    }
}
