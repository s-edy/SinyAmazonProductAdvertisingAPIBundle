<?php

namespace Siny\Amazon\ProductAdvertisingAPIBundle\Tests\API;

use Symfony\Component\DependencyInjection\ContainerBuilder,
    Siny\Amazon\ProductAdvertisingAPIBundle\DependencyInjection\SinyAmazonProductAdvertisingAPIExtension,
    Siny\Amazon\ProductAdvertisingAPIBundle\API\Request;

class DefaultControllerTest extends \PHPUnit_Framework_TestCase
{
    const DUMMY_AWS_ACCESS_KEY_ID = 'dummy_aws_access_key_id';
    const DUMMY_SECRET_ACCESS_KEY = 'dummy_secret_access_key';
    const DUMMY_ASSOCIATE_TAG     = 'dummy_associate_tag';

    private $request;

    public function setUp()
    {
        $this->request = new Request(
            self::DUMMY_AWS_ACCESS_KEY_ID,
            self::DUMMY_SECRET_ACCESS_KEY,
            self::DUMMY_ASSOCIATE_TAG,
            Request::LOCALE_JP);
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
            Request::LOCALE_JP, $this->request->getLocale(),
        	"Locale wasn't same.");
    }
}
