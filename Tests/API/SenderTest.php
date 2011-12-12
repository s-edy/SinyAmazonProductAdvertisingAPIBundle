<?php
/**
* This test file is a part of SinyAmazonProductAdvertisingAPIBundle package.
*
* @author Shinichiro Yuki <sinycourage@gmail.com>
*/

namespace Siny\Amazon\ProductAdvertisingAPIBundle\Tests\API;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Sender;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Buildable;
use \HttpMessage;

class SenderTest extends \PHPUnit_Framework_TestCase
{
    private $sender;

    public function setUp()
    {
        $this->sender = new Sender($this->createMockOfBuilder());
    }

    /**
     * get builder in the case of default.
     */
    public function testGetBuilderInTheCaseOfDefault()
    {
        $this->assertInstanceOf(
            'Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Buildable',
            $this->sender->getBuilder(),
            "Gotten class instance wasn't Requestable.");
    }

    /**
     * set builder
     */
    public function testSetBuilder()
    {
        $this->assertSame(
            $this->sender, $this->sender->setBuilder($this->createMockOfBuilder()),
            "Gotten class instance wasn't itself.");
    }

    /**
     * get request
     */
    public function testGetBuilder()
    {
        $this->assertInstanceOf(
            'Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Buildable',
            $this->sender->getBuilder(),
            "Gotten class instance wasn't Buildable.");
    }

    /**
     * Returns a response class instance when sending a request.
     *
     * @dataProvider provideSend
     */
    public function testReturnsAResponseClassInstanceWhenSendingARequest(Buildable $builder)
    {
        $sender = new Sender($builder);
        $this->assertInstanceOf(
            'Siny\Amazon\ProductAdvertisingAPIBundle\API\Response',
            $sender->send($this->createMockOfRequest()),
            "Did not return a Response class instance when sending a request.");
    }

    public function provideSend()
    {
        $httpMessage = new HttpMessage();
        $httpMessage->setType(HTTP_MSG_RESPONSE);
        $httpMessage->setResponseCode(200);

        $httpRequest = $this->getMock('HttpRequest');
        $httpRequest->expects($this->any())
            ->method('send')
            ->will($this->returnValue($httpMessage));

        $builder = $this->createMockOfBuilder();
        $builder->expects($this->any())
            ->method('build')
            ->will($this->returnValue($httpRequest));

        return array(
            array($builder),
        );
    }

    /**
     * Sending exception occur when sending a request
     *
     * @dataProvider provideSendError
     * @expectedException Siny\Amazon\ProductAdvertisingAPIBundle\API\Exception\SenderException
     * @expectedExceptionMessage Sending exception occurred.
     */
    public function testExceptionOccurWhenSendingARequest(Buildable $builder)
    {
        $sender = new Sender($builder);
        $sender->send($this->createMockOfRequest());
    }

    public function provideSendError()
    {
        $builder = $this->createMockOfBuilder();
        $builder->expects($this->any())
            ->method('build')
            ->will($this->throwException(new \HttpException('dummy')));

        return array(
            array($builder),
        );
    }

    private function createMockOfBuilder()
    {
        return $this->getMock('Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Buildable');
    }

    private function createMockOfRequest()
    {
        return $this->getMock('Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Requestable');
    }

    private function createMockOfResponse()
    {
        return $this->getMock('Siny\Amazon\ProductAdvertisingAPIBundle\API\Response');
    }
}