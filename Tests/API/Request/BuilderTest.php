<?php
/**
* This test file is a part of SinyAmazonProductAdvertisingAPIBundle package.
*
* @author Shinichiro Yuki <sinycourage@gmail.com>
*/

namespace Siny\Amazon\ProductAdvertisingAPIBundle\Tests\API\Request;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Builder;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configurable;
use \HttpRequest;

class BuilderTest extends \PHPUnit_Framework_TestCase
{
    private $requires = array(
        'Service'         => 'AWSECommerceService',
        'Version'         => '2010-09-01',
        'AWSAccessKeyId'  => 'DummyAWSAccessKeyID',
        'SecretAccessKey' => 'DummySecretAccessKey',
        'AssociateTag'    => 'DummyAssociateTag',
        'EndPoint'        => 'ecs.amazonaws.jp',
        'RequestURI'      => '/onca/xml',
        'IsSecure'        => false,
        'Method'          => 'GET',
    );

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

    /**
     * A HTTP request object to which some HTTP methods are set will be returned.
     *
     * @dataProvider provideMethods
     * @param string $method
     * @param integer $expects
     */
    public function testAHttpRequestObjectToWhichSomeMethodsAreSetWillBeReturned($method, $expects)
    {
        $overrides = array(Configurable::KEY_METHOD => $method);
        $httpRequest = $this->builder
            ->setConfiguration($this->getMockOfConfigurationRetuenedParameters($overrides))
            ->build($this->getMockOfRequest());
        $this->assertSame($expects, $httpRequest->getMethod(), "Returned HttpRequest object won't use specified method.");
    }
    public function provideMethods()
    {
        return array(
            array(Configurable::METHOD_GET,  HttpRequest::METH_GET),
            array(Configurable::METHOD_POST, HttpRequest::METH_POST),
        );
    }

    /**
     * A HTTP request object to which a Service parameter was set will be returned.
     */
    public function testContainsAServiceParameterInTheQueryString()
    {
        $httpRequest = $this->builder
            ->setConfiguration($this->getMockOfConfigurationRetuenedParameters())
            ->build($this->getMockOfRequest());
        $this->assertContains('Service=AWSECommerceService', $httpRequest->getQueryData(), "The service parameter wasn't set");
        return $httpRequest;
    }

    /**
    * A HTTP request object to which a Version parameter was set will be returned.
    *
    * @depends testContainsAServiceParameterInTheQueryString
    */
    public function testContainsAVersionParameterInTheQueryString($httpRequest)
    {
        $this->assertContains('Version=2010-09-01', $httpRequest->getQueryData(), "The version parameter wasn't set");
    }

    /**
     * A HTTP request object to which an AWSAccessKeyId parameter was set will be returned.
     *
     * @depends testContainsAServiceParameterInTheQueryString
     */
    public function testContainsAnAWSAccessKeyIdParameterInTheQueryString($httpRequest)
    {
        $this->assertContains('AWSAccessKeyId=DummyAWSAccessKeyID', $httpRequest->getQueryData(), "The AWSAccessKeyId parameter wasn't set");
    }

    /**
     * A HTTP request object to which an AssociateTag parameter was set will be returned.
     *
     * @depends testContainsAServiceParameterInTheQueryString
     */
    public function testContainsAnAssociateTagParameterInTheQueryString($httpRequest)
    {
        $this->assertContains('AssociateTag=DummyAssociateTag', $httpRequest->getQueryData(), "The AssociateTag parameter wasn't set");
    }

    private function getMockOfConfigurationRetuenedParameters(array $overrides = array(), array $additions = array())
    {
        $returned = array_merge($additions, $this->requires, $overrides);

        $configuration = $this->getMockOfConfiguration();
        $configuration
            ->expects($this->once())
            ->method('toArray')
            ->will($this->returnValue($returned));

        return $configuration;
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
