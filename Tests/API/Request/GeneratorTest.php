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

class GeneratorTest extends \PHPUnit_Framework_TestCase
{
    private $dateTime;
    private $generator;

    public function setUp()
    {
        $this->dateTime = new DateTime();
        $this->dateTime->setTimestamp(1323187197);

        $this->generator = $this->getMock('Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Generator', array('getDateTime'));
        $this->generator
            ->expects($this->any())
            ->method('getDateTime')
            ->will($this->returnValue($this->dateTime));
    }

    /**
     * GetDateTime
     */
    public function testGetDateTime()
    {
        $generator = new Generator();
        $dateTime = $generator->getDateTime();
        $this->assertInstanceOf('DateTime', $dateTime, "The DateTime object wasn't same");
        return $dateTime;
    }

    /**
     * GetDateTime is now time in the case of time
     *
     * @depends testGetDateTime
     */
    public function testGetDateTimeIsNowTimeInTheCaseOfDefault(DateTime $dateTime)
    {
        $this->assertLessThanOrEqual(1, abs(time() - $dateTime->getTimestamp()), "The unix timestamp wasn't same.");
    }

    /**
     * GenerateCanonicalString
     *
     * @dataProvider provideGenerateSignature
     */
    public function testGenerateCanonicalString($configuration, $request)
    {
        $method = new \ReflectionMethod(
            'Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Generator', 'generateCanonicalString');
        $method->setAccessible(true);
        $canonicalString = $method->invoke($this->generator, $configuration, $request);
        $this->assertSame(
            'Timestamp=2011-12-06T15%3A59%3A57%2B0000&configuration=foo&request=bar',
            $canonicalString,
            "The canonical string wasn't same.");
    }

    /**
     * GenerateSignature returns string
     *
     * @dataProvider provideGenerateSignature
     */
    public function testGenerateSignatureReturnsString($configuration, $request)
    {
        $signature = $this->generator->generateSignature($configuration, $request);
        $this->assertInternalType('string', $signature, "Self object will be returned when invoking setConfiguration().");
    }

    /**
     * GenerateSignature returns signature
     *
     * @dataProvider provideGenerateSignature
     */
    public function testGenerateSignature($configuration, $request)
    {
        $this->assertSame(
            'lEBP1qx%2FGTxHJ1PIJFjeVxoVN7uafgmQplD0txwppPI%3D',
            $this->generator->generateSignature($configuration, $request),
            "Returned signature is incorrect.");
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
