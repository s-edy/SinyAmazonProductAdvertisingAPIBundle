<?php
/**
 * This file is a part of SinyAmazonProductAdvertisingAPIBundle package.
 *
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API\Request;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Requestable;

/**
 * This is a interface of Generatable object.
 *
 * @package SinyAmazonProductAdvertisingAPI
 * @subpackage API
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */
interface Generatable
{
    /**
     * set a request method
     *
     * @param string $method - Request method string. ex) 'GET', or 'POST'.
     * @return Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Generatable
     */
    public function setRequestMethod($method);

    /**
     * set an End point.
     *
     * @param string $endPoint - Requesting URL. ex) http://ecs.amazonaws.jp
     * @return Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Generatable
     */
    public function setEndPoint($endPoint);

    /**
     * set a request URI.
     *
     * @param string $uri - Requesting URI. ex) /onca/xml
     * @return Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Generatable
     */
    public function setRequestURI($uri);

    /**
     * set some parameters for request.
     *
     * @return Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Generatable
     */
    public function setParameters(array $parameters);

    /**
     * get a request method
     *
     * @return string - Request method string. ex) 'GET', or 'POST'.
     */
    public function getRequestMethod();

    /**
     * get an End point.
     *
     * @return string - Requesting URL. ex) http://ecs.amazonaws.jp
     */
    public function getEndPoint();

    /**
     * get a request URI.
     *
     * @return string - Requesting URI. ex) /onca/xml
     */
    public function getRequestURI();

    /**
     * get some parameters for request.
     *
     * @return array - paramerers array
     */
    public function getParameters();

    /**
     * generate Canonical query string from parameters
     *
     * @return string - canonical query string
     */
    public function generateCanonicalQueryString();

    /**
     * generate signature
     *
     * @return string
     */
    public function generateSignature();
}
