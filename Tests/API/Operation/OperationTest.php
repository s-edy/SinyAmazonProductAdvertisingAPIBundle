<?php
/**
* This file is a part of Siny\Amazon\ProductAdvertisingAPIBundle package.
*
* (c) Shinichiro Yuki <edy@siny.jp>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Siny\Amazon\ProductAdvertisingAPIBundle\Tests\API;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation\OperationInterface;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation\Operation;
use \ReflectionMethod;

class OperationTest extends \PHPUnit_Framework_TestCase
{
    const OPERATION_CLASS       = 'Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation\Operation';
    const DUMMY_PARAMETER_KEY   = 'DummyKey';
    const DUMMY_PARAMETER_VALUE = 'DummyValue';

    private $dummyParameters = array(
        self::DUMMY_PARAMETER_KEY => self::DUMMY_PARAMETER_VALUE
    );

    private $operation;

    public function setUp()
    {
        $this->operation = $this->getMockForAbstractClass(self::OPERATION_CLASS, array($this->dummyParameters));
    }

    /**
     * Get parameters in the case of default
     */
    public function testToArrayInTheCaseOfDefault()
    {
        $this->assertSame($this->dummyParameters, $this->operation->toArray(), "The parameters waren't same.");
    }

    /**
     * Add parameters
     *
     * @dataProvider provideFromArray
     */
    public function testFromArray($parameters, $expects)
    {
        $this->operation->fromArray($parameters);
        $this->assertSame($expects, $this->operation->toArray(), "Parameters waren't add dummy parameters");
    }
    public function provideFromArray()
    {
        $addParameters = array('foo' => 'bar');
        return array(
            array($addParameters, array_merge($this->dummyParameters, $addParameters)),
        );
    }

    /**
     * Ignoring at addParameters() in the case of the key is "Operation".
     */
    public function testIgnoringOperationAtFromArray()
    {
        $this->operation->fromArray(array(OperationInterface::KEY_OPERATION => 'DummyOperation'));
        $this->assertSame($this->dummyParameters, $this->operation->toArray(), "The 'Operation' parameters wasn't ignored.");
    }

    /**
     * Set a parameters
     *
     * @dataProvider provideSet
     */
    public function testSet($replaced, $expects)
    {
        $method = new ReflectionMethod(self::OPERATION_CLASS, 'set');
        $method->setAccessible(true);
        $method->invoke($this->operation, self::DUMMY_PARAMETER_KEY, $replaced);
        $this->assertSame($expects, $this->operation->toArray(), "The parameters waren't set dummy parameters");
    }
    public function provideSet()
    {
        $replaced = 'replaced';
        $expects = $this->dummyParameters;
        $expects[self::DUMMY_PARAMETER_KEY] = $replaced;
        return array(
            array($replaced, $expects),
        );
    }

    /**
     * Get a parameter of specified key
     */
    public function testGet()
    {
        $method = new ReflectionMethod(self::OPERATION_CLASS, 'get');
        $method->setAccessible(true);
        $this->assertSame(self::DUMMY_PARAMETER_VALUE, $method->invoke($this->operation, self::DUMMY_PARAMETER_KEY), "The parameters wasn't same");
    }

    /**
     * Has the parameter of specified key
     */
    public function testHas()
    {
        $method = new ReflectionMethod(self::OPERATION_CLASS, 'has');
        $method->setAccessible(true);
        $this->assertTrue($method->invoke($this->operation, self::DUMMY_PARAMETER_KEY), "Had not a parameter of specified key.");
        $this->assertFalse($method->invoke($this->operation, 'haveNotKey'), "Had the a parameter of specified key.");
    }

    /**
     * An exception will occur if the parameter which I tried to get doesn't exist.
     *
     * @expectedException Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation\Exception\OperationException
     * @expectedExceptionMessage The parameter of specified key was not found. key=[FailedKey]
     */
    public function testAnExceptionWillOccurIfTheParameterWhichITriedToGetDoesNotExist()
    {
        $method = new ReflectionMethod(self::OPERATION_CLASS, 'get');
        $method->setAccessible(true);
        $method->invoke($this->operation, 'FailedKey');
    }

    /**
     * Get operation name
     */
    public function testGetOperationName()
    {
        $operationName = 'DummyOperation';
        $method = new ReflectionMethod(self::OPERATION_CLASS, 'set');
        $method->setAccessible(true);
        $method->invoke($this->operation, OperationInterface::KEY_OPERATION, $operationName);
        $this->assertSame($operationName, $this->operation->getOperationName(), "The retuend an operation name wasn't same.");
        return $this->operation;
    }

    /**
     * Get Parameters
     *
     * @depends testGetOperationName
     */
    public function testGetParameters(Operation $operation)
    {
        $this->assertSame($this->dummyParameters, $operation->getParameters(), "The returned parameters waren't same.");
    }
}
