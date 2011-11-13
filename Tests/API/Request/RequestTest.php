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
    }

    /**
     * get operation in the case of default
     */
    public function testGetOperationInTheCaseOfDefault()
    {
        $this->assertInstanceOf(
        	'Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation',
            $this->createNewRequest()->getOperation(),
        	"Operation was null in the case of default.");
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
     * get a Request method in the case of default
     */
    public function testGetMethodInTheCaseOfDefault()
    {
        $this->assertSame(
            Request::METHOD_GET, $this->request->getMethod(),
            "A request method as a default parameter wasn't returned.");
    }

    /**
     * get request class instance
     *
     * @return Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Request
     */
    private function createNewRequest()
    {
        return new Request(
            new BrowseNodeLookupOperation(self::DUMMY_BROWSE_NODE_ID));
    }
}
