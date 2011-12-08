<?php
/**
 * This file is a part of SinyAmazonProductAdvertisingAPIBundle package.
 *
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation\Operation;

/**
 * This is a class to send BrowseNodeLookup operation
 * for the Amazon Product Advertising API.
 *
 * @package SinyAmazonProductAdvertisingAPI
 * @subpackage Operation
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */
class BrowseNodeLookupOperation extends Operation
{
    // Operation name
    const OPERATION = 'BrowseNodeLookup';

    // Browse node ID (required parameter)
    const KEY_BROWSE_NODE_ID = 'BrowseNodeId';

    /**
     * Set the BrowseNodeID which is wanted to retrieve from Amazon.
     * This is a required parameter for "BrowseNodeLookup" operation.
     *
     * @param integer $browseNodeId
     */
    public function __construct($browseNodeId)
    {
        $this->set(self::KEY_OPERATION, self::OPERATION);
        $this->setBrowseNodeId($browseNodeId);
    }

    /**
     * Set BrowseNodeID which is wanted to retrieve from Amazon.
     *
     * @param integer $browseNodeId
     */
    public function setBrowseNodeId($browseNodeId)
    {
        $this->set(self::KEY_BROWSE_NODE_ID, $browseNodeId);
    }
}
