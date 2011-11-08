<?php
/**
* This test file is a part of SinyAmazonProductAdvertisingAPIBundle package.
*
* @author Shinichiro Yuki <sinycourage@gmail.com>
*/

namespace Siny\Amazon\ProductAdvertisingAPIBundle\Tests\API;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request,
    Siny\Amazon\ProductAdvertisingAPIBundle\API\Response,
    Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation\BrowseNodeLookupOperation;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    const DUMMY_AWS_ACCESS_KEY_ID = 'dummy_aws_access_key_id';
    const DUMMY_SECRET_ACCESS_KEY = 'dummy_secret_access_key';
    const DUMMY_ASSOCIATE_TAG     = 'dummy_associate_tag';
    const DUMMY_BROWSE_NODE_ID    = 123456789;

    private $request;

    public function setUp()
    {
        $this->request = $this->getRequest();

        $operation = new BrowseNodeLookupOperation(self::DUMMY_BROWSE_NODE_ID);
        $this->request->setOperation($operation);
    }

    public function testGetOperationInTheCaseOfDefault()
    {
        $this->assertNull($this->getRequest()->getOperation(), "Returned wasn't a null.");
    }

    public function testReturnsClassExtendAnAbstractOperationWhenGetOperation()
    {
        $this->assertInstanceOf(
        	'Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation',
        	$this->request->getOperation(),
        	"A returned class wasn't class instance that extend an abstract operation class.");
    }

    public function testReturnsOperationClassInstanceThatYouSetWhenYouGetOperation()
    {
        $request = $this->getRequest();
        $operation = new BrowseNodeLookupOperation(self::DUMMY_BROWSE_NODE_ID);
        $request->setOperation($operation);

        $this->assertSame(
            $operation, $request->getOperation(),
            "A returned class wasn't same class instance.");
    }

    public function testSendThenReturnsResponseObjectInstance()
    {
        $this->assertInstanceOf(
        	'Siny\Amazon\ProductAdvertisingAPIBundle\API\Response',
        	$this->request->send(),
            "Did not return a 'Response' class instance.");
    }

    /**
     * @expectedException Siny\Amazon\ProductAdvertisingAPIBundle\API\Exception\RequestException
     * @expectedExceptionMessage Operation class instance was not found
     */
    public function testExceptionOccurIfYouSendBeforeSetOperationClassInstance()
    {
        $this->getRequest()->send();
    }

    private function getRequest()
    {
        return new Request(
            self::DUMMY_AWS_ACCESS_KEY_ID,
            self::DUMMY_SECRET_ACCESS_KEY,
            self::DUMMY_ASSOCIATE_TAG,
            Request::LOCALE_JP
        );
    }
}
