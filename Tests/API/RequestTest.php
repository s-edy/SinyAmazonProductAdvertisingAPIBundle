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

    public function testGetAwsAccessKeyIdInTheCaseOfDefault()
    {
        $this->assertSame(
            self::DUMMY_AWS_ACCESS_KEY_ID, $this->request->getAwsAccessKeyId(),
        	"AWS access key ID wasn't same.");
    }

    public function testGetSecretAccessKeyInTheCaseOfDefault()
    {
        $this->assertSame(
            self::DUMMY_SECRET_ACCESS_KEY, $this->request->getSecretAccessKey(),
        	"Secret access key wasn't same.");
    }

    public function testGetAssociateTagInTheCaseOfDefault()
    {
        $this->assertSame(
            self::DUMMY_ASSOCIATE_TAG, $this->request->getAssociateTag(),
        	"Associate tag wasn't same.");
    }
}
