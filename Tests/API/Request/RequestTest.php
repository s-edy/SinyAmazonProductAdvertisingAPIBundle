<?php
/**
* This file is a part of Siny\Amazon\ProductAdvertisingAPIBundle package.
*
* (c) Shinichiro Yuki <edy@siny.jp>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
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
            'Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation\Operation',
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
        $operation = $this->getMockOfOperation($parameters);
        $request = $this->createNewRequest($operation);
        $this->assertSame($parameters, $request->getParameters(), "Returned parameters waren't same.");
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

    private function getMockOfOperation(array $parameters = array())
    {
        $operation = $this->getMockForAbstractClass('Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation\Operation');
        $operation->fromArray($parameters);
        return $operation;
    }
}
