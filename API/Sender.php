<?php
/**
 * This file is a part of SinyAmazonProductAdvertisingAPIBundle package.
 *
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Requestable,
    Siny\Amazon\ProductAdvertisingAPIBundle\API\Response;

/**
 * This is a class to send HTTP request for the Amazon.
 *
 * @package SinyAmazonProductAdvertisingAPI
 * @subpackage API
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */
class Sender
{
    /**
     * a sending requestable class instance
     *
     * @var Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Requestable
     */
    private $request;

    /**
     * set a Requestable class instance when this is constructed.
     *
     * @param Requestable $request
     */
    public function __construct(Requestable $request)
    {
        $this->setRequest($request);
    }

    /**
     * set a class instance which implement a Requestable insterface.
     *
     * @param Requestable $request
     * @return \Siny\Amazon\ProductAdvertisingAPIBundle\API\Sender
     */
    public function setRequest(Requestable $request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * get a class instance which implement a Requestable interface.
     *
     * @return \Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Requestable
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * build HttpRequest class instance from request.
     *
     * @return HttpRequest
     */
    public function buildHttpRequest()
    {
        $httpRequest = new \HttpRequest();
        if ($this->request->isGETMethod()) {
            $httpRequest->setMethod(HTTP_METH_GET);
        } elseif ($this->request->isPOSTMethod()) {
            $httpRequest->setMethod(HTTP_METH_POST);
        }
        return $httpRequest;
    }

    /**
     * send a HTTP request
     *
     * @return \Siny\Amazon\ProductAdvertisingAPIBundle\API\Response
     */
    public function send()
    {
        return new Response();
    }
}
