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
    const DUMMY_AWS_ACCESS_KEY_ID = 'dummy_aws_access_key_id';
    const DUMMY_SECRET_ACCESS_KEY = 'dummy_secret_access_key';
    const DUMMY_ASSOCIATE_TAG     = 'dummy_associate_tag';

    private $generator;

    public function setUp()
    {
        $this->generator = $this->getMockForAbstractClass(
            'Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Generator',
            array(
                self::DUMMY_AWS_ACCESS_KEY_ID,
                self::DUMMY_SECRET_ACCESS_KEY,
                self::DUMMY_ASSOCIATE_TAG,
                Generator::LOCALE_JP,
            )
        );
    }

    /**
     * get AWS Access key ID in the case of default
     */
    public function testGetAwsAccessKeyIdInTheCaseOfDefault()
    {
        $this->assertSame(
            self::DUMMY_AWS_ACCESS_KEY_ID, $this->generator->getAwsAccessKeyId(),
            "AWS access key ID wasn't same.");
    }

    /**
     * get Secret Access key in the case of default
     */
    public function testGetSecretAccessKeyInTheCaseOfDefault()
    {
        $this->assertSame(
            self::DUMMY_SECRET_ACCESS_KEY, $this->generator->getSecretAccessKey(),
            "Secret access key wasn't same.");
    }

    /**
     * get Associate tag in the case of default
     */
    public function testGetAssociateTagInTheCaseOfDefault()
    {
        $this->assertSame(
            self::DUMMY_ASSOCIATE_TAG, $this->generator->getAssociateTag(),
            "Associate tag wasn't same.");
    }

    /**
     * get Locale in the case of default
     */
    public function testGetLocaleInTheCaseOfDefault()
    {
        $this->assertSame(
            Generator::LOCALE_JP, $this->generator->getLocale(),
            "Locale wasn't same.");
    }

    /**
     * set locale
     *
     * @dataProvider provideLocales
     *
     * @param string $locale
     */
    public function testSetLocale($locale)
    {
        $this->generator->setLocale($locale);
        $this->assertSame(
            $locale, $this->generator->getLocale(),
            "a specified locale wasn't same.");
    }

    public function provideLocales()
    {
        return array(
            array(Generator::LOCALE_CA),
            array(Generator::LOCALE_CN),
            array(Generator::LOCALE_DE),
            array(Generator::LOCALE_ES),
            array(Generator::LOCALE_FR),
            array(Generator::LOCALE_IT),
            array(Generator::LOCALE_JP),
            array(Generator::LOCALE_UK),
            array(Generator::LOCALE_US),
        );
    }

    /**
     * exception occur if the wrong locale is set
     *
     * @expectedException Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Exception\RequestException
     * @expectedExceptionMessage A specified locale was wrong. locale=[wrong]
     */
    public function testExceptionOccurIfTheWrongLocaleIsSet()
    {
        $this->generator->setLocale('wrong');
    }

    /**
     * get DateTime in the case of default
     */
    public function testGetDateTimeInTheCaseOfDefault()
    {
        $this->assertInstanceOf(
    		'\DateTime', $this->generator->getDateTime(),
    		"A date time class wan't get");
    }

    /**
     * set/get DateTime
     */
    public function testSetGetDateTime()
    {
        $dateTime = new \DateTime();
        $this->generator->setDateTime($dateTime);
        $this->assertSame(
            $dateTime->format(\DateTime::ISO8601),
            $this->generator->getDateTime()->format(\DateTime::ISO8601),
            "A date time class wasn't same.");
    }

    /**
     * is secure request in the case of default
     */
    public function testIsSecureRequestInTheCaseOfDefault()
    {
        $this->assertFalse(
            $this->generator->isSecureRequest(), "The default value isn't secure.");
    }

    /**
     * set secure request
     */
    public function testSetSecureRequest()
    {
        $this->generator->setSecureRequest();
        $this->assertTrue(
            $this->generator->isSecureRequest(), "Did not secure request.");

        return $this->generator;
    }

    /**
     * reset secure request
     *
     * @depends testSetSecureRequest
     */
    public function testResetSecureRequest(Generator $generator)
    {
        $generator->resetSecureRequest();
        $this->assertFalse(
            $generator->isSecureRequest(), "This is secure request.");
    }

    /**
     * get request method in the case of default.
     */
    public function testGetRequestMethodInTheCaseOfDefault()
    {
        $this->assertSame(
            Generator::METHOD_GET, $this->generator->getRequestMethod(),
            "A request method wasn't GET in the case of default.");
    }

    /**
     * set POST request method
     */
    public function testSetPOSTRequestMethod()
    {
        $this->generator->setPOSTRequestMethod();
        $this->assertSame(
            Generator::METHOD_POST, $this->generator->getRequestMethod(),
            "A request method wasn't set POST.");

        return $this->generator;
    }

    /**
     * set GET request method
     *
     * @depends testSetPOSTRequestMethod
     *
     * @param AbstractMethod $generator
     */
    public function testSetGETRequestMethod(Generator $generator)
    {
        $generator->setGETRequestMethod();
        $this->assertSame(
            Generator::METHOD_GET, $generator->getRequestMethod(),
                    "A request method wasn't set GET.");
    }

    /**
     * test generate canonical query string
     *
     * @dataProvider provideParameters
     */
    public function testGenerateCanonicalQueryString($parameters, $expect)
    {
        $this->assertSame(
            $expect, $this->generator->generateCanonicalQueryString($parameters),
            "Did not generate canonical string correctly.");
    }

    public function provideParameters()
    {
        return array(
            array(
                array(
                    'foo'  => 'bar',
                    'fizz' => 'buzz',
                    '@*?&' => '$#^/',
                ),
                '%40%2A%3F%26=%24%23%5E%2F&fizz=buzz&foo=bar',
            ),
        );
    }

    /**
     * generate signature
     *
     * @dataProvider provideParameterForSignature
     * @param string $requestMethod
     * @param string $endPoint
     * @param string $canonicalQueryString
     */
    public function testGenerateSignature(
        $requestMethod, $endPoint, $canonicalQueryString, $expect)
    {
        $this->assertSame(
            $expect,
            $this->generator->generateSignature(
                $requestMethod, $endPoint, $canonicalQueryString),
            "The generated signature wasn't same.");
    }

    public function provideParameterForSignature()
    {
        return array(
            array(
                'GET',
                'dummy.end.point.com',
                'dummyCanonicalQueryString',
                'jXgbOqARlG%2F0veVGlVSACAVMqmcxrwL6ejFRmvT%2BGKE%3D',
            ),
        );
    }

    /**
     * get end point
     *
     * @dataProvider provideEndPoints
     *
     * @param string $locale
     * @param string $expectEndPoint
     */
    public function testGetEndPoint($locale, $expectEndPoint)
    {
        $this->generator->setLocale($locale);
        $this->assertSame(
            $expectEndPoint, $this->generator->getEndPoint(), "The end point wasn't same.");
    }

    public function provideEndPoints()
    {
        return array(
            array(Generator::LOCALE_CA, Generator::ENDPOINT_CA),
            array(Generator::LOCALE_CN, Generator::ENDPOINT_CN),
            array(Generator::LOCALE_DE, Generator::ENDPOINT_DE),
            array(Generator::LOCALE_ES, Generator::ENDPOINT_ES),
            array(Generator::LOCALE_FR, Generator::ENDPOINT_FR),
            array(Generator::LOCALE_IT, Generator::ENDPOINT_IT),
            array(Generator::LOCALE_JP, Generator::ENDPOINT_JP),
            array(Generator::LOCALE_UK, Generator::ENDPOINT_UK),
            array(Generator::LOCALE_US, Generator::ENDPOINT_US),
        );
    }
}
