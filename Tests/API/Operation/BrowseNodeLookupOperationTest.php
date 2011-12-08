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
     * toArray in the case of default
     *
     * @dataProvider provideToArrayInTheCaseOfDefault
     */
    public function testToArrayInTheCaseOfDefault($expects)
    {
        $this->assertSame($expects, $this->operation->toArray(), "The array waren't same.");
    }
    public function provideToArrayInTheCaseOfDefault()
    {
        return array(
            array(array('Operation' => 'BrowseNodeLookup', 'BrowseNodeId' => self::DUMMY_BROWSE_NODE_ID))
        );
    }

    /**
     * Set BrowseNodeID
     *
     * @dataProvider provideSetBrowseNodeId
     */
    public function testSetBrowseNodeId($newBrowseNodeId, $expects)
    {
        $this->operation->setBrowseNodeId($newBrowseNodeId);
        $this->assertSame($expects, $this->operation->toArray(), "The BrowseNodeID which is set newly wasn't same");
    }
    public function provideSetBrowseNodeId()
    {
        return array(
            array(987654321, array('Operation' => 'BrowseNodeLookup', 'BrowseNodeId' => 987654321)),
        );
    }
}
