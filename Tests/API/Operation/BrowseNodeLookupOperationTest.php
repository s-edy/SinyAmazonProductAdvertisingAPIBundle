<?php

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

    public function testGetOperationInTheCaseOfDefault()
    {
        $this->assertSame(
            BrowseNodeLookupOperation::OPERATION,
            $this->operation->getOperation(),
            "Operation wasn't same.");
    }

    public function testGetBrowseNodeIdInTheCaseOfDefault()
    {
        $this->assertSame(
            self::DUMMY_BROWSE_NODE_ID,
            $this->operation->getBrowseNodeId(),
            "Browse node ID wasn't saem.");
    }

    public function testSetBrowseNodeId()
    {
        $newBrowseNodeId = 987654321;
        $this->operation->setBrowseNodeId($newBrowseNodeId);

        $this->assertSame(
            $newBrowseNodeId, $this->operation->getBrowseNodeId(),
            "The browse node ID that is set newly wasn't same");
    }
}
