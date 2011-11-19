<?php
/**
* This test file is a part of SinyAmazonProductAdvertisingAPIBundle package.
*
* @author Shinichiro Yuki <sinycourage@gmail.com>
*/

namespace Siny\Amazon\ProductAdvertisingAPIBundle\Tests\API\Request;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configuration;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    const DUMMY_KEY   = 'dummyKey';
    const DUMMY_VALUE = 'dummyValue';
    const DUMMY_AWS_ACCESS_KEY_ID = 'dummy_aws_access_key_id';
    const DUMMY_SECRET_ACCESS_KEY = 'dummy_secret_access_key';
    const DUMMY_ASSOCIATE_TAG     = 'dummy_associate_tag';

    private $configuration;
    private $dateTime;

    public function setUp()
    {
        $this->configuration = new Configuration(
            self::DUMMY_AWS_ACCESS_KEY_ID,
            self::DUMMY_SECRET_ACCESS_KEY,
            self::DUMMY_ASSOCIATE_TAG,
            Configuration::LOCALE_JP);
        $this->dateTime = new \DateTime();
    }

    /**
     * Get all parameters
     *
     * @dataProvider provideGetAll
     */
    public function testGetAllInTheCaseOfDefault(array $expected)
    {
        $parameters = $this->configuration->getAll();
        ksort($expected);
        ksort($parameters);
        $this->assertSame($expected, $parameters, "The returned parameters waren't same.");

        return $this->configuration;
    }

    /**
     * provide parameters for getAll()
     */
    public function provideGetAll()
    {
        return array(
            array(array(
                Configuration::KEY_NAME_SERVICE           => Configuration::SERVICE_NAME,
                Configuration::KEY_NAME_AWS_ACCESS_KEY_ID => self::DUMMY_AWS_ACCESS_KEY_ID,
                Configuration::KEY_NAME_ASSOCIATE_TAG     => self::DUMMY_ASSOCIATE_TAG,
                Configuration::KEY_NAME_VERSION           => Configuration::API_VERSION,
            )),
        );
    }

    /**
     * get AWS Access key ID in the case of default
     */
    public function testGetAwsAccessKeyIdInTheCaseOfDefault()
    {
        $this->assertSame(
            self::DUMMY_AWS_ACCESS_KEY_ID, $this->configuration->getAwsAccessKeyId(),
            "AWS access key ID wasn't same.");

        return $this->configuration;
    }

    /**
     * get Secret Access key in the case of default
     */
    public function testGetSecretAccessKeyInTheCaseOfDefault()
    {
        $this->assertSame(
            self::DUMMY_SECRET_ACCESS_KEY, $this->configuration->getSecretAccessKey(),
            "Secret access key wasn't same.");

        return $this->configuration;
    }

    /**
     * get Associate tag in the case of default
     */
    public function testGetAssociateTagInTheCaseOfDefault()
    {
        $this->assertSame(
            self::DUMMY_ASSOCIATE_TAG, $this->configuration->getAssociateTag(),
            "Associate tag wasn't same.");

        return $this->configuration;
    }

    /**
     * get Locale in the case of default
     */
    public function testGetLocaleInTheCaseOfDefault()
    {
        $this->assertSame(
            Configuration::LOCALE_JP, $this->configuration->getLocale(),
            "Locale wasn't same.");
    }

    /**
     * get date time in the case of default
     */
    public function testGetDateTimeInTheCaseOfDefault()
    {
        $this->assertSame(
            0, $this->dateTime->diff($this->configuration->getDateTime(), true)->s,
        	"The date time which is set wasn't now.");

        return $this->configuration;
    }

    /**
     * is secure request in the case of default
     */
    public function testIsSecureRequestInTheCaseOfDefault()
    {
        $this->assertFalse(
            $this->configuration->isSecureRequest(), "The default value isn't secure.");

        return $this->configuration;
    }

    /**
     * is method GET in the case of default
     */
    public function testIsMethodGETInTheCaseOfDefault()
    {
        $this->assertTrue($this->configuration->isMethodGET(), "The method was GET.");
        $this->assertFalse($this->configuration->isMethodPOST(), "The method was GET.");

        return $this->configuration;
    }

    /**
     * get end point
     *
     * @dataProvider provideEndPoints
     *
     * @param string $locale
     * @param string $expectEndPoint
     */
    public function testGetEndPointInTheCaseOfDefault($locale, $expectEndPoint)
    {
        $configuration = new Configuration(
            self::DUMMY_AWS_ACCESS_KEY_ID,
            self::DUMMY_SECRET_ACCESS_KEY,
            self::DUMMY_ASSOCIATE_TAG,
            $locale);

        $this->assertSame(
            $expectEndPoint, $configuration->getEndPoint(), "The end point wasn't same.");
    }

    public function provideEndPoints()
    {
        return array(
        array(Configuration::LOCALE_CA, Configuration::ENDPOINT_CA),
        array(Configuration::LOCALE_CN, Configuration::ENDPOINT_CN),
        array(Configuration::LOCALE_DE, Configuration::ENDPOINT_DE),
        array(Configuration::LOCALE_ES, Configuration::ENDPOINT_ES),
        array(Configuration::LOCALE_FR, Configuration::ENDPOINT_FR),
        array(Configuration::LOCALE_IT, Configuration::ENDPOINT_IT),
        array(Configuration::LOCALE_JP, Configuration::ENDPOINT_JP),
        array(Configuration::LOCALE_UK, Configuration::ENDPOINT_UK),
        array(Configuration::LOCALE_US, Configuration::ENDPOINT_US),
        );
    }

    /**
     * set Configuration object will be returned When Invoking setAWSAccessKeyId
     *
     * @param Configuration $configuration
     * @depends testGetAwsAccessKeyIdInTheCaseOfDefault
     */
    public function testConfigurationObjectWillBeReturnedWhenInvokingSetAWSAccessKeyId(Configuration $configuration)
    {
        $returned = $configuration->setAWSAccessKeyId('OverrideAWSAccessKeyID');
        $this->assertInstanceOf(
            'Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configuration',
            $returned,
        	"The configuration object wasn't returned after invoking setAWSAccessKeyId().");
        return $returned;
    }

    /**
     * Get AWS access key ID
     *
     * @param Configuration $configuration
     * @depends testConfigurationObjectWillBeReturnedWhenInvokingSetAWSAccessKeyId
     */
    public function testGetAWSAccessKeyId(Configuration $configuration)
    {
        $this->assertSame(
        	'OverrideAWSAccessKeyID', $configuration->getAWSAccessKeyId(),
        	"An AWS access key ID wasn't same.");
    }

    /**
     * Set Configuration object will be returned When Invoking setSecretAccessKey
     *
     * @param Configuration $configuration
     * @depends testGetSecretAccessKeyInTheCaseOfDefault
     */
    public function testConfigurationObjectWillBeReturnedWhenInvokingSetSecretAccessKey(Configuration $configuration)
    {
        $returned = $configuration->setSecretAccessKey('OverrideSecretAccessKey');
        $this->assertInstanceOf(
    		'Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configuration',
            $returned,
            "The configuration object wasn't returned after invoking setSecretAccessKey().");
        return $returned;
    }

    /**
     * Get Secret access key
     *
     * @param Configuration $configuration
     * @depends testConfigurationObjectWillBeReturnedWhenInvokingSetSecretAccessKey
     */
    public function testGetSecretAccessKey(Configuration $configuration)
    {
        $this->assertSame(
        	'OverrideSecretAccessKey', $configuration->getSecretAccessKey(),
        	"A secret access key wasn't same.");
    }

    /**
     * Set Configuration object will be returned When Invoking setAssociateTag
     *
     * @param Configuration $configuration
     * @depends testGetAssociateTagInTheCaseOfDefault
     */
    public function testConfigurationObjectWillBeReturnedWhenInvokingSetAssociateTag(Configuration $configuration)
    {
        $returned = $configuration->setAssociateTag('OverrideAssociateTag');
        $this->assertInstanceOf(
    		'Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configuration',
            $returned,
            "The configuration object wasn't returned after invoking setAssociateTag().");
        return $returned;
    }

    /**
     * Get associate tag
     *
     * @param Configuration $configuration
     * @depends testConfigurationObjectWillBeReturnedWhenInvokingSetAssociateTag
     */
    public function testGetAssociateTag(Configuration $configuration)
    {
        $this->assertSame(
    		'OverrideAssociateTag', $configuration->getAssociateTag(),
        	"A associate tag wasn't same.");
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
        $this->configuration->setLocale($locale);
        $this->assertSame(
            $locale, $this->configuration->getLocale(),
            "a specified locale wasn't same.");
    }

    public function provideLocales()
    {
        return array(
            array(Configuration::LOCALE_CA),
            array(Configuration::LOCALE_CN),
            array(Configuration::LOCALE_DE),
            array(Configuration::LOCALE_ES),
            array(Configuration::LOCALE_FR),
            array(Configuration::LOCALE_IT),
            array(Configuration::LOCALE_JP),
            array(Configuration::LOCALE_UK),
            array(Configuration::LOCALE_US),
        );
    }

    /**
     * Exception will occur if the wrong locale is set
     *
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage A specified locale was wrong. locale=[wrong]
     */
    public function testExceptionWillOccurIfTheWrongLocaleIsSet()
    {
        $this->configuration->setLocale('wrong');
    }

    /**
     * set/get DateTime
     */
    public function testSetGetDateTime()
    {
        $dateTime = new \DateTime();
        $this->configuration->setDateTime($dateTime);
        $this->assertSame(
            0, $dateTime->diff($this->configuration->getDateTime(), true)->s,
            "A date time class wasn't same.");
    }

    /**
     * Set Configuration object will be returned When Invoking setSecureRequest()
     *
     * @param Configuration $configuration
     * @depends testIsSecureRequestInTheCaseOfDefault
     */
    public function testConfigurationObjectWillBeReturnedWhenInvokingSetSecureRequest(Configuration $configuration)
    {
        $returned = $configuration->setSecureRequest();
        $this->assertInstanceOf(
    		'Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configuration',
            $returned,
            "The configuration object wasn't returned after invoking setSecureRequest().");
        return $returned;
    }

    /**
     * Is secure request ?
     *
     * @depends testConfigurationObjectWillBeReturnedWhenInvokingSetSecureRequest
     */
    public function testIsSecureRequestAfterSetSecureRequest(Configuration $configuration)
    {
        $this->assertTrue(
            $configuration->isSecureRequest(), "This was not a secure request.");

        return $configuration;
    }

    /**
     * Set Configuration object will be returned When Invoking resetSecureRequest()
     *
     * @param Configuration $configuration
     * @depends testIsSecureRequestAfterSetSecureRequest
     */
    public function testConfigurationObjectWillBeReturnedWhenInvokingResetSecureRequest(Configuration $configuration)
    {
        $returned = $configuration->resetSecureRequest();
        $this->assertInstanceOf(
        	'Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configuration',
            $returned,
            "The configuration object wasn't returned after invoking resetSecureRequest().");
        return $returned;
    }

    /**
     * Reset secure request
     *
     * @depends testConfigurationObjectWillBeReturnedWhenInvokingResetSecureRequest
     */
    public function testIsSecureRequestAfterResetSecureRequest(Configuration $configuration)
    {
        $this->assertFalse(
            $configuration->isSecureRequest(), "This was a secure request unexpectedly.");
    }


    /**
     * Set Configuration object will be returned When Invoking setPOSTMethod()
     *
     * @param Configuration $configuration
     * @depends testIsMethodGETInTheCaseOfDefault
     */
    public function testConfigurationObjectWillBeReturnedWhenInvokingSetPOSTMethod(Configuration $configuration)
    {
        $returned = $configuration->setPOSTMethod();
        $this->assertInstanceOf(
    		'Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configuration',
            $returned,
            "The configuration object wasn't returned after invoking setPOSTMethod().");
        return $returned;
    }

    /**
     * Is method POST ?
     *
     * @depends testConfigurationObjectWillBeReturnedWhenInvokingSetPOSTMethod
     */
    public function testIsMethodPOSTAfterSetPOSTMethod(Configuration $configuration)
    {
        $this->assertTrue($configuration->isMethodPOST(), "This was not a POST method.");
        $this->assertFalse($configuration->isMethodGET(), "This was a POST method.");
        return $configuration;
    }

    /**
     * Set Configuration object will be returned When Invoking setGETMethod()
     *
     * @param Configuration $configuration
     * @depends testIsMethodPOSTAfterSetPOSTMethod
     */
    public function testConfigurationObjectWillBeReturnedWhenInvokingSetGETMethod(Configuration $configuration)
    {
        $returned = $configuration->setGETMethod();
        $this->assertInstanceOf(
        	'Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configuration',
            $returned,
        	"The configuration object wasn't returned after invoking setGETMethod().");
        return $returned;
    }

    /**
    * Is method GET ?
    *
    * @depends testConfigurationObjectWillBeReturnedWhenInvokingSetGETMethod
    */
    public function testIsMethodGETAfterSetGETMethod(Configuration $configuration)
    {
        $this->assertTrue($configuration->isMethodGET(), "This was not a GET method.");
        $this->assertFalse($configuration->isMethodPOST(), "This was a GET method.");
        return $configuration;
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
        $this->configuration->setLocale($locale);
        $this->assertSame(
            $expectEndPoint, $this->configuration->getEndPoint(), "The end point wasn't same.");
    }

    /**
     * A configuration object will be returned after you set something
     *
     * @return Configuration
     */
    public function testConfigurationObjectWillBeReturnAfterYouSet()
    {
        $this->assertInstanceOf(
        	'Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configuration',
        	$this->configuration->set(self::DUMMY_KEY, self::DUMMY_VALUE),
        	"The configuration object wasn't returned after you set something.");

        return $this->configuration;
    }

    /**
     * Get parameter
     *
     * @depends testConfigurationObjectWillBeReturnAfterYouSet
     * @param Configuration $configuration
     */
    public function testGet(Configuration $configuration)
    {
        $this->assertSame(
            self::DUMMY_VALUE, $configuration->get(self::DUMMY_KEY),
            "Get value wasn't same.");

        return $configuration;
    }

    /**
     * Exception will occur if trying to get when specifying a wrong key
     *
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage The value of speficied key index was not found. key=[dummyKey]
     */
    public function testExceptionWillOccurIfTryingToGetWhenSpecifyingAWrongKey()
    {
        $this->configuration->get(self::DUMMY_KEY);
    }

    /**
     * Has parameter you specified key
     *
     * @dataProvider provideHas
     */
    public function testHasParameterYouSpecifiedKey($expected, $key, $message)
    {
        $this->assertSame($expected, $this->configuration->has($key), $message);
    }

    public function provideHas()
    {
        return array(
            array(true, Configuration::KEY_NAME_AWS_ACCESS_KEY_ID, "the key which should exist wasn't found."),
            array(false, self::DUMMY_KEY, "the key which shouldn't exist was found."),
        );
    }

    /**
     * Clear all parameters
     *
     * @depends testGet
     * @param Configuration $configuration
     */
    public function testConfigurationObjectWillBeReturnedWhenInvokingClear(Configuration $configuration)
    {
        $returned = $configuration->clear();
        $this->assertInstanceOf(
        	'Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configuration',
        	$returned,
        	"The configuration object wasn't returned after invoking clear method.");

        return $returned;
    }

    /**
     * Whether there are values in the parameter or not after invoking clear() ?
     *
     * @depends testConfigurationObjectWillBeReturnedWhenInvokingClear
     * @param Configuration $configuratin
     */
    public function testWhetherThereAreOnlyDefaultValuesInTheParameterOrNotAfterInvokingClear(Configuration $configuratin)
    {
        $this->assertEmpty($configuratin->getAll(), "There are the parameters.");
    }
}
