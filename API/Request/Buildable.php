<?php
/**
 * This file is a part of SinyAmazonProductAdvertisingAPIBundle package.
 *
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API\Request;

/**
 * This is a interface of Buildable object.
 *
 * @package SinyAmazonProductAdvertisingAPI
 * @subpackage API
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */
interface Buildable
{
    // API version
    const API_VERSION = '2010-09-01';

    // Timestamp format
    const DATE_FORMAT_ISO8601 = 'Y-m-d\TH:i:s\Z';

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

    /**
     * set the base parameters such as "AssociateTag" for the request.
     *
     * @param string $awsAccessKeyId  AWS Access Key ID
     * @param string $secretAccessKey Secret access key
     * @param string $associateTag    Associate tag
     * @param string $locale          specify the locale to request to Amazon
     *                                from the locale constants (ex: Request::LOCALE_JP)
     */
    public function __construct($awsAccessKeyId, $secretAccessKey, $associateTag, $locale);

    /**
     * set AWS access key ID
     * @param string $awsAccessKeyId
     */
    public function setAwsAccessKeyId($awsAccessKeyId);

    /**
     * set Secret access key
     * @param string $secretAccessKey
     */
    public function setSecretAccessKey($secretAccessKey);

    /**
     * set Associate tag
     * @param string $associateTag
     */
    public function setAssociateTag($associateTag);

    /**
     * set Locale
     *
     * @param string $locale
     * @throws RequestException
     */
    public function setLocale($locale);

    /**
     * set DateTime for sending request
     *
     * @param \DateTime $dateTime
     */
    public function setDateTime(\DateTime $dateTime);

    /**
     * set secure request.
     *
     * A request send securely if you invoke this method.
     * - using SSL
     * - using more secure endpoint
     */
    public function setSecureRequest();

    /**
     * reset secure request.
     *
     * A request sending returns normal if you invoke this method.
     * - Won't use SSL
     * - using normal endpoint
     */
    public function resetSecureRequest();

    /**
     * get AWS Access key ID
     * @return string
     */
    public function getAwsAccessKeyId();

    /**
     * get Secret access key
     * @return string
     */
    public function getSecretAccessKey();

    /**
     * get Associate tag
     * @return string
     */
    public function getAssociateTag();

    /**
     * get locale
     * @return string
     */
    public function getLocale();

    /**
     * get DateTime
     *
     * @return \DateTime
     */
    public function getDateTime();

    /**
     * is secure request
     *
     * whethere a request send securely
     *
     * @return boolean
     */
    public function isSecureRequest();

    /**
     * get request method
     *
     * @return string
     */
    public function getRequestMethod();

    /**
     * generate Canonical query string from parameters
     *
     * @param array $parameters - some query parameters array
     * @return string - canonical query string
     */
    public function generateCanonicalQueryString(array $parameters);

    /**
     * generate signature
     *
     * @param string $requestMethod
     * @param string $endPoint
     * @param string $canonicalQueryString
     * @return string
     */
    public function generateSignature($requestMethod, $endPoint, $canonicalQueryString);

    /**
     * get end point
     *
     * @return string
     */
    public function getEndPoint();
}
