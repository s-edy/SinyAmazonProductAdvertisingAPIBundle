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
    const BODY_SUCCESS = '<?xml version="1.0" encoding="UTF-8"?><BrowseNodeLookupResponse xmlns="http://webservices.amazon.com/AWSECommerceService/2010-09-01"><OperationRequest><HTTPHeaders><Header Name="UserAgent" Value="PECL::HTTP/1.7.1 (PHP/5.3.8)"></Header></HTTPHeaders><RequestId>RRRRRRRRRRRRRRRRRRRR</RequestId><Arguments><Argument Name="Service" Value="AWSECommerceService"></Argument><Argument Name="Operation" Value="BrowseNodeLookup"></Argument><Argument Name="Timestamp" Value="2011-12-13T19:53:58+0000"></Argument><Argument Name="Version" Value="2010-09-01"></Argument><Argument Name="AssociateTag" Value="gggggggg-22"></Argument><Argument Name="Signature" Value="kkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk"></Argument><Argument Name="BrowseNodeId" Value="999999"></Argument><Argument Name="AWSAccessKeyId" Value="JJJJJJJJJJJJJJJJJJJJ"></Argument></Arguments><RequestProcessingTime>0.00673389434814453</RequestProcessingTime></OperationRequest><BrowseNodes><Request><IsValid>True</IsValid><BrowseNodeLookupRequest><BrowseNodeId>999999</BrowseNodeId></BrowseNodeLookupRequest></Request><BrowseNode><BrowseNodeId>999999</BrowseNodeId><Name>foo</Name><Ancestors><BrowseNode><BrowseNodeId>999998</BrowseNodeId><Name>wwwww</Name><IsCategoryRoot>1</IsCategoryRoot><Ancestors><BrowseNode><BrowseNodeId>555555</BrowseNodeId><Name>VVV</Name></BrowseNode></Ancestors></BrowseNode></Ancestors></BrowseNode></BrowseNodes></BrowseNodeLookupResponse>';
    const BODY_ERROR   = '<BrowseNodeLookupErrorResponse xmlns="http://ecs.amazonaws.com/doc/2010-09-01/"><Error><Code>InvalidClientTokenId</Code><Message>The AWS Access Key Id you provided does not exist in our records.</Message></Error><RequestID>eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee</RequestID></BrowseNodeLookupErrorResponse>';

    private $response;

    public function setUp()
    {
        $httpMessage = new HttpMessage();
        $httpMessage->setType(HTTP_MSG_RESPONSE);
        $httpMessage->setResponseCode(200);
        $httpMessage->setBody(self::BODY_SUCCESS);
        $this->response = new Response($httpMessage);
    }

    /**
     * Get builder in the case of default.
     *
     * @dataProvider provideIsSuccess
     */
    public function testIsSuccess($code, $expected, $message)
    {
        $httpMessage = new HttpMessage();
        $httpMessage->setType(HTTP_MSG_RESPONSE);
        $httpMessage->setResponseCode($code);
        $response = new Response($httpMessage);
        $this->assertSame($expected, $response->isSuccess(), $message);
    }
    public function provideIsSuccess()
    {
        $provides = array();
        foreach (array(200, 404, 403, 500, 503) as $code) {
            if ($code === 200) {
                $provides[] = array($code, true, "This is a failure response.");
            } else {
                $provides[] = array($code, false, "This is NOT a failure response.");
            }
        }
        return $provides;
    }

    /**
     * Get Raw body
     */
    public function testGetRawBody()
    {
        $this->assertSame(self::BODY_SUCCESS, $this->response->getRawBody(), "Got response wasn't same.");
    }
}
