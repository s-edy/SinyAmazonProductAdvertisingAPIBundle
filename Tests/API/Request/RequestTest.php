<?php
/**
* This test file is a part of SinyAmazonProductAdvertisingAPIBundle package.
*
* @author Shinichiro Yuki <sinycourage@gmail.com>
*/

namespace Siny\Amazon\ProductAdvertisingAPIBundle\Tests\API\Request;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Request;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    private $request;

    public function setUp()
    {
        $this->request = $this->createNewRequest();
    }

    /**
     * Returns a class instance which extended an abstract operation class instance when invoking getOperation()
     */
    public function testReturnsAClassWhichExtendedAnAbstractOperationClassInstanceWhenInvokingGetOperation()
    {
        $this->assertInstanceOf(
            'Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation',
            $this->request->getOperation(),
            "A returned class wasn't class instance that extend an abstract operation class.");
    }

    /**
     * Returns an Operation class instance which was set when invoking getOperation()
     */
    public function testReturnsAnOperationClassInstanceWhichWasWhenInvokingGetOperation()
    {
        $request   = $this->createNewRequest();
        $operation = $this->getMockOfOperation();
        $request->setOperation($operation);
        $this->assertSame($operation, $request->getOperation(), "A returned class wasn't same class instance.");
    }

    /**
     * Get parameters
     *
     * @dataProvider provideParameters
     */
    public function testGetParameters($parameters)
    {
        $operation = $this->getMockOfOperation();
        $operation->setParameters($parameters);
        $request = $this->createNewRequest($operation);

        $this->assertSame(
            array_merge(array('Operation' => 'DummyOperation'), $parameters),
            $request->getParameters(),
            "Returned parameters waren't same.");
    }
    public function provideParameters()
    {
        return array(array(array('foo' => 'bar', 'fizz' => 'buzz')));
    }

    private function createNewRequest($operation = null)
    {
        if (is_null($operation)) {
            $operation = $this->getMockOfOperation();
        }
        return new Request($operation);
    }

    private function getMockOfOperation()
    {
        $operation = $this->getMockForAbstractClass(
            'Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation',
            array('DummyOperation'));
        $operation->expects($this->any())
            ->method('getOperationName')
            ->will($this->returnCallback('DummyOperation'));
        return $operation;
    }
}
