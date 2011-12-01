<?php
/**
* This test file is a part of SinyAmazonProductAdvertisingAPIBundle package.
*
* @author Shinichiro Yuki <sinycourage@gmail.com>
*/

namespace Siny\Amazon\ProductAdvertisingAPIBundle\Tests\API\Request;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configurable;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configuration;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    const AWS_ACCESS_KEY_ID = 'AWS_ACCESS_KEY_ID';
    const SECRET_ACCESS_KEY = 'SECRET_ACCESS_KEY';
    const ASSOCIATE_TAG     = 'ASSOCIATE_TAG';
    const END_POINT         = 'ecs.amazonaws.jp';

    private $configuration;

    public function setUp()
    {
        $this->configuration = new Configuration(self::AWS_ACCESS_KEY_ID, self::SECRET_ACCESS_KEY, self::ASSOCIATE_TAG, self::END_POINT);
    }

    /**
     * Get Service in the case of default
     *
     * @dataProvider provideToArray
     */
    public function testToArrayIdInTheCaseOfDefault($expects)
    {
        $actual = $this->configuration->toArray();
        ksort($expects);
        ksort($actual);
        $this->assertSame($expects, $actual, "Parameters weren't same.");
    }
    public function provideToArray()
    {
        return array(
            array(
                array(
                    Configuration::KEY_SERVICE           => 'AWSECommerceService',
                    Configuration::KEY_AWS_ACCESS_KEY_ID => self::AWS_ACCESS_KEY_ID,
                    Configuration::KEY_SECRET_ACCESS_KEY => self::SECRET_ACCESS_KEY,
                    Configuration::KEY_ASSOCIATE_TAG     => self::ASSOCIATE_TAG,
                    Configuration::KEY_ENDPOINT          => self::END_POINT,
                    Configuration::KEY_VERSION           => '2010-09-01',
                    Configuration::KEY_REQUEST_URI       => '/onca/xml',
                )
            )
        );
    }

    /**
     * to required query data.
     */
    public function testToRequiredQueryData()
    {
        $this->assertSame(array(
            'Service'        => 'AWSECommerceService',
            'Version'        => '2010-09-01',
            'AWSAccessKeyId' => self::AWS_ACCESS_KEY_ID,
            'AssociateTag'   => self::ASSOCIATE_TAG,
        ), $this->configuration->toRequiredQueryData(), "The required query data weren't same.");
    }

    /**
     * Self object will be returned when invoking setOption()
     *
     * @dataProvider provideSetOption
     */
    public function testSelfObjectWillBeRetunedWhenInvokingSetOption($key, $value)
    {
        $this->assertInstanceOf(
        	'Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configuration',
            $this->configuration->setOption($key, $value),
        	"A self object wasn't returned when invoking setOption().");
    }

    /**
     * Set option
     *
     * @dataProvider provideSetOption
     * @param string $key
     * @param mixed $value
     */
    public function testSetOption($key, $value)
    {
        $this->configuration->setOption($key, $value);
        $parameters = $this->configuration->toArray();
        $this->assertSame($parameters[$key], $value, "There wasn't the specified parameter.");
    }

    public function provideSetOption()
    {
        return array(
            array('foo', 'bar'),
        );
    }
}
