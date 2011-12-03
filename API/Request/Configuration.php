<?php
/**
 * This file is a part of SinyAmazonProductAdvertisingAPIBundle package.
 *
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API\Request;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configurable as BasicConfigurable;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Configuration as BasicConfiguration;

/**
 * This is a class to configure the request parameters
 * for the Amazon Product Advertising API
 *
 * @package SinyAmazonProductAdvertisingAPI
 * @subpackage API
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */
class Configuration extends BasicConfiguration implements BasicConfigurable
{
    /**
     * Fixed parameters
     */
    const SERVICE     = 'AWSECommerceService';
    const API_VERSION = '2010-09-01';
    const REQUEST_URI = '/onca/xml';

    /**
     * {@inheritdoc} In addition, Override fixed parameters.
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API.Configuration::fromArray()
     */
    public function fromArray(array $parameters)
    {
        return parent::fromArray($parameters)
            ->set(self::KEY_SERVICE, self::SERVICE)
            ->set(self::KEY_VERSION, self::API_VERSION)
            ->set(self::KEY_REQUEST_URI, self::REQUEST_URI)
        ;
    }

    /**
     * Set the base parameters such as "AssociateTag" for the request.
     *
     * @param string $awsAccessKeyId  - AWS Access Key ID
     * @param string $secretAccessKey - Secret access key
     * @param string $associateTag    - Associate tag
     */
    public function __construct($awsAccessKeyId, $secretAccessKey, $associateTag, $endPoint)
    {
        $this->fromArray(array(
            self::KEY_AWS_ACCESS_KEY_ID => $awsAccessKeyId,
            self::KEY_SECRET_ACCESS_KEY => $secretAccessKey,
            self::KEY_ASSOCIATE_TAG     => $associateTag,
            self::KEY_ENDPOINT          => $endPoint,
            self::KEY_IS_SECURE         => false,
            self::KEY_METHOD            => self::METHOD_GET,
        ));
    }

    /**
     * {@inheritdoc}
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Request.Configurable::toRequiredQueryData()
     */
    public function toRequiredQueryData()
    {
        return array(
            self::KEY_SERVICE           => self::SERVICE,
            self::KEY_VERSION           => self::API_VERSION,
            self::KEY_AWS_ACCESS_KEY_ID => $this->get(self::KEY_AWS_ACCESS_KEY_ID),
            self::KEY_ASSOCIATE_TAG     => $this->get(self::KEY_ASSOCIATE_TAG),
        );
    }

    /**
     * {@inheritdoc}
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Request.Configurable::getEndPoint()
     */
    public function getEndPoint()
    {
        return $this->get(self::KEY_ENDPOINT);
    }

    /**
     * {@inheritdoc}
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Request.Configurable::getRequestURI()
     */
    public function getRequestURI()
    {
        return self::REQUEST_URI;
    }

    /**
     * {@inheritdoc}
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Request.Configurable::isSecure()
     */
    public function isSecure()
    {
        return $this->get(self::KEY_IS_SECURE);
    }

    /**
     * {@inheritdoc}
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Request.Configurable::isMethodGET()
     */
    public function isMethodGET()
    {
        return ($this->get(self::KEY_METHOD) === self::METHOD_GET);
    }

    /**
     * {@inheritdoc}
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Request.Configurable::isMethodPOST()
     */
    public function isMethodPOST()
    {
        return ($this->get(self::KEY_METHOD) === self::METHOD_POST);
    }

    /**
     * {@inheritdoc}
     */
    public function setOption($key, $value)
    {
        return $this->set($key, $value);
    }
}
