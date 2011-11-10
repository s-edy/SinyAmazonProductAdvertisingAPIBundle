<?php
/**
* This test file is a part of SinyAmazonProductAdvertisingAPIBundle package.
*
* @author Shinichiro Yuki <sinycourage@gmail.com>
*/

namespace Siny\Amazon\ProductAdvertisingAPIBundle\Tests\API;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\AbstractRequest;

class AbstractRequestTest extends \PHPUnit_Framework_TestCase
{
    const DUMMY_AWS_ACCESS_KEY_ID = 'dummy_aws_access_key_id';
    const DUMMY_SECRET_ACCESS_KEY = 'dummy_secret_access_key';
    const DUMMY_ASSOCIATE_TAG     = 'dummy_associate_tag';

    private $request;

    public function setUp()
    {
        $this->request = $this->getMockForAbstractClass(
            'Siny\Amazon\ProductAdvertisingAPIBundle\API\AbstractRequest',
            array(
                self::DUMMY_AWS_ACCESS_KEY_ID,
                self::DUMMY_SECRET_ACCESS_KEY,
                self::DUMMY_ASSOCIATE_TAG,
                AbstractRequest::LOCALE_JP,
            )
        );
    }

    /**
     * get AWS Access key ID in the case of default
     */
    public function testGetAwsAccessKeyIdInTheCaseOfDefault()
    {
        $this->assertSame(
            self::DUMMY_AWS_ACCESS_KEY_ID, $this->request->getAwsAccessKeyId(),
            "AWS access key ID wasn't same.");
    }

    /**
     * get Secret Access key in the case of default
     */
    public function testGetSecretAccessKeyInTheCaseOfDefault()
    {
        $this->assertSame(
            self::DUMMY_SECRET_ACCESS_KEY, $this->request->getSecretAccessKey(),
            "Secret access key wasn't same.");
    }

    /**
     * get Associate tag in the case of default
     */
    public function testGetAssociateTagInTheCaseOfDefault()
    {
        $this->assertSame(
            self::DUMMY_ASSOCIATE_TAG, $this->request->getAssociateTag(),
            "Associate tag wasn't same.");
    }

    /**
     * get Locale in the case of default
     */
    public function testGetLocaleInTheCaseOfDefault()
    {
        $this->assertSame(
            AbstractRequest::LOCALE_JP, $this->request->getLocale(),
            "Locale wasn't same.");
    }

    /**
     * get DateTime in the case of default
     */
    public function testGetDateTimeInTheCaseOfDefault()
    {
        $this->assertInstanceOf(
    		'\DateTime', $this->request->getDateTime(),
    		"A date time class wan't get");
    }

    /**
     * set/get DateTime
     */
    public function testSetGetDateTime()
    {
        $dateTime = new \DateTime();
        $this->request->setDateTime($dateTime);
        $this->assertSame(
            $dateTime->format(\DateTime::ISO8601),
            $this->request->getDateTime()->format(\DateTime::ISO8601),
            "A date time class wasn't same.");
    }

    /**
     * is secure request in the case of default
     */
    public function testIsSecureRequestInTheCaseOfDefault()
    {
        $this->assertFalse(
            $this->request->isSecureRequest(), "The default value isn't secure.");
    }

    /**
     * set secure request
     */
    public function testSetSecureRequest()
    {
        $this->request->setSecureRequest();
        $this->assertTrue(
            $this->request->isSecureRequest(), "Did not secure request.");
    }

    /**
     * reset secure request
     */
    public function testResetSecureRequest()
    {
        $this->request->resetSecureRequest();
        $this->assertFalse(
            $this->request->isSecureRequest(), "This is secure request.");
    }

    /**
     * test generate canonical query string
     *
     * @dataProvider provideParameters
     */
    public function testGenerateCanonicalQueryString($parameters, $expect)
    {
        $this->assertSame(
            $expect, $this->request->generateCanonicalQueryString($parameters),
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
            $this->request->generateSignature(
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
}
