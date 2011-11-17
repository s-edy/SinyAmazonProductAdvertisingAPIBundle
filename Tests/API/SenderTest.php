<?php
/**
* This test file is a part of SinyAmazonProductAdvertisingAPIBundle package.
*
* @author Shinichiro Yuki <sinycourage@gmail.com>
*/

namespace Siny\Amazon\ProductAdvertisingAPIBundle\Tests\API;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Sender;

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
     * Did not return a response class instance when sending a request.
     */
    public function testReturnsAResponseClassInstanceWhenSendingARequest()
    {
        $response = $this->sender->send($this->createMockOfRequest());

        $this->assertInstanceOf(
            'Siny\Amazon\ProductAdvertisingAPIBundle\API\Response',
            $response,
            "Did not return a Response class instance when sending a request.");
    }

    private function createMockOfBuilder()
    {
        return $this->getMock('Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Buildable');
    }

    private function createMockOfRequest()
    {
        return $this->getMock('Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Requestable');
    }
}
