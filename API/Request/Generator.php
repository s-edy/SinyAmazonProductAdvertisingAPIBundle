<?php
/**
 * This file is a part of SinyAmazonProductAdvertisingAPIBundle package.
 *
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API\Request;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Generatable;

/**
 * This is a class that build a HttpRequest by the Request.
 *
 * @package SinyAmazonProductAdvertisingAPI
 * @subpackage API
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */
class Generator implements Generatable
{
    /**
     * Request method
     *
     * @var string - GET or POST
     */
    private $method;

    /**
     * Request end point
     *
     * @var string - ex) http://ecs.amazonaws.jp
     */
    private $endPoint;

    /**
     * Request URI
     *
     * @var string - ex) /onca/xml
     */
    private $uri;

    /**
     * Request parameters
     *
     * @var array
     */
    private $parameters = array();

    /**
     * {@inheritdoc}
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Request.Generatable::setRequestMethod()
     */
    public function setRequestMethod($method)
    {
        $this->method = $method;
    }

    /**
     * {@inheritdoc}
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Request.Generatable::generateCanonicalQueryString()
     */
    public function generateCanonicalQueryString()
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
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Request.Generatable::generateSignature()
     */
    public function generateSignature()
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
}
