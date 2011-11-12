<?php
/**
* This test file is a part of SinyAmazonProductAdvertisingAPIBundle package.
*
* @author Shinichiro Yuki <sinycourage@gmail.com>
*/

namespace Siny\Amazon\ProductAdvertisingAPIBundle\Tests\API\Request;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Request,
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
        $this->request = $this->createNewRequest();

        $operation = new BrowseNodeLookupOperation(self::DUMMY_BROWSE_NODE_ID);
        $this->request->setOperation($operation);
    }

    /**
     * get operation in the case of default
     */
    public function testGetOperationInTheCaseOfDefault()
    {
        $this->assertNull($this->createNewRequest()->getOperation(), "Returned wasn't a null.");
    }

    /**
     * returns class instance that extend an abstract operation class instance
     * when get operation
     */
    public function testReturnsClassExtendAnAbstractOperationWhenGetOperation()
    {
        $this->assertInstanceOf(
        	'Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation',
        	$this->request->getOperation(),
        	"A returned class wasn't class instance that extend an abstract operation class.");
    }

    /**
     * returns operation class instance that you set when you get operation
     */
    public function testReturnsOperationClassInstanceThatYouSetWhenYouGetOperation()
    {
        $request = $this->createNewRequest();
        $operation = new BrowseNodeLookupOperation(self::DUMMY_BROWSE_NODE_ID);
        $request->setOperation($operation);

        $this->assertSame(
            $operation, $request->getOperation(),
            "A returned class wasn't same class instance.");
    }

    /**
     * has Operation
     */
    public function testHasOperation()
    {
        $this->assertTrue($this->request->hasOperation(), "Has not operation.");
        $this->assertFalse($this->createNewRequest()->hasOperation(), "Has operation.");
    }

    /**
     * send, then return response object instance
     */
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
        $this->createNewRequest()->send();
    }

    /**
     * get request class instance
     *
     * @return Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Request
     */
    private function createNewRequest()
    {
        return new Request(
            self::DUMMY_AWS_ACCESS_KEY_ID,
            self::DUMMY_SECRET_ACCESS_KEY,
            self::DUMMY_ASSOCIATE_TAG,
            Request::LOCALE_JP
        );
    }
}
