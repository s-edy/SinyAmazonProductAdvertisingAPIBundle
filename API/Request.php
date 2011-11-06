<?php
/**
 * This file is a part of SinyAmazonProductAdvertisingAPIBundle package.
 *
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API;

/**
 * This is a class to send HTTP request to Amazon
 * through the Amazon Product Advertising API.
 *
 * @package SinyAmazonProductAdvertisingAPI
 * @subpackage API
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */
class Request
{
    // API version
    const API_VERSION = '2010-09-01';

    // Timestamp format
    const DATE_FORMAT_ISO8601 = 'Y-m-d\TH:i:s\Z';

    // Countries
    const LOCALE_CA = 'CA'; // canada
    const LOCALE_DE = 'DE'; // germany
    const LOCALE_FR = 'FR'; // france
    const LOCALE_JP = 'JP'; // japan
    const LOCALE_UK = 'UK'; // united kingdom
    const LOCALE_US = 'US'; // united states of america

    // Path
    const REQUEST_PATH = '/onca/xml';

    // Access Key ID
    protected $awsAccessKeyId;

    // Secret Access Key ID
    protected $secretAccessKey;

    // Associate Tag
    protected $associateTag;

    // Locale
    protected $locale;

    /**
     * set the base parameters such as "AssociateTag" for the request.
     *
     * @param string $awsAccessKeyId  AWS Access Key ID
     * @param string $secretAccessKey Secret access key
     * @param string $associateTag    Associate tag
     * @param string $locale          specify the locale to request to Amazon
     *                                from the locale constants (ex: Request::LOCALE_JP)
     */
    public function __construct(
        $awsAccessKeyId, $secretAccessKey, $associateTag, $locale)
    {
        $this->setAwsAccessKeyId($awsAccessKeyId);
        $this->setSecretAccessKey($secretAccessKey);
        $this->setAssociateTag($associateTag);
        $this->setLocale($locale);
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
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
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
}
