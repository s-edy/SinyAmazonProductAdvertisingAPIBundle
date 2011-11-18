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
class Configuration implements Configurable
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
     * date time class instance for sending request
     * @var \DateTime
     */
    private $dateTime;

    /**
     * whether a request send securely
     *
     * @var boolean
     */
    private $isSecureRequest = false;

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
        $this->reset();
        $this->setAwsAccessKeyId($awsAccessKeyId);
        $this->setSecretAccessKey($secretAccessKey);
        $this->setAssociateTag($associateTag);
        $this->setLocale($locale);
        $this->setDateTime(new \DateTime());
    }

    /**
     * Set AWS access key ID
     *
     * @param string $awsAccessKeyId
     * @return Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configuration
     */
    public function setAwsAccessKeyId($awsAccessKeyId)
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
     * set Locale
     *
     * @param string $locale
     * @throws RequestException
     */
    public function setLocale($locale)
    {
        if (in_array($locale, $this->locales) === false) {
            throw new \InvalidArgumentException(sprintf("A specified locale was wrong. locale=[%s]", $locale));
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
     * The parameters will be set that should set as a default
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Request.Configurable::getAll()
     */
    public function reset()
    {
        $this->clear();
        $this->set(self::KEY_NAME_SERVICE, self::SERVICE_NAME);
        $this->set(self::KEY_NAME_VERSION, self::API_VERSION);

        return $this;
    }

    /**
     * get AWS Access key ID
     * @return string
     */
    public function getAwsAccessKeyId()
    {
        return $this->get(self::KEY_NAME_AWS_ACCESS_KEY_ID);
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
        return $this->get(self::KEY_NAME_ASSOCIATE_TAG);
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
}
