<?php
/**
 * This test file is an Example of SinyAmazonProductAdvertisingAPIBundle package.
 *
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\Tests;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Sender;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configurable;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configuration;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Builder;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Request;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation\BrowseNodeLookupOperation;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Response;

class ExampleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * This is example
     *
     * @test
     */
    public function example()
    {
        // Configuration variables
        $awsAccessKeyId  = 'XXXXXXXXXXXXXXXXXXXX';
        $secretAccessKey = 'YYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYY';
        $associateTag    = 'ZZZZZZZZZZZ';
        $endPoint        = Configurable::ENDPOINT_JP;

        // Operation variable
        $browseNodeId = '999999';

        // Build a sender
        $configuration = new Configuration($awsAccessKeyId, $secretAccessKey, $associateTag, $endPoint);
        $builder = new Builder($configuration);
        $sender = new Sender($builder);

        // make a new Operation
        $operation = new BrowseNodeLookupOperation($browseNodeId);

        // create a sending request
        $request = new Request($operation);

        // send
        $response = $sender->send($request);
    }
}

