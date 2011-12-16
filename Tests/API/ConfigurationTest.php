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

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Configuration;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    const DUMMY_KEY   = 'dummyKey';
    const DUMMY_VALUE = 'dummyValue';

    private $configuration;
    private $dateTime;
    private $parameters = array(self::DUMMY_KEY => self::DUMMY_VALUE);

    public function setUp()
    {
        $this->configuration = $this->getMockForAbstractClass('Siny\Amazon\ProductAdvertisingAPIBundle\API\Configuration');
    }

    /**
     * Self object will be returned when invoking from array
     */
    public function testSelfObjectWillBeReturnedWhenInvokingFromArray()
    {
        $this->assertInstanceOf(
        	'Siny\Amazon\ProductAdvertisingAPIBundle\API\Configuration',
            $this->configuration->fromArray($this->parameters),
        	"A self object wasn't returned when invoking fromArray().");
        return $this->configuration;
    }

    /**
     * Returns array type when invoking toArray()
     */
    public function testReturnsArrayTypeWhenInvokingToArray()
    {
        $this->assertInternalType('array', $this->configuration->toArray(), "The returns wasn't array.");
    }

    /**
     * Returns empty array when invoking toArray() in the case of default
     */
    public function testReturnsEmptyArrayWhenInvokingToArrayInTheCaseOfDefault()
    {
        $this->assertEmpty($this->configuration->toArray(), "There weren't parameters.");
    }

    /**
     * Returns array when invoking toArray after invoking fromArray().
     *
     * @depends testSelfObjectWillBeReturnedWhenInvokingFromArray
     */
    public function testReturnsArrayWhenInvokingToArrayAfterInvokingFromArray(Configuration $configuration)
    {
        $this->assertSame($this->parameters, $configuration->toArray(), "Returned parameters waren't same.");
    }

    /**
     * Returns merged array when invoking toArray after invoking fromArray().
     *
     * @depends testSelfObjectWillBeReturnedWhenInvokingFromArray
     */
    public function testReturnsMergedArrayWhenInvokingToArrayAfterInvokingFromArray(Configuration $configuration)
    {
        $addition = array('foo' => 'bar');
        $before   = $configuration->toArray();
        $expected = array_merge($before, $addition);
        $this->assertSame($expected, $configuration->fromArray($addition)->toArray(), "Did not returned merged array");
    }

    /**
     * A configuration object will be returned when invoking set()
     */
    public function testSelfObjectWillBeReturnedWhenInvokingSet()
    {
        $method = new \ReflectionMethod('Siny\Amazon\ProductAdvertisingAPIBundle\API\Configuration', 'set');
        $method->setAccessible(true);
        $this->assertInstanceOf(
        	'Siny\Amazon\ProductAdvertisingAPIBundle\API\Configuration',
        	$method->invoke($this->configuration, self::DUMMY_KEY, self::DUMMY_VALUE),
        	"A self object wasn't returned when invoking set().");
        return $this->configuration;
    }

    /**
     * Get parameter
     *
     * @depends testSelfObjectWillBeReturnedWhenInvokingSet
     * @param Configuration $configuration
     */
    public function testGet(Configuration $configuration)
    {
        $method = new \ReflectionMethod('Siny\Amazon\ProductAdvertisingAPIBundle\API\Configuration', 'get');
        $method->setAccessible(true);
        $this->assertSame(
            self::DUMMY_VALUE, $method->invoke($configuration, self::DUMMY_KEY),
        	"Get value wasn't same.");
    }

    /**
     * Returns array when invoking toArray()
     *
     * @depends testSelfObjectWillBeReturnedWhenInvokingSet
     * @param Configuration $configuration
     */
    public function testReturnArrayWhenInvokingToArray(Configuration $configuration)
    {
        $this->assertSame(
            array(self::DUMMY_KEY => self::DUMMY_VALUE),
            $configuration->toArray(),
        	"Parameters which was set wasn't returned.");
    }

    /**
     * An exception will occur if trying to get when specifying a wrong key
     *
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage The value of speficied key index was not found. key=[dummyKey]
     */
    public function testAnExceptionWillOccurIfTryingToGetWhenSpecifyingAWrongKey()
    {
        $method = new \ReflectionMethod('Siny\Amazon\ProductAdvertisingAPIBundle\API\Configuration', 'get');
        $method->setAccessible(true);
        $method->invoke($this->configuration, self::DUMMY_KEY);
    }

    /**
     * Has the parameter which is specified key
     *
     * @depends testSelfObjectWillBeReturnedWhenInvokingSet
     */
    public function testHasTheParameterWhichIsSpecifiedKey(Configuration $configuration)
    {
        $method = new \ReflectionMethod('Siny\Amazon\ProductAdvertisingAPIBundle\API\Configuration', 'has');
        $method->setAccessible(true);
        $this->assertTrue($method->invoke($configuration, self::DUMMY_KEY), "Has not parameter.");
    }

    /**
     * Has not the parameter which is specified a wrong key
     *
     * @param Configuration $configuration
     */
    public function testHasNotTheParameterWhichIsSpecifiedAWrongKey()
    {
        $method = new \ReflectionMethod('Siny\Amazon\ProductAdvertisingAPIBundle\API\Configuration', 'has');
        $method->setAccessible(true);
        $this->assertFalse($method->invoke($this->configuration, 'wrong'), "The parameter has.");
    }
}
