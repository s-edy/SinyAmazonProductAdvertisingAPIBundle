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
    private $requiredQueryData = array(
        'Service'         => 'AWSECommerceService',
        'Version'         => '2010-09-01',
        'AWSAccessKeyId'  => 'DummyAWSAccessKeyID',
        'AssociateTag'    => 'DummyAssociateTag',
    );
    private $endpoints = array(
        'ecs.amazonaws.ca',
        'webservices.amazon.cn',
        'ecs.amazonaws.de',
        'webservices.amazon.es',
        'ecs.amazonaws.fr',
        'webservices.amazon.it',
        'ecs.amazonaws.jp',
        'ecs.amazonaws.co.uk',
        'webservices.amazon.com',
    );
    private $operationParameters = array(
        'Operation' => 'DummyOperation',
        'Foo'       => 'Bar',
        'Fizz'      => 'Bazz',
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
     * A generator object will be returned in the case of default
     */
    public function testAGeneratorObjectWillBeReturnedInTheCaseOfDefault()
    {
        $this->assertInstanceOf(
            'Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Generator',
            $this->builder->getGenerator(),
            "A generator didn't returned.");
    }

    /**
     * A self object will be returned when invoking setGenerator()
     */
    public function testASelfObjectWillBeReturnedWhenInvokingSetGenerator()
    {
        $this->assertSame(
            $this->builder, $this->builder->setGenerator($this->getMockOfGenerator()),
            "Self object will be returned when invoking setGenerator().");
    }

    /**
    * A generatable object will be returned when invoking getGenerator()
    */
    public function testAGeneratableObjectWillBeReturnedWhenInvokingGetGenerator()
    {
        $this->assertInstanceOf(
            "Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Generatable",
            $this->builder->getGenerator(),
            "A generatable object will be returned when invoking getGenerator().");
    }

    /**
     * HttpRequest object will be returned when invoking build
     *
     * @dataProvider provideForHttpRequestObjectWillBeReturnedWhenInvokingBuild
     */
    public function testHttpRequestObjectWillBeRetunedWhenInvokingBuild($configuration, $request)
    {
        $this->builder->setConfiguration($configuration);
        $this->assertInstanceOf(
            "HttpRequest",
            $this->builder->build($request),
            "HttpRequest object will be returned when invoking build().");
    }
    public function provideForHttpRequestObjectWillBeReturnedWhenInvokingBuild()
    {
        $configuration = $this->getMockOfConfiguration();
        $configuration->expects($this->once())
            ->method('toRequiredQueryData')
            ->will($this->returnValue($this->requiredQueryData));
        $request = $this->getMockOfRequestWhichReturnsEmptyArrayAtGetParameters();
        return array(
            array($configuration, $request),
        );
    }

    /**
     * A HTTP request object to which some HTTP methods are set will be returned.
     *
     * @dataProvider provideMethods
     */
    public function testAHttpRequestObjectToWhichSomeMethodsAreSetWillBeReturned($configuration, $expects)
    {
        $httpRequest = $this->builder
            ->setConfiguration($configuration)
            ->build($this->getMockOfRequestWhichReturnsEmptyArrayAtGetParameters());
        $this->assertSame($expects, $httpRequest->getMethod(), "Returned HttpRequest object won't use specified method.");
    }
    public function provideMethods()
    {
        $methods = array(
            HttpRequest::METH_GET  => false,
            HttpRequest::METH_POST => true,
        );
        $provides = array();
        foreach ($methods as $methods => $isPost) {
            $configuration = $this->getMockOfConfiguration();
            $configuration->expects($this->once())
                ->method('toRequiredQueryData')
                ->will($this->returnValue(array()));
            $configuration->expects($this->once())
                ->method('isMethodPOST')
                ->will($this->returnValue($isPost));
            $provides[] = array($configuration, $methods);
        }
        return $provides;
    }

    /**
     * A HTTP request object to which a Service parameter was set will be returned.
     */
    public function testContainsAServiceParameterInTheQueryString()
    {
        $configuration = $this->getMockOfConfiguration();
        $configuration->expects($this->once())
            ->method('toRequiredQueryData')
            ->will($this->returnValue($this->requiredQueryData));
        $httpRequest = $this->builder
            ->setConfiguration($configuration)
            ->build($this->getMockOfRequestWhichReturnsEmptyArrayAtGetParameters());
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

    /**
     * A HTTP request object to which An URL was set will be returned.
     *
     * @dataProvider provideURLSettings
     */
    public function testAHttpRequestObjectToWhichAnURLWasSetWillBeReturned($configuration, $expectUrl)
    {
        $httpRequest = $this->builder
            ->setConfiguration($configuration)
            ->build($this->getMockOfRequestWhichReturnsEmptyArrayAtGetParameters());
        $this->assertContains($expectUrl, $httpRequest->getUrl(), "The URL wasn't set");
    }
    public function provideURLSettings()
    {
        $provides = array();
        foreach ($this->endpoints as $endpoint) {
            foreach (array(true, false) as $isSecure) {
                $configuration = $this->getMockOfConfigurationWhichReturnsEmptyArrayAtToRequiredQueryData();
                $configuration->expects($this->once())
                    ->method('isSecure')
                    ->will($this->returnValue($isSecure));
                $configuration->expects($this->once())
                    ->method('getEndPoint')
                    ->will($this->returnValue($endpoint));
                $configuration->expects($this->once())
                    ->method('getRequestURI')
                    ->will($this->returnValue('/onca/xml'));
                $provides[] = array($configuration, sprintf('%s://%s/onca/xml', ($isSecure ? 'https' : 'http'), $endpoint));
            }
        }
        return $provides;
    }

    /**
     * A HTTP request object to which an Operation parameter array was set will be returned.
     */
    public function testContainsAnOperationParameterInTheQueryString()
    {
        $request = $this->getMockOfRequest();
        $request->expects($this->once())
            ->method('getParameters')
            ->will($this->returnValue($this->operationParameters));
        $httpRequest = $this->builder
            ->setConfiguration($this->getMockOfConfigurationWhichReturnsEmptyArrayAtToRequiredQueryData())
            ->build($request);
        $this->assertContains('Operation=DummyOperation', $httpRequest->getQueryData(), "The operation parameter wasn't set");

        return $httpRequest;
    }

    /**
     * Contains an request parameter in the query string
     *
     * @depends testContainsAnOperationParameterInTheQueryString
     */
    public function testContainsAnRequestParameterInTheQueryString(HttpRequest $httpRequest)
    {
        $this->assertContains('Foo=Bar', $httpRequest->getQueryData(), "The request parameter wasn't set");
    }

    private function getMockOfConfiguration()
    {
        return $this->getMock('Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configurable');
    }

    private function getMockOfConfigurationWhichReturnsEmptyArrayAtToRequiredQueryData()
    {
        $configuration = $this->getMockOfConfiguration();
        $configuration->expects($this->once())
            ->method('toRequiredQueryData')
            ->will($this->returnValue(array()));
        return $configuration;
    }

    private function getMockOfGenerator()
    {
        return $this->getMock('Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Generatable');
    }

    private function getMockOfRequest()
    {
        return $this->getMock('Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Requestable');
    }

    private function getMockOfRequestWhichReturnsEmptyArrayAtGetParameters()
    {
        $request = $this->getMockOfRequest();
        $request->expects($this->once())
            ->method('getParameters')
            ->will($this->returnValue(array()));
        return $request;
    }
}
