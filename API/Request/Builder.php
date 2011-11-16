<?php
/**
 * This file is a part of SinyAmazonProductAdvertisingAPIBundle package.
 *
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API\Request;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Buildable,
    Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Exception\RequestException;

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
     * {@inheritdoc}
     */
    public function setAwsAccessKeyId($awsAccessKeyId)
    {
        $this->awsAccessKeyId = $awsAccessKeyId;
    }

    /**
     * {@inheritdoc}
     */
    public function setSecretAccessKey($secretAccessKey)
    {
        $this->secretAccessKey = $secretAccessKey;
    }

    /**
     * {@inheritdoc}
     */
    public function setAssociateTag($associateTag)
    {
        $this->associateTag = $associateTag;
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function setDateTime(\DateTime $dateTime)
    {
        $newDateTime = clone $dateTime;
        $this->dateTime = $newDateTime;
    }

    /**
     * {@inheritdoc}
     */
    public function setSecureRequest()
    {
        $this->isSecureRequest = true;
    }

    /**
     * {@inheritdoc}
     */
    public function resetSecureRequest()
    {
        $this->isSecureRequest = false;
    }

    /**
     * {@inheritdoc}
     */
    public function getAwsAccessKeyId()
    {
        return $this->awsAccessKeyId;
    }

    /**
     * {@inheritdoc}
     */
    public function getSecretAccessKey()
    {
        return $this->secretAccessKey;
    }

    /**
     * {@inheritdoc}
     */
    public function getAssociateTag()
    {
        return $this->associateTag;
    }

    /**
     * {@inheritdoc}
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * {@inheritdoc}
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * {@inheritdoc}
     */
    public function isSecureRequest()
    {
        return $this->isSecureRequest;
    }

    /**
     * {@inheritdoc}
     */
    public function getRequestMethod()
    {
        return $this->method;
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function getEndPoint()
    {
        return $this->endPoints[$this->getLocale()];
    }
}
