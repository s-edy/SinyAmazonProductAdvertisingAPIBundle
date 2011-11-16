<?php
/**
* This test file is a part of SinyAmazonProductAdvertisingAPIBundle package.
*
* @author Shinichiro Yuki <sinycourage@gmail.com>
*/

namespace Siny\Amazon\ProductAdvertisingAPIBundle\Tests\API\Request;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Builder;

class BuilderTest extends \PHPUnit_Framework_TestCase
{
    const DUMMY_AWS_ACCESS_KEY_ID = 'dummy_aws_access_key_id';
    const DUMMY_SECRET_ACCESS_KEY = 'dummy_secret_access_key';
    const DUMMY_ASSOCIATE_TAG     = 'dummy_associate_tag';

    private $builder;

    public function setUp()
    {
        $this->builder = $this->getMockForAbstractClass(
            'Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Builder',
            array(
                self::DUMMY_AWS_ACCESS_KEY_ID,
                self::DUMMY_SECRET_ACCESS_KEY,
                self::DUMMY_ASSOCIATE_TAG,
                Builder::LOCALE_JP,
            )
        );
    }

    /**
     * get AWS Access key ID in the case of default
     */
    public function testGetAwsAccessKeyIdInTheCaseOfDefault()
    {
        $this->assertSame(
            self::DUMMY_AWS_ACCESS_KEY_ID, $this->builder->getAwsAccessKeyId(),
            "AWS access key ID wasn't same.");
    }

    /**
     * get Secret Access key in the case of default
     */
    public function testGetSecretAccessKeyInTheCaseOfDefault()
    {
        $this->assertSame(
            self::DUMMY_SECRET_ACCESS_KEY, $this->builder->getSecretAccessKey(),
            "Secret access key wasn't same.");
    }

    /**
     * get Associate tag in the case of default
     */
    public function testGetAssociateTagInTheCaseOfDefault()
    {
        $this->assertSame(
            self::DUMMY_ASSOCIATE_TAG, $this->builder->getAssociateTag(),
            "Associate tag wasn't same.");
    }

    /**
     * get Locale in the case of default
     */
    public function testGetLocaleInTheCaseOfDefault()
    {
        $this->assertSame(
            Builder::LOCALE_JP, $this->builder->getLocale(),
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
        $this->builder->setLocale($locale);
        $this->assertSame(
            $locale, $this->builder->getLocale(),
            "a specified locale wasn't same.");
    }

    public function provideLocales()
    {
        return array(
            array(Builder::LOCALE_CA),
            array(Builder::LOCALE_CN),
            array(Builder::LOCALE_DE),
            array(Builder::LOCALE_ES),
            array(Builder::LOCALE_FR),
            array(Builder::LOCALE_IT),
            array(Builder::LOCALE_JP),
            array(Builder::LOCALE_UK),
            array(Builder::LOCALE_US),
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
        $this->builder->setLocale('wrong');
    }

    /**
     * get DateTime in the case of default
     */
    public function testGetDateTimeInTheCaseOfDefault()
    {
        $this->assertInstanceOf(
    		'\DateTime', $this->builder->getDateTime(),
    		"A date time class wan't get");
    }

    /**
     * set/get DateTime
     */
    public function testSetGetDateTime()
    {
        $dateTime = new \DateTime();
        $this->builder->setDateTime($dateTime);
        $this->assertSame(
            $dateTime->format(\DateTime::ISO8601),
            $this->builder->getDateTime()->format(\DateTime::ISO8601),
            "A date time class wasn't same.");
    }

    /**
     * is secure request in the case of default
     */
    public function testIsSecureRequestInTheCaseOfDefault()
    {
        $this->assertFalse(
            $this->builder->isSecureRequest(), "The default value isn't secure.");
    }

    /**
     * set secure request
     */
    public function testSetSecureRequest()
    {
        $this->builder->setSecureRequest();
        $this->assertTrue(
            $this->builder->isSecureRequest(), "Did not secure request.");

        return $this->builder;
    }

    /**
     * reset secure request
     *
     * @depends testSetSecureRequest
     */
    public function testResetSecureRequest(Builder $builder)
    {
        $builder->resetSecureRequest();
        $this->assertFalse(
            $builder->isSecureRequest(), "This is secure request.");
    }

    /**
     * test generate canonical query string
     *
     * @dataProvider provideParameters
     */
    public function testGenerateCanonicalQueryString($parameters, $expect)
    {
        $this->assertSame(
            $expect, $this->builder->generateCanonicalQueryString($parameters),
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
            $this->builder->generateSignature(
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
        $this->builder->setLocale($locale);
        $this->assertSame(
            $expectEndPoint, $this->builder->getEndPoint(), "The end point wasn't same.");
    }

    public function provideEndPoints()
    {
        return array(
            array(Builder::LOCALE_CA, Builder::ENDPOINT_CA),
            array(Builder::LOCALE_CN, Builder::ENDPOINT_CN),
            array(Builder::LOCALE_DE, Builder::ENDPOINT_DE),
            array(Builder::LOCALE_ES, Builder::ENDPOINT_ES),
            array(Builder::LOCALE_FR, Builder::ENDPOINT_FR),
            array(Builder::LOCALE_IT, Builder::ENDPOINT_IT),
            array(Builder::LOCALE_JP, Builder::ENDPOINT_JP),
            array(Builder::LOCALE_UK, Builder::ENDPOINT_UK),
            array(Builder::LOCALE_US, Builder::ENDPOINT_US),
        );
    }
}
