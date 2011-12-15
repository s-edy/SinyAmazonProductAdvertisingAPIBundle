<?php
/**
 * This file is a part of SinyAmazonProductAdvertisingAPIBundle package.
 *
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API;

/**
 * This is a interface of Response object.
 *
 * @package SinyAmazonProductAdvertisingAPI
 * @subpackage API
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */
interface ResponseInterface
{
    /**
     * Is this a response success ?
     *
     * @return boolean - Whether the response is successful
     */
    public function isSuccess();

    /**
     * To a SimpleXmlElement class instance created from the returned XML
     *
     * @return SimpleXmlElement
     */
    public function toSimpleXmlElement();

    /**
     * Get raw body message
     *
     * @return string - A raw response body
     */
    public function getRawBody();
}
