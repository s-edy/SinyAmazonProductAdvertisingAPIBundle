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
        $configurations = $this->getConfiguration()->toArray();

        $httpRequest = new HttpRequest();
        $httpRequest->setUrl(sprintf(
        	'%s://%s%s',
            $configurations[Configurable::KEY_IS_SECURE] ? 'https' : 'http',
            $configurations[Configurable::KEY_ENDPOINT],
            $configurations[Configurable::KEY_REQUEST_URI]
        ));
        if ($configurations[Configurable::KEY_METHOD] === Configurable::METHOD_POST) {
            $httpRequest->setMethod(HttpRequest::METH_POST);
        }
        $httpRequest->addQueryData(array(
            Configurable::KEY_SERVICE           => $configurations[Configurable::KEY_SERVICE],
            Configurable::KEY_VERSION           => $configurations[Configurable::KEY_VERSION],
            Configurable::KEY_AWS_ACCESS_KEY_ID => $configurations[Configurable::KEY_AWS_ACCESS_KEY_ID],
            Configurable::KEY_ASSOCIATE_TAG     => $configurations[Configurable::KEY_ASSOCIATE_TAG],
        ));
        return $httpRequest;
    }
}
