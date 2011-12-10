<?php
/**
* This test file is a part of SinyAmazonProductAdvertisingAPIBundle package.
*
* @author Shinichiro Yuki <sinycourage@gmail.com>
*/

namespace Siny\Amazon\ProductAdvertisingAPIBundle\Tests\API\Request;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Generator;
use \DateTime;
use \DateTimeZone;
use \ReflectionMethod;

class GeneratorTest extends \PHPUnit_Framework_TestCase
{
    const GENERATOR_CLASS = 'Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Generator';
    private $generator;

    public function setUp()
    {
        $dateTime = new DateTime();
        $timestamp = $dateTime->setTimestamp(1323187197)
            ->setTimezone(new DateTimeZone('GMT'))
            ->format(DateTime::ISO8601);

        $this->generator = $this->getMock(self::GENERATOR_CLASS, array('getTimestamp'));
        $this->generator
            ->expects($this->any())
            ->method('getTimestamp')
            ->will($this->returnValue('2011-12-06T15:59:57+0000'));
    }

    /**
     * Generate parameters
     *
     * @dataProvider provideGenerateSignature
     */
    public function testGenerateParameters($configuration, $requst)
    {
        $this->assertSame(array(
            'Timestamp' => '2011-12-06T15:59:57+0000',
            'Signature' => 'lEBP1qx/GTxHJ1PIJFjeVxoVN7uafgmQplD0txwppPI=',
        ), $this->generator->generateParameters($configuration, $requst), "The generated parameters waren't same.");
    }

    /**
     * GetTimestamp is now time in the case of time
     */
    public function testGetTimestampIsNowTimeInTheCaseOfDefault()
    {
        $generator = new Generator();
        $actual = strToTime($generator->getTimestamp());
        $datetime = new DateTime();
        $expected = $datetime->setTimezone(new DateTimeZone('GMT'))->getTimestamp();
        $this->assertLessThanOrEqual(2, abs($actual - $expected), "The unix timestamp wasn't same.");
    }

    /**
     * GenerateCanonicalString
     *
     * @dataProvider provideGenerateSignature
     */
    public function testGenerateCanonicalString($configuration, $request)
    {
        $method = new ReflectionMethod(self::GENERATOR_CLASS, 'generateCanonicalString');
        $method->setAccessible(true);
        $canonicalString = $method->invoke($this->generator, $configuration, $request, $this->generator->getTimestamp());
        $this->assertSame(
            'Timestamp=2011-12-06T15%3A59%3A57%2B0000&configuration=foo&request=bar',
            $canonicalString,
            "The canonical string wasn't same.");
    }

    /**
     * GenerateSignature returns signature
     *
     * @dataProvider provideGenerateSignature
     */
    public function testGenerateSignature($configuration, $request)
    {
        $method = new ReflectionMethod(self::GENERATOR_CLASS, 'generateSignature');
        $method->setAccessible(true);
        $signature = $method->invoke($this->generator, $configuration, $request, $this->generator->getTimestamp());
        $this->assertSame(
            'lEBP1qx/GTxHJ1PIJFjeVxoVN7uafgmQplD0txwppPI=',
            $signature, "Returned signature is incorrect.");
    }

    public function provideGenerateSignature()
    {
        $configuration = $this->getMock('Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configurable');
        $configuration->expects($this->any())
            ->method('toRequiredQueryData')
            ->will($this->returnValue(array('configuration' => 'foo')));

        $request = $this->getMock('Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Requestable');
        $request->expects($this->any())
            ->method('getParameters')
            ->will($this->returnValue(array('request' => 'bar')));

        return array(array($configuration, $request));
    }
}
