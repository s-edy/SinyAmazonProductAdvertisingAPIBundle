<?php
/**
* This test file is a part of SinyAmazonProductAdvertisingAPIBundle package.
*
* @author Shinichiro Yuki <sinycourage@gmail.com>
*/

namespace Siny\Amazon\ProductAdvertisingAPIBundle\Tests\API\Request;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Generator;

class GeneratorTest extends \PHPUnit_Framework_TestCase
{
    private $generator;

    public function setUp()
    {
        $this->generator = new Generator();
    }

    /**
     * Generate signature
     */
    public function testGenerateSignatureReturnsString()
    {
        $configuration = $this->getMock('Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configurable');
        $request       = $this->getMock('Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Requestable');
        $this->assertInternalType(
            'string', $this->generator->generateSignature($configuration, $request),
            "Self object will be returned when invoking setConfiguration().");
    }
}
