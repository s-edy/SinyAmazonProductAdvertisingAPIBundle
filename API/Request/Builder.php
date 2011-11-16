<?php
/**
 * This file is a part of SinyAmazonProductAdvertisingAPIBundle package.
 *
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API\Request;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Exception\RequestException;

/**
 * This is a class that build a HttpRequest by the Request.
 *
 * @package SinyAmazonProductAdvertisingAPI
 * @subpackage API
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */
class Builder
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
            throw new RequestException(sprintf(
            	"A specified locale was wrong. locale=[%s]", $locale));
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
     * generate Canonical query string from parameters
     *
     * @param array $parameters - some query parameters array
     * @return string - canonical query string
     */
    public function generateCanonicalQueryString(array $parameters)
    {
        $query = new \HttpQueryString(false);
        ksort($parameters);
        foreach ($parameters as $key => $value) {
            $query->set(array($key => $value));
        }
        return $query->toString();
    }

    /**
     * generate signature
     *
     * @param string $requestMethod
     * @param string $endPoint
     * @param string $canonicalQueryString
     * @return string
     */
    public function generateSignature($requestMethod, $endPoint, $canonicalQueryString)
    {
        $data = implode("\n", array(
            $requestMethod,
            $endPoint,
            self::REQUEST_URI,
            $canonicalQueryString,
        ));
        $hash = hash_hmac('sha256', $data, $this->getSecretAccessKey(), true);
        return rawurlencode(base64_encode($hash));
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
