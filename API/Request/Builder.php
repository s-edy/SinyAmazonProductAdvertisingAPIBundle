<?php
/**
 * This file is a part of SinyAmazonProductAdvertisingAPIBundle package.
 *
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API\Request;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Buildable;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configurable;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Generatable;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Generator;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Requestable;
use \HttpRequest;

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
     * Configurable class instance
     *
     * @var Configurable
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configurable
     */
    private $configuration;

    /**
    * Generator class instance
    *
    * @var Generatable
    * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Generatable
    */
    private $generator;

    /**
     * {@inheritdoc}
     *
     * @param Configurable $configuration
     */
    public function __construct(Configurable $configuration)
    {
        $this->setConfiguration($configuration);
        $this->setGenerator(new Generator());
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
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Request.Buildable::setGenerator()
     */
    public function setGenerator(Generatable $generator)
    {
        $this->generator = $generator;

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
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Request.Buildable::getGenerator()
     */
    public function getGenerator()
    {
        return $this->generator;
    }

    /**
     * {@inheritdoc}
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Request.Buildable::build()
     */
    public function build(Requestable $request)
    {
        $configuration = $this->getConfiguration();
        $httpRequest = new HttpRequest();
        $httpRequest->setUrl($this->buildUrl());
        $httpRequest->setMethod($this->buildRequestMethod());
        $httpRequest->addQueryData($this->getConfiguration()->toRequiredQueryData());
        $httpRequest->addQueryData($request->getParameters());
        return $httpRequest;
    }

    /**
     * Build an URL which is used to send a request
     *
     * @return string
     */
    private function buildUrl()
    {
        $c = $this->getConfiguration();
        return sprintf("http%s://%s%s", $c->isSecure() ? 's' : '', $c->getEndPoint(), $c->getRequestURI());
    }

    /**
     * Build a method type constant
     *
     * @return integer
     */
    private function buildRequestMethod()
    {
        if ($this->getConfiguration()->isMethodPOST()) {
            return HttpRequest::METH_POST;
        } else {
            return HttpRequest::METH_GET;
        }
    }
}
