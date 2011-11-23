<?php
/**
* This test file is a part of SinyAmazonProductAdvertisingAPIBundle package.
*
* @author Shinichiro Yuki <sinycourage@gmail.com>
*/

namespace Siny\Amazon\ProductAdvertisingAPIBundle\Tests\API\Request;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Builder;

class BuilderTest extends \PHPUnit_Framework_TestCase
{
    private $builder;

    public function setUp()
    {
        $this->builder = new Builder($this->getMockOfConfiguration());
    }

    /**
     * A self object will be retuned when invoking setConfiguration()
     */
    public function testSelfObjectWillBeReturnedWhenInvokingSetConfiguration()
    {
        $this->assertSame(
            $this->builder, $this->builder->setConfiguration($this->getMockOfConfiguration()),
        	"Self object will be returned when invoking setConfiguration().");
    }

    /**
     * A configurable object will be returned when invoking getConfiguration()
     */
    public function testConfigurableObjectWillBeReturnedWhenInvokingGetConfiguration()
    {
        $this->assertInstanceOf(
            "Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configurable",
            $this->builder->getConfiguration(),
            "Configurable object will be returned when invoking getConfiguration().");
    }

    /**
     * HttpRequest object will be returned when invoking build
     */
    public function testHttpRequestObjectWillBeRetunedWhenInvokingBuild()
    {
        $this->assertInstanceOf(
            "HttpRequest",
            $this->builder->build($this->getMockOfRequest()),
            "HttpRequest object will be returned when invoking build().");
    }

    private function getMockOfConfiguration()
    {
        return $this->getMock('Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configurable');
    }

    private function getMockOfRequest()
    {
        return $this->getMock('Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Requestable');
    }
}
