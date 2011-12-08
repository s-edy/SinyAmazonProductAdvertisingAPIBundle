<?php
/**
* This test file is a part of SinyAmazonProductAdvertisingAPIBundle package.
*
* @author Shinichiro Yuki <sinycourage@gmail.com>
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
    public function testGetParametersInTheCaseOfDefault()
    {
        $this->assertSame($this->dummyParameters, $this->invokeGetParameters($this->operation), "The parameters waren't same.");
    }

    /**
     * Add parameters
     *
     * @dataProvider providerAddParameters
     */
    public function testAddParameters($parameters, $expects)
    {
        $this->operation->addParameters($parameters);
        $this->assertSame($expects, $this->invokeGetParameters($this->operation), "Parameters waren't add dummy parameters");
    }
    public function providerAddParameters()
    {
        $addParameters = array('foo' => 'bar');
        return array(
            array($addParameters, array_merge($this->dummyParameters, $addParameters)),
        );
    }

    /**
     * Ignoring at addParameters() in the case of the key is "Operation".
     */
    public function testIgnoringOperationAtAddParameters()
    {
        $this->operation->addParameters(array(OperationInterface::KEY_OPERATION => 'DummyOperation'));
        $this->assertSame($this->dummyParameters, $this->invokeGetParameters($this->operation), "The 'Operation' parameters wasn't ignored.");
    }

    /**
     * Set a parameters
     *
     * @dataProvider providerSetParameter
     */
    public function testSetParameter($replaced, $expects)
    {
        $method = new ReflectionMethod(self::OPERATION_CLASS, 'setParameter');
        $method->setAccessible(true);
        $method->invoke($this->operation, self::DUMMY_PARAMETER_KEY, $replaced);
        $this->assertSame($expects, $this->invokeGetParameters($this->operation), "The parameters waren't set dummy parameters");
    }
    public function providerSetParameter()
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
    public function testGetParameter()
    {
        $method = new ReflectionMethod(self::OPERATION_CLASS, 'getParameter');
        $method->setAccessible(true);
        $this->assertSame(self::DUMMY_PARAMETER_VALUE, $method->invoke($this->operation, self::DUMMY_PARAMETER_KEY), "The parameters wasn't same");
    }

    /**
     * Has the parameter of specified key
     */
    public function testHasParameter()
    {
        $method = new ReflectionMethod(self::OPERATION_CLASS, 'hasParameter');
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
        $method = new ReflectionMethod(self::OPERATION_CLASS, 'getParameter');
        $method->setAccessible(true);
        $method->invoke($this->operation, 'FailedKey');
    }

    private function invokeGetParameters(Operation $operation)
    {
        $method = new ReflectionMethod(self::OPERATION_CLASS, 'getParameters');
        $method->setAccessible(true);
        return $method->invoke($operation);
    }
}
