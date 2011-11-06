<?php
/**
 * This file is a part of SinyAmazonProductAdvertisingAPIBundle package.
 *
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation;

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
    const BROWSE_NODE_ID = 'BrowseNodeId';

    /**
     * set the browse node ID that you want to get.
     * this parameter is required for "BrowseNodeLookup" operation.
     *
     * @param integer $browseNodeId
     */
    public function __construct($browseNodeId)
    {
        parent::__construct(self::OPERATION);
        $this->setBrowseNodeId($browseNodeId);
    }

    /**
     * set browse node ID that you want to get.
     *
     * @param integer $browseNodeId
     */
    public function setBrowseNodeId($browseNodeId)
    {
        $this->setParameter(self::BROWSE_NODE_ID, $browseNodeId);
    }

    /**
     * get browse node ID that you want to get.
     *
     * @return integer a browse node ID
     */
    public function getBrowseNodeId()
    {
        return $this->getParameter(self::BROWSE_NODE_ID);
    }
}
