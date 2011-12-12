<?php
/**
* This test file is a part of SinyAmazonProductAdvertisingAPIBundle package.
*
* @author Shinichiro Yuki <sinycourage@gmail.com>
*/

namespace Siny\Amazon\ProductAdvertisingAPIBundle\Tests\API;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Response;
use \HttpMessage;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    private $response;

    public function setUp()
    {
        $httpMessage = new HttpMessage();
        $httpMessage->setType(HTTP_MSG_RESPONSE);
        $httpMessage->setResponseCode(200);
        $this->response = new Response($httpMessage);
    }

    /**
     * Get builder in the case of default.
     */
    public function testIsSuccess()
    {
        $this->assertTrue($this->response->isSuccess(), "This is a failure response.");
    }
}
