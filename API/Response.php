<?php
/**
 * This file is a part of Siny\Amazon\ProductAdvertisingAPIBundle package.
 *
 * (c) Shinichiro Yuki <edy@siny.jp>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\ResponseInterface;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Exception\ResponseException;
use \HttpMessage;
use \SimpleXMLElement;

/**
 * This is a response class of a request to the Amazon Product Advertising API
 *
 * @package SinyAmazonProductAdvertisingAPI
 * @subpackage API
 * @author Shinichiro Yuki <edy@siny.jp>
 */
class Response implements ResponseInterface
{
    private $httpMessage;

    public function __construct(HttpMessage $httpMessage)
    {
        if ($httpMessage->getType() !== HTTP_MSG_RESPONSE) {
            throw new ResponseException("Accept the object only which type is response.");
        }
        $this->httpMessage = $httpMessage;
    }

    /**
     * {@inheritdoc}
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API.ResponseInterface::isSuccess()
     */
    public function isSuccess()
    {
        return ($this->httpMessage->getResponseCode() === 200);
    }

    /**
     * {@inheritdoc}
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API.ResponseInterface::toSimpleXmlElement()
     */
    public function toSimpleXmlElement()
    {
        return new SimpleXMLElement($this->getRawBody(), LIBXML_COMPACT);
    }

    /**
     * {@inheritdoc}
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API.ResponseInterface::getRawBody()
     */
    public function getRawBody()
    {
        return $this->httpMessage->getBody();
    }
}
