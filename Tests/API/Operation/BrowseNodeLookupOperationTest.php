<?php
/**
* This test file is a part of SinyAmazonProductAdvertisingAPIBundle package.
*
* @author Shinichiro Yuki <sinycourage@gmail.com>
*/

namespace Siny\Amazon\ProductAdvertisingAPIBundle\Tests\API\Operation;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation\BrowseNodeLookupOperation;

class BrowseNodeLookupOperationTest extends \PHPUnit_Framework_TestCase
{
    const DUMMY_BROWSE_NODE_ID = 123456789;

    private $operation;

    public function setUp()
    {
        $this->operation = new BrowseNodeLookupOperation(self::DUMMY_BROWSE_NODE_ID);
    }

    /**
     * get operation in the case of default
     */
    public function testGetOperationInTheCaseOfDefault()
    {
        $this->assertSame(
            BrowseNodeLookupOperation::OPERATION,
            $this->operation->getOperationName(),
            "Operation wasn't same.");
    }

    /**
     * get Browse node ID in the case of default
     */
    public function testGetBrowseNodeIdInTheCaseOfDefault()
    {
        $this->assertSame(
            self::DUMMY_BROWSE_NODE_ID,
            $this->operation->getBrowseNodeId(),
            "Browse node ID wasn't saem.");
    }

    /**
     * set Browse node ID
     */
    public function testSetBrowseNodeId()
    {
        $newBrowseNodeId = 987654321;
        $this->operation->setBrowseNodeId($newBrowseNodeId);

        $this->assertSame(
            $newBrowseNodeId, $this->operation->getBrowseNodeId(),
            "The browse node ID that is set newly wasn't same");
    }
}
