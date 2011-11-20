<?php
/**
 * This file is a part of SinyAmazonProductAdvertisingAPIBundle package.
 *
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API\Request;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Configurable;

/**
 * This is a class to configure the basic parameters
 * for the Amazon Product Advertising API
 *
 * @package SinyAmazonProductAdvertisingAPI
 * @subpackage API
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */
class Configuration implements Configurable
{
    // Amazon require the following
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

    // Methods
    const METHOD_GET  = 'GET';
    const METHOD_POST = 'POST';

    /**
     * The parameters array for configuration.
     *
     * @var array
     */
    private $parameters = array();

    /**
     * Access Key ID
     *
     * @var string An access key ID
     */
    protected $awsAccessKeyId;

    /**
     * Secret Access Key ID
     *
     * @var string secret access key ID
     */
    protected $secretAccessKey;

    /**
     * Associate Tag
     *
     * @var string associate tag
     */
    protected $associateTag;

    /**
     * Locale
     *
     * @see Generator::LOCALE_CA
     * @see Generator::LOCALE_CN
     * @see Generator::LOCALE_DE
     * @see Generator::LOCALE_ES
     * @see Generator::LOCALE_FR
     * @see Generator::LOCALE_IT
     * @see Generator::LOCALE_JP
     * @see Generator::LOCALE_UK
     * @see Generator::LOCALE_US
     * @var string locale string
     */
    protected $locale;

    /**
     * locale white list
     *
     * @var array
     */
    private $locales = array(
        self::LOCALE_CA,
        self::LOCALE_CN,
        self::LOCALE_DE,
        self::LOCALE_ES,
        self::LOCALE_FR,
        self::LOCALE_IT,
        self::LOCALE_JP,
        self::LOCALE_UK,
        self::LOCALE_US,
    );

    /**
     * End points
     *
     * @var array
     */
    private $endPoints = array(
        self::LOCALE_CA => self::ENDPOINT_CA,
        self::LOCALE_CN => self::ENDPOINT_CN,
        self::LOCALE_DE => self::ENDPOINT_DE,
        self::LOCALE_ES => self::ENDPOINT_ES,
        self::LOCALE_FR => self::ENDPOINT_FR,
        self::LOCALE_IT => self::ENDPOINT_IT,
        self::LOCALE_JP => self::ENDPOINT_JP,
        self::LOCALE_UK => self::ENDPOINT_UK,
        self::LOCALE_US => self::ENDPOINT_US,
    );

    /**
     * THe DateTime class instance for sending request
     * @var \DateTime
     */
    private $dateTime;

    /**
     * Whether a request send securely
     *
     * @var boolean
     */
    private $isSecureRequest = false;

    /**
     * Method type. GET/POST
     *
     * @var string
     */
    private $method = self::METHOD_GET;

    /**
     * Set the base parameters such as "AssociateTag" for the request.
     *
     * @param string $awsAccessKeyId  AWS Access Key ID
     * @param string $secretAccessKey Secret access key
     * @param string $associateTag    Associate tag
     * @param string $locale          specify the locale to request to Amazon
     *                                from the locale constants (ex: Request::LOCALE_JP)
     */
    public function __construct($awsAccessKeyId, $secretAccessKey, $associateTag, $locale)
    {
        $this
            ->reset()
            ->setAWSAccessKeyId($awsAccessKeyId)
            ->setSecretAccessKey($secretAccessKey)
            ->setAssociateTag($associateTag)
            ->setLocale($locale)
            ->setDateTime(new \DateTime())
        ;
    }

    /**
     * Set AWS access key ID
     *
     * @param string $awsAccessKeyId
     * @return Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configuration
     */
    public function setAWSAccessKeyId($awsAccessKeyId)
    {
        $this->set(self::KEY_NAME_AWS_ACCESS_KEY_ID, $awsAccessKeyId);

        return $this;
    }

    /**
     * Set Secret access key
     *
     * @param string $secretAccessKey
     * @return Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configuration
     */
    public function setSecretAccessKey($secretAccessKey)
    {
        $this->secretAccessKey = $secretAccessKey;

        return $this;
    }

    /**
     * Set Associate tag
     *
     * @param string $associateTag
     * @return Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configuration
     */
    public function setAssociateTag($associateTag)
    {
        $this->set(self::KEY_NAME_ASSOCIATE_TAG, $associateTag);

        return $this;
    }

    /**
     * Set Locale
     *
     * @param string $locale
     * @return Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configuration
     * @throws RequestException
     */
    public function setLocale($locale)
    {
        if (in_array($locale, $this->locales) === false) {
            throw new \InvalidArgumentException(sprintf("A specified locale was wrong. locale=[%s]", $locale));
        }
        $this->locale = $locale;

        return $this;
    }

    /**
     * Set DateTime for sending request
     *
     * @param \DateTime $dateTime
     * @return Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configuration
     */
    public function setDateTime(\DateTime $dateTime)
    {
        $newDateTime = clone $dateTime;
        $this->dateTime = $newDateTime;

        return $this;
    }

    /**
     * Set secure request.
     *
     * A request send securely if you invoke this method.
     * - using SSL
     * - using more secure endpoint
     *
     * @return Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configuration
     */
    public function setSecureRequest()
    {
        $this->isSecureRequest = true;

        return $this;
    }

    /**
     * Reset secure request.
     *
     * A request sending returns normal if you invoke this method.
     * - Won't use SSL
     * - using normal endpoint
     *
     * @return Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configuration
     */
    public function resetSecureRequest()
    {
        $this->isSecureRequest = false;

        return $this;
    }

    /**
     * Set GET Method
     *
     * @return Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configuration
     */
    public function setGETMethod()
    {
        $this->method = self::METHOD_GET;

        return $this;
    }

    /**
     * Set POST Method
     *
     * @return Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configuration
     */
    public function setPOSTMethod()
    {
        $this->method = self::METHOD_POST;

        return $this;
    }

    /**
     * Get AWS Access key ID
     *
     * @return string
     */
    public function getAWSAccessKeyId()
    {
        return $this->get(self::KEY_NAME_AWS_ACCESS_KEY_ID);
    }

    /**
     * Get Secret access key
     * @return string
     */
    public function getSecretAccessKey()
    {
        return $this->secretAccessKey;
    }

    /**
     * Get Associate tag
     * @return string
     */
    public function getAssociateTag()
    {
        return $this->get(self::KEY_NAME_ASSOCIATE_TAG);
    }

    /**
     * Get locale
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Get DateTime
     *
     * @return \DateTime
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * Is secure request
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
     * Get request method
     *
     * @return string
     */
    public function getRequestMethod()
    {
        return $this->method;
    }

    /**
     * Is method GET ?
     *
     * @return boolean
     */
    public function isMethodGET()
    {
        return ($this->method === self::METHOD_GET);
    }

    /**
     * Is method POST ?
     *
     * @return boolean
     */
    public function isMethodPOST()
    {
        return ($this->method === self::METHOD_POST);
    }

    /**
     * Get end point
     *
     * @return string
     */
    public function getEndPoint()
    {
        return $this->endPoints[$this->getLocale()];
    }

    /**
     * The parameters will be set that should set as a default
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Request.Configurable::getAll()
     */
    public function reset()
    {
        return $this
            ->clear()
            ->set(self::KEY_NAME_SERVICE, self::SERVICE_NAME)
            ->set(self::KEY_NAME_VERSION, self::API_VERSION)
            ->setDateTime(new \DateTime())
            ->resetSecureRequest()
        ;
    }

    /**
     * {@inheritdoc}
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Request.Configurable::set()
     */
    public function set($key, $value)
    {
        $this->parameters[$key] = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Request.Configurable::get()
     */
    public function get($key)
    {
        if ($this->has($key) === false) {
            throw new \InvalidArgumentException(sprintf("The value of speficied key index was not found. key=[%s]", $key));
        }
        return $this->parameters[$key];
    }

    /**
     * {@inheritdoc}
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Request.Configurable::has()
     */
    public function has($key)
    {
        return isset($this->parameters[$key]);
    }

    /**
     * {@inheritdoc}
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Request.Configurable::clear()
     */
    public function clear()
    {
        $this->parameters = array();

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Request.Configurable::getAll()
     */
    public function getAll()
    {
        return $this->parameters;
    }
}
