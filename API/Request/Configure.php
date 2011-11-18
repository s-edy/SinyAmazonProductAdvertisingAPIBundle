<?php
/**
 * This file is a part of SinyAmazonProductAdvertisingAPIBundle package.
 *
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API\Request;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configurable;

/**
 * This is a class to configure the basic parameters
 * for the Amazon Product Advertising API
 *
 * @package SinyAmazonProductAdvertisingAPI
 * @subpackage API
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */
class Configure implements Configurable
{
    const KEY_NAME_SERVICE           = 'Service';
    const KEY_NAME_AWS_ACCESS_KEY_ID = 'AWSAccessKeyId';
    const KEY_NAME_ASSOCIATE_TAG     = 'AssociateTag';
    const KEY_NAME_VERSION           = 'Version';
    const KEY_NAME_TIMESTAMP         = 'Timestamp';

    // SERVICE
    const SERVICE_NAME = 'AWSECommerceService';

    // API version
    const API_VERSION = '2010-09-01';

    // Countries
    const LOCALE_CA = 'CA'; // canada
    const LOCALE_CN = 'CN'; // china
    const LOCALE_DE = 'DE'; // germany
    const LOCALE_ES = 'ES'; // spain
    const LOCALE_FR = 'FR'; // france
    const LOCALE_IT = 'IT'; // italy
    const LOCALE_JP = 'JP'; // japan
    const LOCALE_UK = 'UK'; // united kingdom
    const LOCALE_US = 'US'; // united states of america

    // End points
    const ENDPOINT_CA = 'ecs.amazonaws.ca';
    const ENDPOINT_CN = 'webservices.amazon.cn';
    const ENDPOINT_DE = 'ecs.amazonaws.de';
    const ENDPOINT_ES = 'webservices.amazon.es';
    const ENDPOINT_FR = 'ecs.amazonaws.fr';
    const ENDPOINT_IT = 'webservices.amazon.it';
    const ENDPOINT_JP = 'ecs.amazonaws.jp';
    const ENDPOINT_UK = 'ecs.amazonaws.co.uk';
    const ENDPOINT_US = 'webservices.amazon.com';

    // Path
    const REQUEST_URI = '/onca/xml';

    private $parameters = array();

    /**
     * set the base parameters such as "AssociateTag" for the request.
     *
     * @param string $awsAccessKeyId  AWS Access Key ID
     * @param string $secretAccessKey Secret access key
     * @param string $associateTag    Associate tag
     * @param string $locale          specify the locale to request to Amazon
     *                                from the locale constants (ex: Request::LOCALE_JP)
     */
    public function __construct($awsAccessKeyId, $secretAccessKey, $associateTag, $locale)
    {
        $this->setAwsAccessKeyId($awsAccessKeyId);
        $this->setSecretAccessKey($secretAccessKey);
        $this->setAssociateTag($associateTag);
        $this->setLocale($locale);
        $this->setDateTime(new \DateTime());
    }

    /**
     * set AWS access key ID
     * @param string $awsAccessKeyId
     */
    public function setAwsAccessKeyId($awsAccessKeyId)
    {
        $this->awsAccessKeyId = $awsAccessKeyId;
    }

    /**
     * set Secret access key
     * @param string $secretAccessKey
     */
    public function setSecretAccessKey($secretAccessKey)
    {
        $this->secretAccessKey = $secretAccessKey;
    }

    /**
     * set Associate tag
     * @param string $associateTag
     */
    public function setAssociateTag($associateTag)
    {
        $this->associateTag = $associateTag;
    }

    /**
     * set Locale
     *
     * @param string $locale
     * @throws RequestException
     */
    public function setLocale($locale)
    {
        if (in_array($locale, $this->locales) === false) {
            throw new RequestException(sprintf("A specified locale was wrong. locale=[%s]", $locale));
        }
        $this->locale = $locale;
    }

    /**
     * set DateTime for sending request
     *
     * @param \DateTime $dateTime
     */
    public function setDateTime(\DateTime $dateTime)
    {
        $newDateTime = clone $dateTime;
        $this->dateTime = $newDateTime;
    }

    /**
     * set secure request.
     *
     * A request send securely if you invoke this method.
     * - using SSL
     * - using more secure endpoint
     */
    public function setSecureRequest()
    {
        $this->isSecureRequest = true;
    }

    /**
     * reset secure request.
     *
     * A request sending returns normal if you invoke this method.
     * - Won't use SSL
     * - using normal endpoint
     */
    public function resetSecureRequest()
    {
        $this->isSecureRequest = false;
    }

    /**
     * get AWS Access key ID
     * @return string
     */
    public function getAwsAccessKeyId()
    {
        return $this->awsAccessKeyId;
    }

    /**
     * get Secret access key
     * @return string
     */
    public function getSecretAccessKey()
    {
        return $this->secretAccessKey;
    }

    /**
     * get Associate tag
     * @return string
     */
    public function getAssociateTag()
    {
        return $this->associateTag;
    }

    /**
     * get locale
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * get DateTime
     *
     * @return \DateTime
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * is secure request
     *
     * whethere a request send securely
     *
     * @return boolean
     */
    public function isSecureRequest()
    {
        return $this->isSecureRequest;
    }

    /**
     * get request method
     *
     * @return string
     */
    public function getRequestMethod()
    {
        return $this->method;
    }

    /**
     * get end point
     *
     * @return string
     */
    public function getEndPoint()
    {
        return $this->endPoints[$this->getLocale()];
    }

    /**
     * {@inheritdoc}
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Request.Buildable::build()
     */
    public function build(Requestable $request)
    {
    }
}
