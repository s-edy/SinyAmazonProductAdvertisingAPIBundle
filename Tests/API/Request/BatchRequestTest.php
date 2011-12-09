<?php
/**
* This test file is a part of SinyAmazonProductAdvertisingAPIBundle package.
*
* @author Shinichiro Yuki <sinycourage@gmail.com>
*/

namespace Siny\Amazon\ProductAdvertisingAPIBundle\Tests\API\Request;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\BatchRequest;
use \ReflectionMethod;

class BatchRequestTest extends \PHPUnit_Framework_TestCase
{
    const DUMMY_OPERATION = 'DummyOperation';

    private $operation1parameters = array('commonKey' => 'commonValue', 'foo' => 'one', 'fizz' => 'oneFizz');
    private $operation2parameters = array('commonKey' => 'commonValue', 'foo' => 'two', 'bazz' => 'twoBazz');

    private $request;

    public function setUp()
    {
        $this->request = new BatchRequest(array(
            $this->getMockOfOperation($this->operation1parameters),
            $this->getMockOfOperation($this->operation2parameters),
        ));
    }

    /**
     * An exception will occur if empty array is given when constructing
     *
     * @expectedException Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Exception\RequestException
     * @expectedExceptionMessage There are no Operation class instances
     */
    public function testAnExceptionWillOccurIfEmptyArrayIsGivenWhenConstructing()
    {
        new BatchRequest(array());
    }

    /**
     * An exception will occur if invalid arguments are given when constructing
     *
     * @expectedException Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Exception\RequestException
     * @expectedExceptionMessage Allow a class instance only which implemented 'OperationInterface'
     */
    public function testAnExceptionWillOccurIfInvalidArgumentsAreGivenWhenConstructing()
    {
        new BatchRequest(array('Fail'));
    }

    /**
     * Returns Parameters with shared key
     *
     * @dataProvider provideReturnsConvertedParameters
     */
    public function testReturnsParametersWithSharedKey($expects)
    {
        $parameters = $this->request->getParameters();
        ksort($expects);
        ksort($parameters);
        $this->assertSame($expects, $parameters, "The returned parameters without the shared parameter.");
    }

    /**
     * Returns an Operation name
     */
    public function testReturnsOperationName()
    {
        $method = new ReflectionMethod('Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\BatchRequest', 'extractOperationName');
        $method->setAccessible(true);
        $this->assertSame(self::DUMMY_OPERATION, $method->invoke($this->request), "The returned an Operation name wasn't same.");
    }

    /**
     * Returns shared parameters
     */
    public function testReturnsSharedParameters()
    {
        $method = new ReflectionMethod('Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\BatchRequest', 'extractSharedParameters');
        $method->setAccessible(true);
        $this->assertSame(array('commonKey' => 'commonValue'), $method->invoke($this->request), "The returned shared parameters ware incorrect.");
    }

    /**
    * Returns generated parameters
    *
    * @dataProvider provideReturnsConvertedParameters
     */
    public function testReturnsConvertedParameters($expects)
    {
        $method = new ReflectionMethod('Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\BatchRequest', 'convertParameter');
        $method->setAccessible(true);
        $parameters = $method->invoke($this->request, self::DUMMY_OPERATION, array('commonKey' => 'commonValue'));
        ksort($parameters);
        ksort($expects);
        $this->assertSame($expects, $parameters, "The returned converted parameters ware incorrect.");
    }

    public function provideReturnsConvertedParameters()
    {
        return array(
            array(array(
                'Operation' => self::DUMMY_OPERATION,
                self::DUMMY_OPERATION . '.Shared.commonKey' => 'commonValue',
                self::DUMMY_OPERATION . '.1.foo' => 'one',
                self::DUMMY_OPERATION . '.1.fizz' => 'oneFizz',
                self::DUMMY_OPERATION . '.2.foo' => 'two',
                self::DUMMY_OPERATION . '.2.bazz' => 'twoBazz',
            )),
        );
    }

    private function getMockOfOperation(array $parameters = array())
    {
        $operation = $this->getMockForAbstractClass('Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation\Operation');
        $operation->fromArray($parameters);

        $method = new ReflectionMethod('Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation\Operation', 'set');
        $method->setAccessible(true);
        $method->invoke($operation, 'Operation', self::DUMMY_OPERATION);

        return $operation;
    }
}
