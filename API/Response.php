<?php
/**
 * This file is a part of SinyAmazonProductAdvertisingAPIBundle package.
 *
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\ResponseInterface;
use \HttpMessage;

/**
 * This is a response class of a request to the Amazon Product Advertising API
 *
 * @package SinyAmazonProductAdvertisingAPI
 * @subpackage API
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */
class Response implements ResponseInterface
{
    private $httpMessage;

    public function __construct(HttpMessage $httpMessage)
    {
        if ($this->httpMessage->getType() !== HTTP_MSG_RESPONSE) {
            throw new Exception("Accept the object only which type is response.");
            //throw new ResponseException();
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
}
