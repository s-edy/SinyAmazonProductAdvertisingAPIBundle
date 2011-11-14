<?php
/**
* This test file is a part of SinyAmazonProductAdvertisingAPIBundle package.
*
* @author Shinichiro Yuki <sinycourage@gmail.com>
*/

namespace Siny\Amazon\ProductAdvertisingAPIBundle\Tests\API;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Sender,
    Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Request;

class SenderTest extends \PHPUnit_Framework_TestCase
{
    private $request;
    private $sender;

    public function setUp()
    {
        $operation = $this->getMockForAbstractClass(
            'Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation',
            array('OperationName', array('ParameterName' => 'ParameterValue')));
        $this->request = new Request($operation);

        $this->sender = new Sender($this->request);
    }

    /**
     * get request in the case of default.
     */
    public function testGetRequestInTheCaseOfDefault()
    {
        $this->assertInstanceOf(
            'Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Requestable',
            $this->sender->getRequest(),
            "Gotten class instance wasn't Requestable.");
    }

    /**
     * set request
     */
    public function testSetRequest()
    {
        $this->assertSame(
            $this->sender, $this->sender->setRequest($this->request),
            "Gotten class instance wasn't itself.");
    }

    /**
     * get request
     */
    public function testGetRequest()
    {
        $this->assertInstanceOf(
            'Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Requestable',
            $this->sender->getRequest(),
            "Gotten class instance wasn't Requestable.");
    }

    /**
     * check whether the HttpRequest class exists.
     */
    public function testCheckHttpRequest()
    {
        $this->assertTrue(class_exists('HttpRequest'), "There is not HttpRequest class.");
    }

    /**
     * whether HttpRequest class instance returns.
     */
    public function testBuildHttpRequest()
    {
        $this->assertInstanceOf(
            'HttpRequest', $this->sender->buildHttpRequest(),
            "Did not return HttpRequest class instance.");
    }

    /**
     * build HttpRequest in the case of setting GET method
     */
    public function testBuildHttpRequestInTheCaseOfSettingGETMethod()
    {
        $this->sender->getRequest()->setGETMethod();
        $this->assertSame(
            HTTP_METH_GET, $this->sender->buildHttpRequest()->getMethod(),
            "Did not return GET method constant.");
    }

    /**
     * build HttpRequest in the case of setting POST method
     */
    public function testBuildHttpRequestInTheCaseOfSettingPOSTMethod()
    {
        $this->sender->getRequest()->setPOSTMethod();
        $this->assertSame(
            HTTP_METH_POST, $this->sender->buildHttpRequest()->getMethod(),
            "Did not return POST method constant.");
    }

    /**
     * Did not return a response class instance when sending a request.
     */
    public function testReturnsAResponseClassInstanceWhenSendingARequest()
    {
        $response = $this->sender->send();

        $this->assertInstanceOf(
            'Siny\Amazon\ProductAdvertisingAPIBundle\API\Response',
            $response,
            "Did not return a Response class instance when sending a request.");
    }
}
